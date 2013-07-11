<?php
App::uses('ToastyCoreAppModel', "ToastyCore.Model");
App::uses('MediaBase', 'ToastyCore.Model');
App::uses('MediaDirectory', "ToastyCore.Model");

App::uses("Folder", "Utility");
App::uses("File", "Utility");


/**
 * Media Model
 *
 * @property MediaDirectory $MediaDirectory
 */
class Media extends MediaBase {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

    public $name = 'Media';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'media_directory_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isunique' => array(
				'rule' => array('checkName', false),
				'message' => 'A file with this name and type already exists',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isunique_edit' => array(
				'rule' => array('checkName', true),
				'message' => 'A file with this name and type already exists',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'update', // Limit validation to 'create' or 'update' operations
			)		
		),
		'system_path' => array(
			'notempty' => array(
				'rule' => array('checkSyspath'),
				'message' => 'Select a file to uploads',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public function checkSyspath($path) {

		$sp =$path['system_path'];
	    return $this->isFileValue($sp) && !empty($sp);

	}

	public function checkName($check, $edit = false) {

		$name = $check['name'];
		$type = $this->data['Media']['type'];

		$same_name = false;
		if ($edit) {
			$old = $this->findById($this->data['Media']['id']);

			$name = trim($name);

			$same_name = $name === $old['Media']['name'];
			$same_type = $type === $old['Media']['type'];

			if ($same_name && $same_type) {
				return true;
			}
		}

		$mid = $this->data['Media']['media_directory_id'];

		$path_string = $this->getPathString($mid);

		$name = "$path_string/$name";

		$options['conditions'] = array(
			'Media.system_path LIKE' => "$name.%",
			'Media.type LIKE' => $type
		);
		// $options['fields'] = array('Media.system_path', 'Media.system_path');

		$others = $this->find('first', $options);

		debug($name);
        debug($others);

		return empty($others);

	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'MediaDirectory' => array(
			'className' => 'MediaDirectory',
			'foreignKey' => 'media_directory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


    public function beforeSave($options = array()) {

    	parent::beforeSave($options);

    	$data = $this->data;

    	if (isset($data['bypass'])) {
    		return true;
    	}


        $system_path = null;

        if (isset($data['Media'])) {

            $system_path = $data['Media']['system_path'];
            $key = 'Media';

        } else {

        	return false;

        }


        $is_file_flag = $this->isFileValue($system_path);
        $previous_value_set_flag = isset($data['Media']['previous_value']);

        $current_path = $this->getPathString($data['Media']['media_directory_id']); // always ends with a slash

    	$name = $data['Media']['name'];

        $current_full_path = ""; // don't set it just yet

        if ($is_file_flag) {

        	$file = $system_path; // alias system_path is a weird name

        	if ($previous_value_set_flag) {

        		$previous_full_path = $data['Media']['previous_value'];

        		$old_file = new File($previous_full_path);
        		$old_file->delete();

        	}

    		$upload_options = array(
	    		'name' => $name,
	    		'file' => $file
			);

    		$current_full_path = $this->uploadFile($upload_options, $current_path, true);

    		if (!empty($current_full_path)) {

	        	$data['Media']['system_path'] = $current_full_path;

	        } else {

	        	throw new Exception("An error occured while uploading the file", 1);
	        	
	        }

        } else {

        	if($previous_value_set_flag) {

        		$previous_full_path = $data['Media']['previous_value'];
        		$ext = $this->getFileExt($previous_full_path);


        		$current_full_path = "$current_path$name.$ext";
        		if ($current_full_path !== $previous_full_path) {

        			$old_file = new File($previous_full_path);
        			$old_file->copy($current_full_path);
        			$old_file->delete();

        		}

        		$data['Media']['system_path'] = $current_full_path;

        	} else {

        		return false;

        	}

        }


        if (!empty($data[$key]['system_path'])) {

            $this->data = $data;

            return true;
            
        }

        return false;
    }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($options);

        $this->read();

        $system_path = $this->data['Media']['system_path'];
        
        $file = new File($system_path);

        if ($file->exists()) {

	        $file->delete();

	    }

        return true;
    }

        public function updatePath($id) {

	        $me = $this->findById($id);


	        $full_path = $this->getPathString($me['MediaDirectory']['id']);

	        $name = $me['Media']['name'];

	        $system_path = $me['Media']['system_path'];
	                
        	$ext = substr($system_path, strrpos($system_path, ".") + 1);	        

	        $full_path = $full_path . "$name.$ext";

	        $me['Media']['system_path'] = $full_path;

	        $me['bypass'] = true;

	        $this->data = $me;

	        $this->save($me);

	    }

    
}
