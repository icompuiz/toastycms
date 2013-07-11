<?php
App::uses('ToastyCoreAppModel', 'ToastyCore.Model');

class Group extends ToastyCoreAppModel {

    public $name = "Group";
    public $_schema = array(
        'id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'name' => array(
            'type' => 'string',
            'length' => 255
        ),
        'created' => array(
            'type' => 'datetime'
        ),
        'modified' => array(
            'type' => 'datetime'
        )
    );


    public function getName($group_id = null) {
        
        $group_id = $this->checkId($group_id);
        
        $conditions = array('Group.id' => $group_id);
        $group = $this->find('first', array('conditions' => $conditions));
        $name = $group['Group']['name'];
        
        return $name;
    }
    
    public function deleteGroup($group_id = null) {
        $group_id = $this->checkId($group_id);
        
        $deleted = $this->delete($group_id, false);
        
        return $deleted;
    }

    public function addGroup($data = null) {
        
        if (!$data) {
            return false;
        }
        
        $this->create($data);
        $saved_group  = $this->save();
        
        return $saved_group;
    }

    public function getUsers($group_id = null) {
        
        $group_id = $this->checkId($group_id);
        
        $conditions = array('Group.id' => $group_id);
        $group = $this->find('first', array('conditions' => $conditions));
        
        return $group['Users'];
    }

    public function setName($new_name, $group_id = null) {
        
        $group_id = $this->checkId($group_id);
        
        $data['Group'] = array(
            'id' => $group_id,
            'name' => $new_name
        );
        
        $this->save($data);
        
        return true;
    }

    public function isRoot($group_id = null) {

        $group_id = $this->checkId($group_id);

        $conditions = array('Group.id' => $group_id);
        $group = $this->find('first', array('conditions' => $conditions));
        $type = $group['Group']['type'];

        return $type === 'root';

    }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        if ($this->isRoot()) {

            return false;
        }

        return true;
    }

    public function afterDelete() {
        parent::afterDelete();

        $this->Users->updateAll(
            array('group_id' => '2'),
            array('Users.group_id' => $this->id)
        );

        $this->UserPropertySkel->updateAll(
            array('group_id' => '2'),
            array('UserPropertySkel.group_id' => $this->id)
        );
    }

    /**
     * A group has many users
     * a group has many group links
     * @var array 
     */
    public $hasMany = array(
        'Users' => array(
            'className' => 'ToastyCore.User'
        ),
        'UserPropertySkel' => array(
            'className' => 'ToastyCore.UserPropertySkel'
        )
    );

}
?>

