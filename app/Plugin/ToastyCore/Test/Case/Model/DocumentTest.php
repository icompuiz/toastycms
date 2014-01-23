<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DocumentTest extends CakeTestCase {
    
    public $fixtures = array(
        'plugin.ToastyCore.Document', 
        'plugin.ToastyCore.DocumentType', 
        'plugin.ToastyCore.DocumentProperty'
        
	);

	public function setUp() {
        parent::setUp();
        
        $this->Model = ClassRegistry::init("ToastyCore.Document");
        // $this->Model->Behaviors->load('Tree');
    }

    public function testGetId() {
		$this->Model->id = 2;
		$result = $this->Model->id;
		$expected = 2;
		$this->assertEqual($result, $expected);

    }

    public function testGetPathFromId() {

		// $this->Model->id = 2;
		$result = $this->Model->getPathFromId(7);
		$expected = 'root_page/node_3/node_7';
		
		$this->assertEqual($result, $expected);


    }

    public function testGetIdFromPath() {

		// $this->Model->id = 2;
		$path = 'root_page/node_3/node_6';
		$result = $this->Model->getIdFromPath($path);
		$expected = 6;
		
		$this->assertEqual($result, $expected);


    }

    public function testIsDescendant() {

		$search_id = 2;
		$parent_id = 1;

		$data = array(
			'parent_id' => $parent_id,
			'search_id' => $search_id
		);

		$result = $this->Model->isDescendant($data);

		$expected = true;

		$this->assertEqual($result, $expected);
    }

    public function testIsNotDescendant() {

		$search_id = 3;
		$parent_id = 2;

		$data = array( 'Document' => array('parent_id' => $parent_id));

		$result = $this->Model->isDescendant($data);

		$expected = false;


		$this->assertEqual($result, $expected);

    }

    public function testPublishDescendants() {

    	$root_id = 2;
    	$this->Model->publishChildren($root_id);
    	$expected = 1;
    	$children = $this->Model->children($root_id);
    	foreach($children as $child) {
    		$result = $child['Document']['published'];
    		$this->assertEqual($result, $expected);
    	}

    }

    public function testUnpublishDescendants() {

    	$root_id = 2;
    	$this->Model->unpublishChildren($root_id);
    	$expected = 0;
    	$children = $this->Model->children($root_id);
    	foreach($children as $child) {

    		$result = $child['Document']['published'];

    		$this->assertEqual($result, $expected);
    	}

    }

    public function testBelongsToDocumentType() {

        $this->Model->id = 1;
        $this->Model->read();

        $expected = 'Root Document Type 1';
        $result = $this->Model->data['DocumentType']['name'];
        
        $this->assertEqual($result, $expected);


    }

}