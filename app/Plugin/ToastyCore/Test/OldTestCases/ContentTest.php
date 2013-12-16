<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ContentTest extends CakeTestCase {
    
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
        
        $this->Content = ClassRegistry::init("ToastyCore.Content");
    }
    
   public function testGetId() {
       $this->Content->id = 1;
        $result = $this->Content->getId();
        $expected = 1;

        $this->assertEqual($result, $expected);

    }

    public function testGetName() {
        $this->Content->id = 2;
        $result = $this->Content->getName();
        $expected = "Magical New Page";

        $this->assertEqual($result, $expected);

    }

    public function testSetName() {
        $expected = "New Page Renamed";
        
        $this->Content->setName($expected, 1);
        
        $content = $this->Content->read(null, 1);
        
        $result = $content['Content']['name'];

        $this->assertEqual($result, $expected);

    }

    public function testGetUser() {
        
        $result = $this->Content->getUser(1);
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

        $this->assertEqual($result, $expected);

    }

    public function testSetUser() {
        $this->Content->setUser(2,1);
        
        $expected = array(
            'id' => 2, 
            'username' => 'user2', 
            'password' => '2aa60a8ff7fcd473d321e0146afd9e26df395147', 
            'email' => 'user2@email.com', 
            'status' => "ACTIVE",
            'group_id' => 1, 
            'created' => '2010-03-18 10:39:23', 
            'modified' => '2010-03-18 10:41:31'
        );
        
        $content = $this->Content->read(null, 1);
        
        $result = $content['User'];
        
        

        $this->assertEqual($result, $expected);

    }

    

    public function testGetParent() {
        $result = $this->Content->getParent(2);
        $expected = array(
            'id' => 1,
            'name' => 'New Page',
            'user_id' => 1,
            'parent_content_id' => 0,
            'content_type_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            );

        $this->assertEqual($result, $expected);

    }
    
    
    public function testGetContentType() {
        $result = $this->Content->getContentType(2);
        $expected = array(
            'id' => 2,
            'name' => 'Magic Page',
            'content_template_id' => 2,
            'parent_content_type_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );

        $this->assertEqual($result, $expected);

    }

    public function testGetCreated() {
        $result = $this->Content->getCreated(1);
        $expected = "2007-03-18 10:39:23";

        $this->assertEqual($result, $expected);

    }

    public function testGetModified() {
        $result = $this->Content->getModified(2);
        $expected = "2007-03-18 10:39:23";

        $this->assertEqual($result, $expected);

    }
    
    public function testAllowUser() {
        $result = $this->Content->allowUser(1);
        $expected = "NOT READY";

        $this->assertEqual($result, $expected);

    }
    
}
?>
