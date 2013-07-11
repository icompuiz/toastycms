<?php
App::uses('ToastyCoreAppModel', 'ToastyCore.Model');
App::uses('PropertyBase', 'ToastyCore.Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class UserProperty extends PropertyBase {

    public $name = 'UserProperty';
    public $_schema = array(
        'id' => array(
            'type' => 'integer',
            'length' => 11
        ),

        'value' => array(
            'type' => 'text'
        ),
        'user_id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'user_property_skel' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'created' => array(
            'type' => 'datetime'
        ),
        'modified' => array(
            'type' => 'datetime'
        )
    );

    public function addUserProperty($data = null) {
        
        
        if (!empty($data['UserProperty']) ) {
            
            $this->create($data);
            $this->save();
            
            return;
        }
        
        throw new Exception("index UserProperty must be defined");
        
    }
    public function setValue($value = null, $id = null) {
        
        $id = $this->checkId($id);
        
        if (!empty($value)) {
            
            $data['UserProperty'] = array(
                'id' => $id,
                'value' => $value
            );
            
            $this->save($data);
            
        }
        
        return;
    }
    public function getValue($id = null) {
        
        $id = $this->checkId($id);
        
        $conditions = array('UserProperty.id' => $id);
        $property = $this->find('first', array("conditions" => $conditions));
        
        $value = $property['UserProperty']['value'];
        
        return $value;
    }
    public function getUser($id = null) {
        $id = $this->checkId($id);
        
        $conditions = array('UserProperty.id' => $id);
        $property = $this->find('first', array("conditions" => $conditions));
        
        $user = $property['User'];
        
        return $user;
    }

    
     public $belongsTo = array(
        'User' => array(
            'className' => 'ToastyCore.User'
        ),
        'UserPropertySkel' => array(
            'className' => 'ToastyCore.UserPropertySkel'
            
        )
    );



}

?>
