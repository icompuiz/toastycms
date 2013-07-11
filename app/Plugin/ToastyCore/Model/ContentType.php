<?php
App::uses('ToastyCoreAppModel', 'ToastyCore.Model');

class ContentType extends ToastyCoreAppModel {

    public $name = "ContentType";
    public $_schema = array(
        'id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'name' => array(
            'type' => 'string',
            'length' => 255
        ),
        'content_template_id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'parent_content_type_id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'created' => array(
            'type' => 'datetime',
        ),
        'modified' => array(
            'type' => 'datetime',
        )
    );
    
    public $validate = array(
        'name' => 'notEmpty',
        'parent_content_type_id' => array(
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
                'ContentType' => array(
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
        
        $name = $type['ContentType']['name'];
        
        return $name;
    }

    public function setParentType($type_id = null, $id = null) {
      $id = $this->checkId($id);
        
        if ($type_id) {
            
            $data = array(
                'ContentType' => array(
                    'id' => $id,
                    'parent_content_type_id' => $type_id
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
        
        $parent = $type['ParentContentType'];
        
        return $parent;
    }
    
    public function getChildTypes($id = null) {
        
        $id = $this->checkId($id);
        
        $type = $this->read(null, $id);
        
        $children = $type['ChildContentTypes'];
        
        return $children;
    }

    public function setTemplate($template_id = null, $id = null) {
      $id = $this->checkId($id);
        
        if ($template_id) {
            
            $data = array(
                'ContentType' => array(
                    'id' => $id,
                    'content_template_id' => $template_id
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
        
        $template = $type['ContentTemplate'];
        
        return $template;
    }

    /**
     * a resource type has one resource template
     * @var array 
     */
    public $hasOne = array(
        
    );
    
    public $belongsTo= array(
        'ParentContentType' => array(
            'className' => 'ToastyCore.ContentType'
        ),
        'ContentTemplate' => array(
            'className' => 'ToastyCore.ContentTemplate'
        )
    );

    /**
     * a resource type has many allowed templates
     * a resource type has many properties
     * a resource type has many resources (TODO: Check if necessary)
     * @var  array
     */
    public $hasMany = array(
        //
        'ChildContentTypes' => array(
            'className' => 'ToastyCore.ContentType',
            'foreignKey' => 'parent_content_type_id'
        ),
        'ContentTypePropertySkel' => array(
            'className' => 'ToastyCore.ContentTypePropertySkel'
        ),
        // 
        'Content' => array(
            'className' => 'ToastyCore.Content'
        )
    );
    
    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);
        
        $contents = $this->Content->find('all', array('conditions' => array('Content.content_type_id' => $this->id)));
        
        if (!empty($contents)) {
            return false;
        }
        
        return true;
        
        
    }
    public function afterDelete() {
        parent::afterDelete();
        
        $id =$this->id;
        
        $this->ContentTypePropertySkel->deleteAll(array('ContentTypePropertySkel.content_type_id' => $id));
    }
    
    public function checkDescendant($options) {

        $id = isset($options['parent_content_type_id']) ? $options['parent_content_type_id'] : null;

        if (empty($id)) {
            return true;
        }

        $ct = $this->Data['ContentType']['id'];


        return $this->isDescendant($ct, $id);
    }

    public function isDescendant($parent, $id) {

        if (empty($id)) {
            return false;
        }

        $isDescendant = false;

        $current_id = $id;
        do {

            $data = $this->findById($current_id);

            $pid = $data['ParentContentType']['id'];
            $current_id = $pid;
            
            if ($pid === $parent) {
                $isDescendant = true;
            }

        } while ( !$isDescendant && null !== $pid );


        return $isDescendant;
    }

}

?>