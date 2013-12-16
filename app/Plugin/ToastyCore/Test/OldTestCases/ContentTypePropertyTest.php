<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ContentTypePropertyTest extends CakeTestCase {
    

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
        
        $this->ContentTypeProperty = ClassRegistry::init("ToastyCore.ContentTypeProperty");
    }
    
    public function testAddContentTypeProperty() {

        $id = 3;

        $data['ContentTypeProperty'] = array(
            'content_type_property_skel_id' => 1,
            'content_id' => 1,
            'value' => 'This is a content',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );

        $this->ContentTypeProperty->addContentTypeProperty($data);

        $property = $this->ContentTypeProperty->read(null, $id);

        $result = $property['ContentTypeProperty'];
        $expected = $data['ContentTypeProperty'];
        $expected['id'] = $id;

        $this->assertEquals($result, $expected);
    }

    public function testSetValue() {

        $id = 1;
        $expected = "New Value";
        
        $this->ContentTypeProperty->setValue($expected, $id);
        
        $property = $this->ContentTypeProperty->read(null, $id);
        
        $result = $property['ContentTypeProperty']['value'];

        $this->assertEquals($result, $expected);
    }

    public function testGetValue() {
        
        $expected = "This is a body";
        $result = $this->ContentTypeProperty->getValue(1);

        $this->assertEquals($result, $expected);
    }

    public function testGetContent() {
        
        $expected = array(
            'id' => 1,
            'name' => 'New Page',
            'user_id' => 1,
            'parent_content_id' => 0,
            'content_type_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        
        $result = $this->ContentTypeProperty->getContent(1);
        
        $this->assertEquals($result, $expected);
    }
}
?>
