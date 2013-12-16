<?php

class DocumentTypePropertyTest extends CakeTestCase {

	public $fixtures = array(
        'plugin.ToastyCore.DocumentType', 
        'plugin.ToastyCore.DocumentTypeProperty', 
	);

	public function setUp() {
        parent::setUp();
        
        $this->Model = ClassRegistry::init("ToastyCore.DocumentTypeProperty");
    }

    public function testBelongsToDocumentType() {

        $this->Model->id = 1;
        $this->Model->read();

        $expected = 'Root Document Type 2';
        $result = $this->Model->data['DocumentType']['name'];
        
        $this->assertEqual($result, $expected);


    }

}

?>