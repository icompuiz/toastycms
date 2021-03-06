<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');

class Content extends ToastyCoreAppModel {

    public $name = "Content";
    public $_schema = array(
        'id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'name' => array(
            'type' => 'string',
            'length' => 255
        ),
        'user_id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'parent_content_id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'content_type_id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'created' => array(
            'type' => 'datetime'
        ),
        'modified' => array(
            'type' => 'integer'
        )
    );
    public $validate = array(
        'name' => array(
            'notEmpty'
        ),
        'parent_content_id' => array(
            'rule' => array('isDescendant'),
            'message' => 'You cannot set a child to be a parent'
        ),
        'user_id' => array(
            'notEmpty'
        ),
        'home_page' => array(
            'rule' => array('checkMultipleHomePage')
        ),
        'published' => array(
            'rule' => array('checkHomePageSet'),
            'message' => 'The content must be published in order to be the home page'
        )
    );

    public function checkHomePageSet($check) {

        if (0 == $check['published']) {

            $homePageSet = 1 == $this->data['Content']['home_page'];


            if ($homePageSet) {

                return false;

            }

        }

        return true;

    }

    public function checkMultipleHomePage($check) {

        if (!$this->isEmptyValue($check['home_page'])) {
            
            $options = array(
                'conditions' => array(
                    'Content.home_page' => true
                )
            );
            $content = $this->find('first', $options);

            if (!$this->isEmptyValue($content)) {

                $name = $content['Content']['name'];
                $id = $content['Content']['id'];

                $check_id = isset($this->data['Content']['id']) ? $this->data['Content']['id'] : false;

                    
                if ( $id != $check_id ) {

                    return "You cannot have multiple home pages. The current home page is '$name' with the id '$id'";

                }


            }
        }

        return true;

    }

    public function getName($content_id = null) {

        $content_id = $this->checkId($content_id);

        $conditions = array('Content.id' => $content_id);
        $content = $this->find('first', array("conditions" => $conditions));



        $name = $content['Content']['name'];

        return $name;
    }

    public function setName($name = null, $content_id = null) {

        $content_id = $this->checkId($content_id);

        $name = trim($name);

        if ($name) {

            $data = array(
                'Content' => array(
                    'id' => $content_id,
                    'name' => $name
                )
            );

            $this->save($data);

            return true;
        }

        throw new Exception("name parameter must be provided");
    }

    public function getUser($content_id = null) {

        $content_id = $this->checkId($content_id);

        $conditions = array('Content.id' => $content_id);
        $content = $this->find('first', array("conditions" => $conditions));

        $user = $content['User'];

        return $user;
    }

    public function setUser($user_id = null, $content_id = null) {

        $content_id = $this->checkId($content_id);

        $user_id = trim($user_id);

        if ($user_id) {

            $data = array(
                'Content' => array(
                    'id' => $content_id,
                    'user_id' => $user_id
                )
            );

            $this->save($data);

            return true;
        }

        throw new Exception("name parameter must be provided");
    }

    public function allowUser($content_id = null, $user_id = null) {

        $content_id = $this->checkId($content_id);

        return $this->isOwnedBy($content_id, $user_id);
    }

    public function isOwnedBy($content, $user) {
        return $this->field('id', array('id' => $content, 'user_id' => $user)) === $content;
    }

    public function getParent($content_id = null) {

        $content_id = $this->checkId($content_id);

        $conditions = array('Content.id' => $content_id);
        $content = $this->find('first', array("conditions" => $conditions));

        $parent = $content['ParentContent'];


        return $parent;
    }

    public function getContentType($content_id = null) {

        $content_id = $this->checkId($content_id);

        $conditions = array('Content.id' => $content_id);
        $content = $this->find('first', array("conditions" => $conditions));

        $type = $content['ContentType'];


        return $type;
    }

    public function getCreated($content_id = null) {

        $content_id = $this->checkId($content_id);

        $conditions = array('Content.id' => $content_id);
        $content = $this->find('first', array("conditions" => $conditions));

        $created = $content['Content']['created'];


        return $created;
    }

    public function getModified($content_id = null) {

        $content_id = $this->checkId($content_id);

        $conditions = array('Content.id' => $content_id);
        $content = $this->find('first', array("conditions" => $conditions));

        $modified = $content['Content']['modified'];


        return $modified;
    }

    /**
     * a user may have many resources and a resource has only one user
     * a resource may have many respources and a resource may have only one resource
     * @var array 
     */
    public $belongsTo = array(
        // 
        'ContentType' => array(
            'className' => 'ToastyCore.ContentType'
        ),
        'ParentContent' => array(
            'className' => 'ToastyCore.Content'
        ),
        'User' => array(
            'className' => 'ToastyCore.User'
        )
    );

    /**
     * a resource has many allowed templates
     * a resource has many properties
     * @var array
     */
    public $hasMany = array(
        'ContentTypeProperties' => array(
            'className' => 'ToastyCore.ContentTypeProperty'
        ),
        'ChildContent' => array(
            'className' => 'ToastyCore.Content',
            'foreignKey' => 'parent_content_id',
            'order' => array(
                'ChildContent.sort',
                'ChildContent.created'
            )
        )
    );

    public function isDescendant($options) {
        
        $id = isset($options['parent_content_id']) ? $options['parent_content_id'] : null;
        
        if (empty($this->id)) {
            return true;
        }
        
        $content = $this->findById($id);
        
        if (empty($content['ParentContent']['id'])) {
            
            return true;
            
        } elseif ($this->id === $content['ParentContent']['id']) {

            return false;
        }

        return $this->isDescendant($content['ParentContent']['id']);
    }

    public function afterDelete() {
        parent::afterDelete();



    }

    public function beforeSave($options = array()) {

        parent::beforeSave();


        $name = $this->data['Content']['name'];
        $name = trim($name);
        $this->data['Content']['name'] = $name;
        
        if (isset($this->data['Content']['id'])) {
        	$this->sortSiblings($this->data['Content']['id']);
        	$this->publishChildren($this->data['Content']['id']);
        } else {
        	$options = array(
        		'conditions' => array(
        			'Content.parent_content_id' => $this->data['Content']['parent_content_id']
    			)
    		);

    		$count = $this->find('count', $options);

    		$this->data['Content']['sort'] = $count + 1;
        }

        if (!isset($this->data['Content']['alias'])) {
			$alias = preg_replace('~\W~', '_', $name);
			$this->data['Content']['alias'] = $alias;
        }

        if ($this->isEmptyValue($this->data['Content']['alias'])) {
            $alias = preg_replace('~\W~', '_', $name);
			$this->data['Content']['alias'] = $alias;

        }



        return true;
    }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        if ($this->isRoot()) {

            return false;
        }

        $cc = $this->ChildContent->find('all',
            array('conditions' =>
                array('ChildContent.parent_content_id' => $this->id)
            )
        );

        $ctp = $this->ContentTypeProperties->find('all', 
            array('conditions' =>
                array('ContentTypeProperties.content_id' => $this->id)
            )
        );

        foreach ($cc as $child) {
            $content = new Content();
            $content->id = $child['ChildContent']['id'];
            $content->delete();

        }

        foreach ($ctp as $p) {
            $this->ContentTypeProperties->id = $p['ContentTypeProperties']['id'];
            $this->ContentTypeProperties->delete();
        }

        return true;
    }

    public function isRoot($content_id = null) {

        $content_id = $this->checkId($content_id);

        $conditions = array('Content.id' => $content_id);
        $user = $this->find('first', array('conditions' => $conditions));
        $type = $user['Content']['type'];
        return $type === 'root';

    }

    public function getPathFromId($content_id = null) {

        $content_id = $this->checkId($content_id);

        $path = array();
        while(!$this->isEmptyValue($content_id)) {

            
            $content = $this->findById($content_id);

            $path[] = $content['Content']['alias'];

            $content_id = $content['Content']['parent_content_id'];

        }
        
        $path = array_reverse($path);

        $path = implode(DS, $path);

        return $path;

    }

    public function getIdFromPath($path) {

        $path = explode('/', $path);


        $pid = 0;
        foreach ($path as $alias) {

            $options = array(
                'conditions' => array(
                    'Content.parent_content_id' => $pid,
                    'Content.alias' => $alias 
                )
            );

            $currentContent = $this->find('first', $options);

            if (!empty($currentContent)) {

                $pid = $currentContent['Content']['id'];

            } else {
                $pid = null;

                break;
            }

        } 

        return $pid;


    }

    public function publishChildren($content_id) {

        $content_id = $this->checkId($content_id);

        $content = $this->data;


        if (isset($content['Content']['published'])) {

    		$conditions =  array(

                'Content.parent_content_id' => $content_id,
    		);

    		$fields = array(
    			'Content.published' => $content['Content']['published']
			);

    		$this->updateAll($fields, $conditions);

        }
    	
    }


    public function sortSiblings($content_id) {

        $content_id = $this->checkId($content_id);

        $content = $this->data;

        $object = new Content();

        $options = array(
            'conditions' => array(
                'Content.parent_content_id' => $content['Content']['parent_content_id'],
                'NOT' => array(
                    'Content.id' => $content_id
                )
            ),
            'order' => array(
                'Content.sort',
            )
        );

        $siblings = $object->find('all', $options);

        $numSiblings = count($siblings);

        $sorted = array();
        $unsorted = array();

        $counter = 0;
        // separate unsorted items from sorted items
        foreach($siblings as $sibling) {

            if (0 === $sibling['Content']['sort']) {
                $unsorted[] = $sibling;
            } else {
                $sorted[] = $sibling;
                $counter++;
            }

        }

        // give the unsorted items a sort value
        foreach($unsorted as $sibling) {
            $sorted[] = $sibling;
            $counter++;
        }

        $sort = $content['Content']['sort'];

        if ($sort >= $numSiblings + 1) {
            // if the sort value is larger than the number of siblings
            array_push($sorted, $content); // put it at the end
        } elseif ($sort <= 1) {
            // if the sort value is less than or equal to 1
            array_unshift($sorted, $content); // put it in the front
        } else {
            // if the sort value is anything in between, 
            array_splice($sorted, $sort - 1, 0, array($content)); // put it there wrap content in an array so unshift is inconsequential.
        }

        // go through the fully sorted array and save the final sort values to the db
        $counter = 1;
        foreach ($sorted as $sibling) {

            if ($content_id !== $sibling['Content']['id']) {
                $sibling['Content']['sort'] = $counter;
                $sibling['Content']['modified'] = false;
                $object->save($sibling, array('callbacks' => false));
            } else {
            	$this->data['Content']['sort'] = $counter;
            }

            $counter++;

        }

    }



}

?>