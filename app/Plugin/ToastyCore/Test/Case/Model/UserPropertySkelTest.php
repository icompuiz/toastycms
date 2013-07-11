<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');
App::uses('Security', 'Utility');

class UserPropertySkelTest extends CakeTestCase {

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

        $this->UserPropertySkel = ClassRegistry::init('ToastyCore.UserPropertySkel');
    }

    public function testAddSkel() {

        $data =
                array(
                    'UserPropertySkel' =>
                    array(
                        'name' => 'email_address',
                        'group_id' => 1,
                        'input_format_id' => 1,
                        'output_format_id' => 2,
                        'created' => '2007-03-18 10:39:23',
                        'modified' => '2007-03-18 10:39:23'
                    )
        );

        $this->UserPropertySkel->addSkel($data);
        
        $id = 3;

        $skel = $this->UserPropertySkel->read(null, $id);
  
        $result = $skel['UserPropertySkel'];
        $expected = $data['UserPropertySkel'];
        $expected['id'] = $id;

        $this->assertEquals($result, $expected);
    }

    public function testGetName() {
        $id = 1;
        $result =$this->UserPropertySkel->getName($id);
        $expected = "first_name";
        
        $this->assertEquals($result, $expected);
    }

    public function testSetName() {
        
        $id = 2;
        
        $expected = "new name";
        $this->UserPropertySkel->setName($expected, $id);

        $skel = $this->UserPropertySkel->read(null, $id);
  
        $result = $skel['UserPropertySkel']['name'];
        
        $this->assertEquals($result, $expected);
    }

    public function testGetInputFormat() {
        
        $id = 2;
        $result =$this->UserPropertySkel->getInputFormat($id);
        $expected = array(
            'id' => 3,
            'name' => 'input_image_format',
            'system_path' => 'test_format3.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        $this->assertEquals($result, $expected);
    }

    public function testSetInputFormat() {
        
        $id = 1;
        $this->UserPropertySkel->setInputFormat(2, $id);
        
        $skel = $this->UserPropertySkel->read(null, $id);
  
        $result = $skel['InputFormat'];
        
        $expected = array(
            'id' => 2,
            'name' => 'test_two_format',
            'system_path' => 'test_format2.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        
        $this->assertEquals($result, $expected);
    }

    public function testGetOutputFormat() {
        $id = 2;
        $result =$this->UserPropertySkel->getOutputFormat($id);
        $expected =  array(
            'id' => 4,
            'name' => 'output_image_format',
            'system_path' => 'test_format4.php',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        $this->assertEquals($result, $expected);
    }

    public function testSetOutputFormat() {
        
        $id = 1;
        $this->UserPropertySkel->setOutputFormat(3, $id);
        
        $skel = $this->UserPropertySkel->read(null, $id);
  
        $result = $skel['OutputFormat'];
        
        $expected = array(
            'id' => 3,
            'name' => 'input_image_format',
            'system_path' => 'test_format3.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        
        $this->assertEquals($result, $expected);
    }

}

?>