<?php
App::uses('ToastyCoreAppModel', "ToastyCore.Model");
App::uses('MediaDirectory', "ToastyCore.Model");

App::uses("Folder", "Utility");
App::uses("File", "Utility");


/**
 * TFile Model
 *
 * @property MediaDirectory $MediaDirectory
 */
class TFile extends ToastyCoreAppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

    public $name = 'TFile';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
				'message' => 'A file with this name already exists in this directory',
			)		
		)
		
	);


	public function checkName($check, $edit = false) {

		$name = $check['name'];

    if (!isset( $this->data[$this->alias]['t_directory_id'])) {

          $tDIrecoryId = $this->find(
              'first',
              array(
                  'conditions' => array('TFile.id' => $this->data[$this->alias]['id']),
                  'fields' => 't_directory_id'
              )
          );

          $tDIrecoryId = $tDIrecoryId[$this->alias]['t_directory_id'];

      } else {

          $tDIrecoryId = $this->data[$this->alias]['t_directory_id'];
      }



		if ($tDIrecoryId) {

			$directory = $this->TDirectory->findById($tDIrecoryId);

			$children = $directory[$this->alias];
			foreach ($children as $child) {
                if ($name == $child['name']) {

                	return false;
                    
                }
            }

		} else {

			return "A directory must be specified";

		}

		return true;
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */

	public $belongsTo = array(
		'TDirectory' => array(
			'className' => 'ToastyCore.TDirectory',
		)
	);

	// before saving 
    // if the directory is new (id not present), create the directory
    // if this is an existing directory and a previous_state array is in the data
    //      if name is present, check if changed. If so get the path, find the directory with that name, and move it to the new name it
    //      if t_directory_id is present, check if changed. If so, get the path, find the directory with that path and move it

    public function beforeSave($options = array()) {


        parent::beforeSave($options);

        $data = $this->data;

        if (isset($data['bypass'])) {
            return true;
        }

        if (!isset( $this->data[$this->alias]['t_directory_id'])) {

            $tDIrecoryId = $this->find(
                'first',
                array(
                    'conditions' => array('TFile.id' => $this->data[$this->alias]['id']),
                    'fields' => 't_directory_id'
                )
            );

            $tDIrecoryId = $tDIrecoryId[$this->alias]['t_directory_id'];

        } else {

            $tDIrecoryId = $this->data[$this->alias]['t_directory_id'];
        }




        
        $name = $data[$this->alias]['name']; // what if name is null (root)

        $name = $this->TDirectory->normalizeName($name);
        $parentPath = $this->TDirectory->getPathFromId($tDIrecoryId);
        
        if (isset($data[$this->alias]['id'])) {
	        $existingFile = $this->findById($data[$this->alias]['id']);
	        

        	$previousPath = $this->TDirectory->getPathFromId($existingFile[$this->alias]['t_directory_id']);
            $previousPath = $this->TDirectory->getAbsolutePath($previousPath);
        	$previousPath .= $existingFile[$this->alias]['name'];
        }
            
        $newPath = $this->TDirectory->getAbsolutePath($parentPath);
        $newPath = $newPath . $name;

        
        if (isset($previousPath) && is_file($previousPath)) {
            $file = new File($previousPath);
            $success = $file->copy($newPath) && $file->delete($newPath);
        } else {
            $file = new File($newPath, true, 0775);
            $success = $file->exists();

        }

        return $success;

    }


   //  public function beforeSave($options = array()) {

   //  	parent::beforeSave($options);

   //  	$data = $this->data;

   //  	if (isset($data['bypass'])) {
   //  		return true;
   //  	}


   //      $system_path = null;

   //      if (isset($data['Media'])) {

   //          $system_path = $data['Media']['system_path'];
   //          $key = 'Media';

   //      } else {

   //      	return false;

   //      }


   //      $is_file_flag = $this->isFileValue($system_path);
   //      $previous_value_set_flag = isset($data['Media']['previous_value']);

   //      $current_path = $this->getPathString($data['Media']['media_directory_id']); // always ends with a slash

   //  	$name = $data['Media']['name'];

   //      $current_full_path = ""; // don't set it just yet

   //      if ($is_file_flag) {

   //      	$file = $system_path; // alias system_path is a weird name

   //      	if ($previous_value_set_flag) {

   //      		$previous_full_path = $data['Media']['previous_value'];

   //      		$old_file = new File($previous_full_path);
   //      		$old_file->delete();

   //      	}

   //  		$upload_options = array(
	  //   		'name' => $name,
	  //   		'file' => $file
			// );

   //  		$current_full_path = $this->uploadFile($upload_options, $current_path, true);

   //  		if (!empty($current_full_path)) {

	  //       	$data['Media']['system_path'] = $current_full_path;

	  //       } else {

	  //       	throw new Exception("An error occured while uploading the file", 1);
	        	
	  //       }

   //      } else {

   //      	if($previous_value_set_flag) {

   //      		$previous_full_path = $data['Media']['previous_value'];
   //      		$ext = $this->getFileExt($previous_full_path);


   //      		$current_full_path = "$current_path$name.$ext";
   //      		if ($current_full_path !== $previous_full_path) {

   //      			$old_file = new File($previous_full_path);
   //      			$old_file->copy($current_full_path);
   //      			$old_file->delete();

   //      		}

   //      		$data['Media']['system_path'] = $current_full_path;

   //      	} else {

   //      		return false;

   //      	}

   //      }


   //      if (!empty($data[$key]['system_path'])) {

   //          $this->data = $data;

   //          return true;
            
   //      }

   //      return false;
   //  }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        $id = $this->checkId();
        $file = $this->findById($id);


        $path = $this->TDirectory->getPathFromId($file[$this->alias]['t_directory_id']);
        $path = $this->TDirectory->getAbsolutePath($path);
        $path .= $file[$this->alias]['name'];

        if (is_file($path)) {

            $file = new File($path);
            return $file->delete();

        }
        return true;
    }

    
}
