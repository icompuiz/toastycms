<?php
class DocumentPropertyTest extends CakeTestCase {

    public $fixtures = array(
        'plugin.ToastyCore.Document',
        'plugin.ToastyCore.DocumentTypeProperty',
        'plugin.ToastyCore.DocumentProperty',
    );

    public function setUp() {
        parent::setUp();
        
        $this->Model = ClassRegistry::init("ToastyCore.DocumentProperty");
    }
    
    public function testGetValue() {

        $this->Model->id = 1;
        $expected = 'This is a body';
        $result = $this->Model->getValue();

        $this->assertEqual($result, $expected);

    }

    public function testSetValue() {


        $this->Model->id = 1;
        $expected = 'This is an awesome test';
        $this->Model->setValue($expected);
        $result = $this->Model->getValue();
        

        $this->assertEqual($result, $expected);

    }


    public function testBelongsToDocument() {

        $this->Model->id = 2;
        $this->Model->read();

        $expected = 'Node 4';
        $result = $this->Model->data['Document']['name'];
        
        $this->assertEqual($result, $expected);


    }

    public function testBelongsToDocumentTypeProperty() {

        $this->Model->id = 2;
        $this->Model->read();

        $expected = 'Property 2';
        $result = $this->Model->data['DocumentTypeProperty']['name'];
        
        $this->assertEqual($result, $expected);


    }

}
?>