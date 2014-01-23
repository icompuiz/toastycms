<?php
App::uses('ToastyCoreAppModel', "ToastyCore.Model");
App::uses('MediaBase', 'ToastyCore.Model');
App::uses("Folder", "Utility");
App::uses("File", "Utility");

/**
 * TDirectory Model
 *
 * @property TDirectory $TDirectory
 * @property Media $Media
 * @property TDirectory $TDirectory
 */
class TDirectory extends ToastyCoreAppModel {

    public $actsAs = array('Tree');

/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'name';

    public $name = 'TDirectory';

    public $tFileRoot = 'TFileRoot';

    // public $useTable = 'media_directories';

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
                'required' => true,
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
        // 'system_path' => array(
        //     'notempty' => array(
        //         'rule' => array('notempty'),
        //         //'message' => 'Your custom message here',
        //         //'allowEmpty' => false,
        //         'required' => true,
        //         //'last' => false, // Stop validation after this rule
        //         //'on' => 'create', // Limit validation to 'create' or 'update' operations
        //     ),
        // )
    );

    public function checkName($check) {

        $name = $check['name'];


        if (!isset( $this->data[$this->alias]['parent_id'])) {

            $parentId = $this->find(
                'first',
                array(
                    'conditions' => array('TDirectory.id' => $this->data[$this->alias]['id']),
                    'fields' => 'parent_id'
                )
            );

            $parentId = $parentId[$this->alias]['parent_id'];

        } else {

            $parentId = $this->data[$this->alias]['parent_id'];
        }

        if ($parentId) {


            $children = $this->children($parentId, true, 'name');

            foreach ($children as $child) {
                if ($name == $child[$this->alias]['name']) {
                    return false;
                }
            }

        }

        return true;

    }

    //The Associations below have been created with all possible keys, those that are not needed can be removed


/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'TFile' => array(
            'className' => 'ToastyCore.TFile',
            'dependent' => true
        ),
        
    );

public function getStack($model_id = null, $mappingFunction = null) {

        if ($this->isEmptyValue($model_id)) {
            return null;
        }

        if (!is_callable($mappingFunction)) {
            $mappingFunction = function($model) {
                return $model;
            };
        }

        $model_id = $this->checkId($model_id);

        $templates = array();

        $currentTDirectory = $this->findById($model_id);
        $templates[] = $mappingFunction($currentTDirectory);

        $parentNode = $this->getParentNode($model_id);
        while (!empty($parentNode))  {


            $templates[] = $mappingFunction($parentNode);
        
            $model_id = $parentNode[$this->name]['id'];
            $parentNode = $this->getParentNode($model_id);

        }
        
        $templates = array_reverse($templates);


        return $templates;
    }

    public function normalizeName($name) {

        $name = Inflector::camelize($name);

        return $name;
    }

    public function getPathFromId($tdirectory_id = null) {

        if (!$tdirectory_id) {
            return "";
        }

        $mappingFunction = function($node) {
            $name = $node['TDirectory']['name'];
            $name =  $this->normalizeName($name);
            return $name;

        };

        $path = $this->getStack($tdirectory_id, $mappingFunction);

        $path = implode(DS, $path) . DS;

        return $path;

    }

    public function getPathFromTDirectory($document) {

        $tdirectory_id = isset($document['TDirectory']['id']) ? $document['TDirectory']['id'] : false;
        $path = false;
        if ($tdirectory_id) {
            $path = $this->getPathFromId($tdirectory_id);
        } 

        return $path;

    }

    /**
     *  Get an id from a path
     * Possible test case, documents with same name
     */

    public function getTDirectoryFromPath($path) {

        $nodes = explode('/', $path);

        $root_node = array_shift($nodes);

        $options = array(
            'conditions' => array(
TDirectory.                'TDirectory.name' => $root_node,
                'TDirectory.parent_id' => null
            )
        );

        $root_node = $this->find('first', $options);
        $parent_id = $root_node['TDirectory']['id'];
        
        $currentTDirectory = null;
        foreach($nodes as $node) {

            $options = array(
                'conditions' => array(
TDirectory.                    'TDirectory.name' => $node,
                    'TDirectory.parent_id' => $parent_id
                )
            );

            $currentTDirectory = $this->find('first', $options);


            $parent_id = $currentTDirectory['TDirectory']['id'];


        }

        return $currentTDirectory;

    }

    public function getIdFromPath($path) {

        $document = $this->getTDirectoryFromPath($path);
        return $document['TDirectory']['id'];

    }

    public function getAbsolutePath($relativePath, $createRoot = true) {
        $tFileRoot = $this->tFileRoot;
        if ($createRoot && !is_dir($tFileRoot)) {
            mkdir($tFileRoot);
            chmod($tFileRoot, 0775);
        }

        if (!preg_match("~^$tFileRoot~", $relativePath)) {
            $relativePath = $tFileRoot . DS . $relativePath;
        }

        return $relativePath;
    }

    // before saving 
    // if the directory is new (id not present), create the directory
    // if this is an existing directory and a previous_state array is in the data
    //      if name is present, check if changed. If so get the path, find the directory with that name, and move it to the new name it
    //      if parent_id is present, check if changed. If so, get the path, find the directory with that path and move it

    public function beforeSave($options = array()) {


        parent::beforeSave($options);

        $data = $this->data;

        if (isset($data['bypass'])) {
            return true;
        }



        if (isset($data['TDirectory'])) {
            $key = 'TDirectory';
        } else {
            return false;
        }

        if (!isset( $this->data[$this->alias]['parent_id'])) {

            $parentId = $this->find(
                'first',
                array(
                    'conditions' => array('TDirectory.id' => $this->data[$this->alias]['id']),
                    'fields' => 'parent_id'
                )
            );

            $parentId = $parentId[$this->alias]['parent_id'];

        } else {

            $parentId = $this->data[$this->alias]['parent_id'];
        }

        $name = $data[$this->alias]['name']; // what if name is null (root)

        $name = $this->normalizeName($name);
        $parentPath = $this->getPathFromId($parentId);
        
        $previousPath = $this->getPathFromTDirectory($data);


        if ($previousPath) {
            $previousPath = $this->getAbsolutePath($previousPath);
        }
            
        $newPath = $parentPath . $name;
        $newPath = $this->getAbsolutePath($newPath);
        
        if (is_dir($previousPath)) {
            $folder = new Folder($previousPath);
            $success = $folder->move($newPath);
        } else {
            $folder = new Folder();
            $success = $folder->create($newPath);
            $success = $folder->chmod($newPath, 0775);
        }



        return $success;

    }

    public function afterSave($created, $options = array()) {
        parent::afterSave($options);
    }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        $id = $this->checkId();
        $path = $this->getPathFromId($id);

        $path = $this->getAbsolutePath($path);

        if (is_dir($path)) {

            $folder = new Folder($path);
            return $folder->delete();

        }
        return true;

    }

    public function isDescendant($options) {
            

        $id = isset($options['parent_id']) ? $options['parent_id'] : null;
        $search_id = isset($options['search_id']) ? $options['search_id'] : null;

        $children = $this->children($id, false, 'id');

        foreach ($children as $child) {
            if ($search_id == $child[$this->name]['id']) {
                return true;
                break;
            }
        }

        return false;
    }


}
