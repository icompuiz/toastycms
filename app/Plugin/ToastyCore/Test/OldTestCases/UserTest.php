<?php

App::uses("User", "ToastyCore.Model");

class UserTest extends CakeTestCase {
    
    public $fixtures = array(
        'plugin.ToastyCore.User', 
        'plugin.ToastyCore.Group', 
        'plugin.ToastyCore.UserPropertySkel', 
        'plugin.ToastyCore.UserProperty', 
        'plugin.ToastyCore.OutputFormat',
        'plugin.ToastyCore.Content',
        'plugin.ToastyCore.ContentTypePropertySkel',
        'plugin.ToastyCore.ContentTypeProperty',
        'plugin.ToastyCore.ContentType',
        'plugin.ToastyCore.ContentTemplate'
    );
    
    
    public function setUp() {
        
        parent::setUp();
        
        $this->User = ClassRegistry::init('ToastyCore.User');
        
        

    }
    

    public function testAddUser() {
        
        $plain_password = "new_password";
        $hashed_password = Security::hash($plain_password);
        
        $data = array(
            'User' => array(
                'username' => 'user2', 
                'password' => $plain_password, 
                'email' => 'user2@email.com', 
                'status' => "ACTIVE",
                'group_id' => 1, 
                'created' => '2013-03-18 10:39:23', 
                'modified' => '2013-03-18 10:41:31'
            )
        );
        
        $result = $this->User->addUser($data);
        
        $expected = $data;
        
        $expected['User']['id'] = 3;
        $expected['User']['password'] = $hashed_password;

        $this->assertEquals($expected['User'], $result['User']);

    }

    public function testDeleteUser() {
        $result = $this->User->deleteUser(1);
        $expected = true;

        $this->assertEquals($expected, $result);

    }

    public function testDisableUser() {
        
        $this->User->disableUser(1);
        
        $user = $this->User->read(null, 1);
        
        $result = $user['User']['status'];
        $expected = _USER_STATUS_DISABLED;
        
        $this->assertEqual($result, $expected);
    }

    public function testSetGroup() {
        $this->User->setGroup(2, 1);
        
        $expected = array(
            'id' => 2, 
            'name' => 'group2',  
            'created' => '2007-03-18 10:39:23', 
            'modified' => '2007-03-18 10:41:31'
        );
        
        $user = $this->User->read(null, 1);
        
        $result = $user['Group'];

        $this->assertEqual($result, $expected);

    }

    public function testSetUsername() {
        
        $expected  = "newusername";
        
        $this->User->setUsername($expected,1);
        
        $user = $this->User->read(null, 1);
        
        $result = $user['User']['username'];

        $this->assertEquals($expected, $result);

    }

    public function testSetPassword() {
        
        $plain_password = "new password";
        $hashed_password = Security::hash($plain_password);
        
        $this->User->setPassword($plain_password, 1);
        $expected = $hashed_password;
        
        $user = $this->User->read(null, 1);
        
        $result = $user['User']['password'];

        $this->assertEquals($expected, $result);

    }

    public function testSetProperty() {
        
        $data = array(
            'id' => 1,
            'value' => 'Jackson',
            'user_id' => 1,
            'user_property_skel_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        
        $expected = $data;
        
        
        $this->User->setProperty($data, 1);
        
        $uprop = ClassRegistry::init('UserProperty');
        $result = $uprop->read(null, 1);
        
        $this->assertEquals($expected, $result['UserProperty']);

    }
    
    public function testGetProperty() {
        $expected = array(
            'id' => 1,
            'value' => 'Isioma',
            'user_id' => 1,
            'user_property_skel_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        $result = $this->User->getProperty(1,1);
        
        $this->assertEquals($expected, $result['UserProperty']);
    }
    
    public function testGetEmail() {
        
        $expected = 'user1@email.com';
        
        $result = $this->User->getEmail(1);
        
        $this->assertEquals($expected, $result);

        
    }

    public function testSetEmail() {
        
        $expected = "user1_changed@email.com";
        $this->User->setEmail($expected, 1);
        $this->User->getEmail();
        
        $user = $this->User->read(null, 1);
        
        $result = $user['User']['email'];

        $this->assertEquals($expected, $result);
        
        

    }

    public function testGetId() {
        
        $this->User->id = 1000;
        $result = $this->User->getId();
        $expected = 1000;

        $this->assertEquals($expected, $result);

    }

    public function testGetUsername() {
        
        $result = $this->User->getUsername(1);
        $expected = "user1";

        $this->assertEquals($expected, $result);

    }

    public function testGetGroup() {
        $result = $this->User->getGroup(1);
        $expected = 1;

        $this->assertEquals($expected, $result);

    }

    public function testGetPassword() {
        
        $result = $this->User->getPassword(1);
        $expected = "a1fc568e8104d91580079594101035b92e3fcce1";

        $this->assertEquals($expected, $result);

    }

    public function testGetModified() {
        $result = $this->User->getModified(1);
        $expected = '2007-03-18 10:41:31';

        $this->assertEquals($expected, $result);

    }

    public function testGetCreated() {
        $result = $this->User->getCreated(1);
        $expected = '2007-03-18 10:39:23';

        $this->assertEquals($expected, $result);

    }

    public function testLogin() {
        $result = $this->User->login();
        $expected = "NOT READY";

        $this->assertEquals($expected, $result);

    }
    
}


?>
