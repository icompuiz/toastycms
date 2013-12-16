<?php

class ContentTypeTest extends CakeTestCase {

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

        $this->ContentType = ClassRegistry::init("ToastyCore.ContentType");
    }

    public function testAddType() {
        $data = array(
            'name' => 'Magic Page Name',
            'content_template_id' => 2,
            'parent_content_type_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        
        $this->ContentType->addType($data);
        
        $expected = $data;
        $expected['id'] = 6;
        
        $type = $this->ContentType->read(null, 6);
        
        $result = $type['ContentType'];

        $this->assertEqual($result, $expected);
    }

    public function testDeleteType() {
        $expected = true;
        
        $this->ContentType->delete(5);
        
        $type = $this->ContentType->read(null, 5);
        
        $result = empty($type);

        $this->assertEqual($result, $expected);
    }

    public function testSetName() {
        
        $expected = "New Name NAME ANMAE";
        
        $this->ContentType->setName($expected, 4);
        
        $type = $this->ContentType->read(null, 4);
        
        $result = $type['ContentType']['name'];

        $this->assertEqual($result, $expected);
    }

    public function testGetName() {
        $expected = "klfsdlkmfdlkmdfklmdfklmdfklmfdklmfdldkf";
        $type = $this->ContentType->read(null, 5);
        
        $result = $type['ContentType']['name'];

        $this->assertEqual($result, $expected);

        
    }

    public function testSetParentType() {
        
        $expected = array(
            'id' => 3,
            'name' => 'dfdgfkjkjngdfjknfgnjkfgnjkfgjfkg',
            'content_template_id' => 3,
            'parent_content_type_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        
        $this->ContentType->setParentType(3,4);
        
        $type = $this->ContentType->read(null, 4);
        
        $result = $type['ParentContentType'];

        $this->assertEqual($result, $expected);
        

    }

    public function testGetParentType() {
        $expected = array(
            'id' => 4,
            'name' => 'dfkjfdkjndfkfdkfdikfdikfdfdmkjl',
            'content_template_id' => 0,
            'parent_content_type_id' => 0,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        $type = $this->ContentType->read(null, 5);
        
        $result = $type['ParentContentType'];

        $this->assertEqual($result, $expected);
    }

    public function testGetChildTypes() {
        $expected = array(
            
            array(
                'id' => 2,
                'name' => 'Magic Page',
                'content_template_id' => 2,
                'parent_content_type_id' => 1,
                'created' => '2007-03-18 10:39:23',
                'modified' => '2007-03-18 10:39:23'
            )
            ,
            array(
                'id' => 3,
                'name' => 'dfdgfkjkjngdfjknfgnjkfgnjkfgjfkg',
                'content_template_id' => 3,
                'parent_content_type_id' => 1,
                'created' => '2007-03-18 10:39:23',
                'modified' => '2007-03-18 10:39:23'
            )
            
        );
        $type = $this->ContentType->read(null, 1);
        
        $result = $type['ChildContentTypes'];

        $this->assertEqual($result, $expected);
    }

    public function testSetTemplate() {
         
        $this->ContentType->setTemplate(5,1);
        
        $type = $this->ContentType->read(null, 1);
        
        $result = $type['ContentTemplate'];
        
        $expected = array(
            'id' => 5,
            'parent_content_template_id' => 3,
            'name' => 'hghjgm,jhhgsgsgfbsgfbgfb',
            'system_path' => 'test_template5.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );

        $this->assertEqual($result, $expected);
    }

    public function testGetTemplate() {
        $expected = array(
            'id' => 2,
            'parent_content_template_id' => 1,
            'name' => 'Magic Page Template',
            'system_path' => 'test_template2.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        
        
        $type = $this->ContentType->read(null, 2);
        
        $result = $type['ContentTemplate'];

        $this->assertEqual($result, $expected);
    }

}

?>
