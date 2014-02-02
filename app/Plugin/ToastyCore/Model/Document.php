<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');
App::uses('TreeBehavior', 'Model/Behavior');


class Document extends ToastyCoreAppModel {

	public $actsAs = array('Tree');

    public $name = "Document";

    public $validate = array(
        'name' => array(
            'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
        ),
        'home_page' => array(
            'onlyOneHomepage' => array(
                'rule' => array('checkMultipleHomePage')
            ),
            'pagePublished' =>array(
                'rule' => array('checkPublished'),
                'message' => 'The document must be published in order to be the home page'

            )
        ),
    );

    public function checkPublished($check) {

        if (1 == $check['home_page']) {

            if ($this->data['Document']['published']) {

                return true;

            } else {

                return false;

            }

        }

        return true;

    }

    public function checkMultipleHomePage($check) {

        if (!$this->isEmptyValue($check['home_page'])) {
            
            $options = array(
                'conditions' => array(
                    $this->alias . '.home_page' => true
                )
            );

            $document = $this->find('first', $options);

            if (!$this->isEmptyValue($document)) {

                $name = $document[$this->alias]['name'];
                $id = $document[$this->alias]['id'];

                $check_id = isset($this->data[$this->alias]['id']) ? $this->data[$this->alias]['id'] : false;
                    
                if ( $id != $check_id ) {
                    return "You cannot have multiple home pages. The current home page is '$name' with the id '$id'";
                }
            }
        }

        return true;

    }

    public function getName($document_id = null) {

        $document_id = $this->checkId($document_id);

        $conditions = array('Document.id' => $document_id);
        $document = $this->find('first', array("conditions" => $conditions));



        $name = $document['Document']['name'];

        return $name;
    }

    public function setName($name = null, $document_id = null) {

        $document_id = $this->checkId($document_id);

        $name = trim($name);

        if ($name) {

            $data = array(
                'Document' => array(
                    'id' => $document_id,
                    'name' => $name
                )
            );

            $this->save($data);

            return true;
        }

        throw new Exception("name parameter must be provided");
    }

    public function getUser($document_id = null) {

        $document_id = $this->checkId($document_id);

        $conditions = array('Document.id' => $document_id);
        $document = $this->find('first', array("conditions" => $conditions));

        $user = $document['User'];

        return $user;
    }

    public function setUser($user_id = null, $document_id = null) {

        $document_id = $this->checkId($document_id);

        $user_id = trim($user_id);

        if ($user_id) {

            $data = array(
                'Document' => array(
                    'id' => $document_id,
                    'user_id' => $user_id
                )
            );

            $this->save($data);

            return true;
        }

        throw new Exception("name parameter must be provided");
    }

    public function allowUser($document_id = null, $user_id = null) {

        $document_id = $this->checkId($document_id);

        return $this->isOwnedBy($document_id, $user_id);
    }

    public function isOwnedBy($document, $user) {
        return $this->field('id', array('id' => $document, 'user_id' => $user)) === $document;
    }

    public function getParent($document_id = null) {

        $document_id = $this->checkId($document_id);

        $parent = $this->getParentNode($document_id);

        return $parent;
    }

    public function getDocumentType($document_id = null) {

        $document_id = $this->checkId($document_id);

        $conditions = array('Document.id' => $document_id);
        $document = $this->find('first', array("conditions" => $conditions));

        $type = $document['DocumentType'];

        return $type;
    }

    public function getCreated($document_id = null) {

        $document_id = $this->checkId($document_id);

        $conditions = array('Document.id' => $document_id);
        $document = $this->find('first', array("conditions" => $conditions));

        $created = $document['Document']['created'];


        return $created;
    }

    public function getModified($document_id = null) {

        $document_id = $this->checkId($document_id);

        $conditions = array('Document.id' => $document_id);
        $document = $this->find('first', array("conditions" => $conditions));

        $modified = $document['Document']['modified'];


        return $modified;
    }

    /**
     * a user may have many resources and a resource has only one user
     * a resource may have many respources and a resource may have only one resource
     * @var array 
     */
    public $belongsTo = array(
        
        'DocumentType' => array(
            'className' => 'ToastyCore.DocumentType'
        ), 
        // 'User' => array(
        //     'className' => 'ToastyCore.User'
        // )
    );

    /**
     * a resource has many allowed templates
     * a resource has many properties
     * @var array
     */
    public $hasMany = array(
        'DocumentProperties' => array(
            'className' => 'ToastyCore.DocumentProperty'
        )
    );


   /**
   	* Checks if a document is a descendant of another (iterative :( ))
    */

