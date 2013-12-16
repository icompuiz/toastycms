<?php
App::uses('ToastyCoreAppModel', 'ToastyCore.Model');

class DocumentType extends ToastyCoreAppModel {
    
    public $actsAs = array('Tree');

    public $name = "DocumentType";
    
    public $validate = array(
        'name' => 'notEmpty',
        'parent_id' => array(
            'rule' => array('checkDescendant'),
            'message' => 'You cannot set a child to be a parent'
        )
    );

    public function addType($data = null) {
        if ($data) {
            $this->create($data);
            $this->save();
        }
    }

    public function deleteType($id = null) {
        
        $id = $this->checkId($id);
        
        $this->delete($id);
    }

    public function setName($newName = null, $id = null) {
        
        $id = $this->checkId($id);
        
        if ($newName) {
            
            $data = array(
                'DocumentType' => array(
                    'id' => $id,
                    'name' => $newName
                )
            );
            
            $this->save($data);
            
            return;
            
        }
    }

    public function getName($id = null) {
        $id = $this->checkId($id);
        
        $type = $this->read(null, $id);
        
        $name = $type['DocumentType']['name'];
        
        return $name;
    }

    public function setParentType($type_id = null, $id = null) {
      $id = $this->checkId($id);
        
        if ($type_id) {
            
            $data = array(
                'DocumentType' => array(
                    'id' => $id,
                    'parent_document_type_id' => $type_id
                )
            );
            
            $this->save($data);
            
            return;
            
        }
        
        throw new Exception("template_id parameter must be provided");
        
    }

    public function getParentType($id = null) {
        
        $id = $this->checkId($id);
        
        $type = $this->read(null, $id);
        
        $parent = $type['ParentDocumentType'];
        
        return $parent;
    }
    
    public function getChildTypes($id = null) {
        
        $id = $this->checkId($id);
        
        $type = $this->read(null, $id);
        
        $children = $type['ChildDocumentTypes'];
        
        return $children;
    }

    public function setTemplate($template_id = null, $id = null) {
      $id = $this->checkId($id);
        
        if ($template_id) {
            
            $data = array(
                'DocumentType' => array(
                    'id' => $id,
                    'document_template_id' => $template_id
                )
            );
            
            $this->save($data);
            
            return;
        }
        
        throw new Exception("template_id must be provided");
    }

    public function getTemplate($id = null) {
        
        $id = $this->checkId($id);
        
        $type = $this->read(null, $id);
        
        $template = $type['DocumentTemplate'];
        
        return $template;
    }

    /**
     * a resource type has one resource template
     * @var array 
     */
    public $hasOne = array(
        
    );
    
    public $belongsTo= array(
        // 'ParentDocumentType' => array(
        //     'className' => 'ToastyCore.DocumentType'
        // ),
        // 'DocumentTemplate' => array(
        //     'className' => 'ToastyCore.DocumentTemplate'
        // )
    );

    /**
     * a resource type has many allowed templates
     * a resource type has many properties
     * a resource type has many resources (TODO: Check if necessary)
     * @var  array
     */
    public $hasMany = array(
        // //
        // 'ChildDocumentTypes' => array(
        //     'className' => 'ToastyCore.DocumentType',
        //     'foreignKey' => 'parent_document_type_id'
        // ),
        'DocumentTypeProperty' => array(
            'className' => 'ToastyCore.DocumentTypeProperty'
        ),
        // 
        'Document' => array(
            'className' => 'ToastyCore.Document'
        )
    );
    
    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);
        
        $documents = $this->Document->find('all', array('conditions' => array('Document.document_type_id' => $this->id)));
        
        if (!empty($documents)) {
            return false;
        }
        
        return true;
        
        
    }
    public function afterDelete() {
        parent::afterDelete();
        
        $id =$this->id;
        
        $this->DocumentTypeProperty->deleteAll(array('DocumentTypeProperty.document_type_id' => $id));
    }
    
    public function checkDescendant($options) {

        $parent_id = isset($options['parent_id']) ? $options['parent_id'] : null;

        if (empty($parent_id)) {
            return true;
        }

        $search_id = $this->data[$this->name]['id'];

        $options = array(
            'parent_id' => $parent_id,
            'search_id' => $search_id
        );


        return $this->isDescendant($options);
    }

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

}

?>