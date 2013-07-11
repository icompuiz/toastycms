<?php
App::uses('ToastyCoreAppModel', "ToastyCore.Model");
App::uses('MediaBase', 'ToastyCore.Model');
App::uses("Folder", "Utility");
App::uses("File", "Utility");

/**
 * MediaDirectory Model
 *
 * @property MediaDirectory $MediaDirectory
 * @property Media $Media
 * @property MediaDirectory $MediaDirectory
 */
class MediaDirectory extends MediaBase {

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';

    public $name = 'MediaDirectory';

    public $useTable = 'media_directories';

/**
 * Validation rules
 *
 * @var array
 */
    public $validate = array(
        'parent_media_directory_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'notDescendent' => array(
                'rule' => array('notDescendent'),
                'message' => 'Cannot move directory here',
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
                'rule' => array('checkName'),
                'message' => 'A directory with this name already exists',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'system_path' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'type' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    public function checkName($check) {

        $name = $check['name'];

        $mid = $this->data['MediaDirectory']['parent_media_directory_id'];

        $path = $this->getPathString($mid);

        $name = "$path$name";

        $options['conditions'] = array(
            'MediaDirectory.system_path LIKE' => $name,
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
        'ParentMediaDirectory' => array(
            'className' => 'MediaDirectory',
            'foreignKey' => 'parent_media_directory_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'ChildMedia' => array(
            'className' => 'Media',
            'foreignKey' => 'media_directory_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'ChildMediaDirectory' => array(
            'className' => 'MediaDirectory',
            'foreignKey' => 'parent_media_directory_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    // public function getPathString($pmdid) {
    //     $path = $this->getFullPath($pmdid);

    //     if ( null !== $path) {
    //         $path = implode(DS, $path);
    //     } else {
    //         $path = "";
    //     }

    //     $path = "Media" . DS . $path . DS;
    //     $path = str_replace(DS . DS, DS, $path);

    //     return $path;
    // }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        $data = $this->data;

        if (isset($data['bypass'])) {
            return true;
        }



        if (isset($data['MediaDirectory'])) {
            $key = 'MediaDirectory';
        } else {
            return false;
        }

 
        if (true) {

            $pmdid = isset($data['MediaDirectory']['parent_media_directory_id']) ? $data['MediaDirectory']['parent_media_directory_id'] : 0;
            $id = isset($data['MediaDirectory']['id']) ? $data['MediaDirectory']['id'] : null;

            if (!empty($id)) {

                if ($this->isDescendant($id, $pmdid)) {
                    return false;
                }

            }

            
            $current_path = $this->getPathString($pmdid);

            $name = $data['MediaDirectory']['name'];
            $name = preg_replace("~\W~", "_", $name);

            if ("Media" . DS === $current_path) {
                if (!is_dir($current_path)) {
                    mkdir($current_path);
                }
            }



            // debug($current_path); exit;
            // debug(is_dir($current_path)); exit;
            if (is_dir($current_path)) {

                $full_path = $current_path . $name;


                $previous_value = isset($data['MediaDirectory']['previous_value']) ? $data['MediaDirectory']['previous_value'] : null;
                
                if ( null !== $previous_value ) {

                    if ($previous_value !== $full_path) {

                        $folder = new Folder($previous_value);
                        $folder->move($full_path);


                        $data['update_descendents'] = true;
                        $folder->delete();


                    }

                    unset($data['MediaDirectory']['previous_value']);

                    $data['MediaDirectory']['system_path'] = $full_path; 

                } else {

                    if (!is_dir($full_path)) {

                        $folder = new Folder();
                        $folder->create($full_path);
                        
                    }
                    $data['MediaDirectory']['system_path'] = $full_path;

                }

                // debug($data); exit;

                $this->data = $data;

                return true;

            } 
        }

        return false;   
    }

    public function afterSave($options) {
        parent::afterSave($options);
        $data = $this->data;
        if(isset($data['update_descendents'])) {
            $id = $data['MediaDirectory']['id'];
            $path = $data['MediaDirectory']['system_path'];
            $this->updateDescendentPaths($id, $path);
        }
    }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        $this->ChildMedia->deleteAll(
            array('ChildMedia.media_directory_id' => $this->id)
        );

        $this->ChildMediaDirectory->deleteAll(
            array('ChildMediaDirectory.parent_media_directory_id' => $this->id)
        );


        $this->read();

        $system_path = $this->data['MediaDirectory']['system_path'];

        $folder = new Folder($system_path);

        if (is_dir($system_path)) {

            $folder->delete();


        } 

       return true;
    }

    public function isDescendant($parent, $id) {

        if ($id == 0) {
            return false;
        }

        $isDescendant = false;

        $current_id = $id;
        do {

            $data = $this->findById($current_id);

            $pid = $data['ParentMediaDirectory']['id'];
            $current_id = $pid;
            
            if ($pid === $parent) {
                $isDescendant = true;
            }

        } while ( !$isDescendant && null !== $pid );


        return $isDescendant;
    }

    public function notDescendent($options) {

        $pmdid = $options['parent_media_directory_id'];

        $id = isset($this->data['MediaDirectory']['id']) ? $this->data['MediaDirectory']['id'] : null;

        if (!empty($id)) {
            if ($this->isDescendant($id, $pmdid)) {
                return false;
            }
        }
        return true;

    }

    public function updatePath($id) {

        $me = $this->findById($id);

        $full_path = $this->getPathString($me['ParentMediaDirectory']['id']);


        $name = $me['MediaDirectory']['name'];
                
        $full_path = $full_path . $name;

        $me['MediaDirectory']['system_path'] = $full_path;

        $me['bypass'] = true;

        $this->data = $me;

        $this->save($me);

    }

    public function updateDescendentPaths($id, $path) {


        $data = $this->findById($id);

        App::uses("Media", "ToastyCore.Model");
        $media = new Media();
        $media_directory = new MediaDirectory();



        $descendents = array_merge($data['ChildMediaDirectory'], $data['ChildMedia']);

        if (!empty($descendents)) {

            foreach($descendents as $descendent) {

                $key = isset($descendent['parent_media_directory_id']) ? 'MediaDirectory' : 'Media';


                $class = $key === 'MediaDirectory' ? $media_directory: $media;

                $class->updatePath($descendent['id']);

                if ($key === 'MediaDirectory') {

                    $this->updateDescendentPaths($descendent['id'], $path);

                }
            }

        }

    }


}