    public function isDescendant($options) {
            

        $id = isset($options['parent_id']) ? $options['parent_id'] : null;
        $search_id = isset($options['search_id']) ? $options['search_id'] : null;
        $conditions = array(
            $this->name . '.id' => $id
        );

        $children = $this->children($id, false, 'id');

        foreach ($children as $child) {
            if ($search_id == $child[$this->name]['id']) {
                return true;
                break;
            }
        }

        return false;
    }
    public function afterDelete() {
        parent::afterDelete();



    }

    public function beforeSave($options = array()) {

        parent::beforeSave();

        $name = $this->data['Document']['name'];
        $name = trim($name);
        $this->data['Document']['name'] = $name;
        

        if (!isset($this->data['Document']['alias'])) {
			$alias = preg_replace('~\W~', '_', $name);
			$this->data['Document']['alias'] = $alias;
        }

        if ($this->isEmptyValue($this->data['Document']['alias'])) {
            $alias = preg_replace('~\W~', '_', $name);
			$this->data['Document']['alias'] = $alias;

        }

        return true;
    }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        if ($this->isRoot()) {

            return false;
        }

        return true;
    }

    public function isRoot($document_id = null) {

        $document_id = $this->checkId($document_id);


        $conditions = array('Document.id' => $document_id);

        $document = $this->find('first', array('conditions' => $conditions));

        if (empty($document)) {
            return false;
        }

        $type = $document['Document']['type'];
        return $type === 'root';

    }

    public function getStack($model_id = null, $mapping_function = null) {

        if ($this->isEmptyValue($model_id)) {
            return null;
        }

        if (!is_callable($mapping_function)) {
            $mapping_function = function($model) {
                return $model;
            };
        }

        $model_id = $this->checkId($model_id);

        $templates = array();

        $currentDocument = $this->findById($model_id);
        $templates[] = $mapping_function($currentDocument);

        $parentNode = $this->getParentNode($model_id);
        while (!empty($parentNode))  {


            $templates[] = $mapping_function($parentNode);
        
            $model_id = $parentNode[$this->name]['id'];
            $parentNode = $this->getParentNode($model_id);

        }
        
        $templates = array_reverse($templates);


        return $templates;
    }

    public function getDefaultMappingFunction() {

        $defaultMappingFunction = function($node) {

            $alias =  $node['Document']['alias'];
            return $alias;
        };
        return $defaultMappingFunction;
    }

    public function getPathFromId($document_id = null) {

        $mapping_function = $this->getDefaultMappingFunction();

        $stack = $this->getStack($document_id, $mapping_function);

        $path = $this->pathStackToString($stack);

        return $path;

    }

    public function stackToString($stack) {

        $path = implode(DS, $stack);

        return $path;

    }

    public function getPathFromDocument($document) {

        $document_id = $document['Document']['id'];
        $path = $this->getPathFromId($document_id);

        return $path;

    }

    /**
     *  Get an id from a path
     * Possible test case, documents with same alias
     */

    public function getDocumentFromPath($path) {

        $nodes = explode('/', $path);

        $root_node = array_shift($nodes);

        $options = array(
            'conditions' => array(
                'Document.alias' => $root_node,
                'Document.parent_id' => null
            )
        );

        $root_node = $this->find('first', $options);
        $parent_id = $root_node['Document']['id'];
        
        $currentDocument = null;
        foreach($nodes as $node) {

            $options = array(
                'conditions' => array(
                    'Document.alias' => $node,
                    'Document.parent_id' => $parent_id
                )
            );

            $currentDocument = $this->find('first', $options);


            $parent_id = $currentDocument['Document']['id'];


        }

        return $currentDocument;

    }

    public function getIdFromPath($path) {

        $document = $this->getDocumentFromPath($path);
        return $document['Document']['id'];

    }

    public function updatePublished($document) {

        $conditions =  array(
            'Document.parent_id' => $document['Document']['id'],
        );

        $fields = array(
            'Document.published' => $document['Document']['published']
        );

        $this->updateAll($fields, $document['Document']['published']);
    }

    public function publishChildren($document_id) {

        $document_id = $this->checkId($document_id);

        $document = array(
            'Document' =>  array(
                'id' => $document_id,
                'published' => 1 
                )
        );

        $this->updatePublished($document);
        
    }

    public function unpublishChildren($document_id) {

        $document_id = $this->checkId($document_id);

        $document = array(
            'Document' =>  array(
                'id' => $document_id,
                'published' => 0 
                )
        );

        $this->updatePublished($document);

    }

    public function beforeFind($query) {
        // debug($query);
    }

    public function afterFind($results, $primary = false) {



    }

}

?>