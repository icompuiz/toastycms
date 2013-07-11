<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');
App::uses('Group', 'ToastyCore.Model');
App::uses('Security', 'Utility');
App::uses('AuthComponent', 'Controller/Component');



class User extends ToastyCoreAppModel {
   

    public $name = "User";
    public $_schema = array(
        'id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'username' => array(
            'type' => 'string',
            'length' => 255
        ),
        'password' => array(
            'type' => 'string',
            'length' => 255
        ),
        'email' => array(
            'type' => 'string',
            'length' => 255
        ),
        'status' => array(
            'type' => 'string',
            'length' => 255
        ),
        'group_id' => array(
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

    public $validate = array(
        "password" =>array
        (
            'confirmation_match' => array(
                'rule' => 'confirmPassword'
            ),
            'length' => array(
                'rule' => array('minLength', 8),
                'message' => "Passwords must be at least 8 characters long"
            )
        )
    );

    public function confirmPassword($data) {

        $password = $data['password'];
        $confirmation = $this->data['User']['password_confirmation'];

        if ($password === $confirmation) {
            return true;
        }

        return "Password and confirmation must match";

    }

    public function addUser($data) {
        
        $plain_pasword = $data['User']['password'];
        $hashed_password = Security::hash($plain_pasword);
        
        $data['User']['password'] = $hashed_password;
        
        $this->create($data);
        $this->save();
        
        $new_user = $this->read();
   
        return $new_user;
    }

    public function deleteUser($user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        $deleted =$this->delete($user_id, true);
        
        return $deleted;
    }

    public function disableUser($user_id = null) {
        
        if (!$user_id) {
            if ($this->id) {
                $user_id = $this->id;
            }
        }
        
        if(!$user_id) {
            return false;
        }
        
        $data = array(
            
            'User' => array(
                
                'id' => $user_id,
                'status' => _USER_STATUS_DISABLED
                
            )
            
        );
        
        $this->save($data);
        
        return true;
    }

    public function setGroup( $group_id = null, $user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        if ($group_id) {
            $data = array(
                'User' => array(
                    'id' => $user_id,
                    'group_id' => $group_id
                )
            );
            
            $this->save($data);
            
            
            return true;
        }
        
        return false;
    }

    public function setUsername($username, $user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        $username = trim($username);
        
        if ($username) {
            
            $data = array(
                'User' => array(
                    'id' => $user_id,
                    'username' => $username
                )
            );
            
            $this->save($data);
            
            return true;
        }
        
        throw new Exception("username must be supplied");
    }

    public function setPassword($plain_password, $user_id = null) {
        
        
        $user_id = $this->checkId($user_id);

        
        if ($plain_password) {
            
            $hashed_password = Security::hash($plain_password);
            
            $data = array(
                'User' => array(
                    'id' => $user_id,
                    'password' => $hashed_password
                )
            );
            
            $this->save($data);
         
            return true;    
        } else {
            
            return false;
            
        }
    }

    public function setProperty($data, $user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        $uprop = ClassRegistry::init('UserProperty');
        
        $uprop->save($data);
        
        
        return true;
    }
    
    public function getProperty($skel_id, $user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        $uprop = ClassRegistry::init('UserProperty');
        $property = $uprop->find('first', array('conditions' => array( 'UserProperty.user_id' => $user_id, 'UserProperty.user_property_skel_id' => $skel_id )));
        
        return $property;
    }

    public function setEmail($new_email, $user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        $new_email = trim($new_email);
        
        if ($new_email) {
            
            $data = array(
                'User' => array(
                    'id' => $user_id,
                    'email' => $new_email
                )
            );
            
            
            $this->save($data);
            
            return true;
        }
        
        
        return;
    }
    public function getUsername($user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        $conditions = array(
            'User.id' => $user_id
        );
        $user = $this->find('first', array("conditions" => $conditions));
        
        
        $username = $user['User']['username'];
        
        return $username;
        
    }

    public function getGroup($user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        $conditions = array(
            'User.id' => $user_id
        );
        $user = $this->find('first', array("conditions" => $conditions));
        
        $group = $user['User']['group_id'];
        
        return $group;
        
        
    }

    public function getPassword($user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        $conditions = array(
            'User.id' => $user_id
        );
        $user = $this->find('first', array("conditions" => $conditions));
        
        $password = $user['User']['password'];
        
        return $password;
    }
    
    public function getEmail($user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        $conditions = array(
            'User.id' => $user_id
        );
        $user = $this->find('first', array("conditions" => $conditions));
        
        $email = $user['User']['email'];
        
        return $email;
    }

    public function getModified($user_id = null) {
        
        
        $user_id = $this->checkId($user_id);
        
        $conditions = array(
            'User.id' => $user_id
        );
        $user = $this->find('first', array("conditions" => $conditions));
        
        $modified = $user['User']['modified'];
        
        return $modified;
    }

    public function getCreated($user_id = null) {
        
        $user_id = $this->checkId($user_id);
        
        $conditions = array(
            'User.id' => $user_id
        );
        $user = $this->find('first', array("conditions" => $conditions));
        
        $created = $user['User']['created'];
        
        return $created;
    }
    
    public function getStatus($user_id = null) {
        
        $user_id = $this->checkId($user_id);
        
        $conditions = array(
            'User.id' => $user_id
        );
        $user = $this->find('first', array("conditions" => $conditions));
        
        $status = $user['User']['status'];
        
        return $status;
    }
    
    

    public function login() {
        return;
    }

    public function beforeSave($cascade = true) {

        parent::beforeSave($cascade);

        $password = "";

        if (isset($this->data['User']['password'])) {
            $password = $this->data['User']['password'];
            if ( !empty($password)) {
                $password = AuthComponent::password($this->data['User']['password']);
                $this->data['User']['password'] = $password;
            }
        }



        return true;

    }

     public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        if ($this->isRoot()) {

            return false;
        }

        $this->Content->updateAll(
            array('user_id' => '-1'),
            array('Content.user_id' => $this->id)
        );

        $all = $this->UserProperties->find('all', array('conditions' =>
            array('UserProperties.user_id' => $this->id)
            )
        );

        foreach ($all as $one) {
            $this->UserProperties->id = $one['UserProperties']['id'];
            $this->UserProperties->delete();
        }

        return true;
    }

    public function isRoot($user_id = null) {

        $user_id = $this->checkId($user_id);

        $conditions = array('User.id' => $user_id);
        $user = $this->find('first', array('conditions' => $conditions));
        $type = $user['User']['type'];
        return $type === 'root';

    }

    

    
    

    public $belongsTo = array(
        'Group' => array(
            'className' => 'ToastyCore.Group'
        )
    );
    
    public $hasMany = array(
        'UserProperties' => array(
            'className' => 'ToastyCore.UserProperty'
        ),
        'Content' => array(
            'className' => 'ToastyCore.Content'
        )
    );
    

}

?>