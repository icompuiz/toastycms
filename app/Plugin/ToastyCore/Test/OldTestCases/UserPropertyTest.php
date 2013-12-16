<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class UserPropertyTest extends CakeTestCase {

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

        $this->UserProperty = ClassRegistry::init("ToastyCore.UserProperty");
    }

    public function testAddUserProperty() {

        $id = 2;

        $data['UserProperty'] = array(
            'value' => 'Nnodum',
            'user_id' => 1,
            'user_property_skel_id' => 2,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );

        $this->UserProperty->addUserProperty($data);

        $property = $this->UserProperty->read(null, $id);

        $result = $property['UserProperty'];
        $expected = $data['UserProperty'];
        $expected['id'] = $id;

        $this->assertEquals($result, $expected);
    }

    public function testSetValue() {

        $id = 1;
        $expected = "New Value";
        
        $this->UserProperty->setValue($expected, $id);
        
        $property = $this->UserProperty->read(null, $id);
        
        $result = $property['UserProperty']['value'];

        $this->assertEquals($result, $expected);
    }

    public function testGetValue() {
        
        $expected = "Isioma";
        $result = $this->UserProperty->getValue(1);

        $this->assertEquals($result, $expected);
    }

    public function testGetUser() {
        
        $expected = array(
            'id' => 1, 
            'username' => 'user1', 
            'password' => 'a1fc568e8104d91580079594101035b92e3fcce1', 
            'email' => 'user1@email.com', 
            'status' => "ACTIVE",
            'group_id' => 1, 
            'created' => '2007-03-18 10:39:23', 
            'modified' => '2007-03-18 10:41:31'
        );
        
        $result = $this->UserProperty->getUser(1);
        
        $this->assertEquals($result, $expected);
    }

}

?>
