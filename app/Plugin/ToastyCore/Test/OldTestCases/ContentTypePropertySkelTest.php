<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ContentTypePropertySkelTest extends CakeTestCase {
    

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

        $this->ContentTypePropertySkel = ClassRegistry::init('ToastyCore.ContentTypePropertySkel');
    }

    public function testAddSkel() {

        $data =
                array(
                    'ContentTypePropertySkel' =>
                    array(
                        'name' => 'another_property',
                        'content_type_id' => 4,
                        'input_format_id' => 3,
                        'output_format_id' => 4,
                        'created' => '2007-03-18 10:39:23',
                        'modified' => '2007-03-18 10:39:23'
                    )
        );

        $this->ContentTypePropertySkel->addSkel($data);
        
        $id = 3;

        $skel = $this->ContentTypePropertySkel->read(null, $id);
  
        $result = $skel['ContentTypePropertySkel'];
        $expected = $data['ContentTypePropertySkel'];
        $expected['id'] = $id;

        $this->assertEquals($result, $expected);
    }

    public function testGetName() {
        $id = 1;
        $result =$this->ContentTypePropertySkel->getName($id);
        $expected = "body";
        
        $this->assertEquals($result, $expected);
    }

    public function testSetName() {
        
        $id = 2;
        
        $expected = "new_property";
        $this->ContentTypePropertySkel->setName($expected, $id);

        $skel = $this->ContentTypePropertySkel->read(null, $id);
  
        $result = $skel['ContentTypePropertySkel']['name'];
        
        $this->assertEquals($result, $expected);
    }

    public function testGetInputFormat() {
        
        $id = 2;
        $result =$this->ContentTypePropertySkel->getInputFormat($id);
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
        $this->ContentTypePropertySkel->setInputFormat(2, $id);
        
        $skel = $this->ContentTypePropertySkel->read(null, $id);
  
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
        $result =$this->ContentTypePropertySkel->getOutputFormat($id);
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
        $this->ContentTypePropertySkel->setOutputFormat(3, $id);
        
        $skel = $this->ContentTypePropertySkel->read(null, $id);
  
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
