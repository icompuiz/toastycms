<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DocumentTypeTest extends CakeTestCase {
    
    public $fixtures = array(
        'plugin.ToastyCore.Document', 
        'plugin.ToastyCore.DocumentType', 
        'plugin.ToastyCore.DocumentTypeProperty', 
	);

	public function setUp() {
        parent::setUp();
        
        $this->Model = ClassRegistry::init("ToastyCore.DocumentType");
    }

    public function testIsDescendent() {
    	$search_id = 5;
		$parent_id = 1;

		$data = array(
			'parent_id' => $parent_id,
			'search_id' => $search_id
		);

		$result = $this->Model->isDescendant($data);

		$expected = true;

		$this->assertEqual($result, $expected);
    }

    public function testIsNotDescendent() {
    	$search_id = 6;
		$parent_id = 1;

		$data = array(
			'parent_id' => $parent_id,
			'search_id' => $search_id
		);

		$result = $this->Model->isDescendant($data);

		$expected = false;

		$this->assertEqual($result, $expected);
    }

    public function testHasManyDocument() {

    	$this->Model->id = 1;
        $this->Model->read();

        $documents = $this->Model->data['Document'];

        $expected = 'Root Page';
        $result = $documents[0]['name'];
		$this->assertEqual($result, $expected);

        $expected = 'Root 2';
        $result = $documents[1]['name'];
		$this->assertEqual($result, $expected);

    }


}

?>