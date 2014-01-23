<?php

class DocumentsControllerTest extends ControllerTestCase {

	public $fixtures = array(
        'plugin.ToastyCore.Document', 
        'plugin.ToastyCore.DocumentType', 
        'plugin.ToastyCore.DocumentTypeProperty', 
        'plugin.ToastyCore.DocumentTemplate', 
        'plugin.ToastyCore.DocumentProperty'
	);

	public function testIndex() {
		$result = $this->testAction('/toasty_core/documents/index.json');

		$result = json_decode($result, true);

	}

	public function testView() {
		$result = $this->testAction('/toasty_core/documents/view/1.json');
		$result = json_decode($result, true);

	}

	public function testNotView() {

		$message ="";
		try {

			$result = $this->testAction('/toasty_core/documents/view/100.json');

		} catch (NotFoundException $e) {

			$message = $e->getMessage();
			
		}

		$this->assertEquals($message, "Document not found");
	}

	public function testDelete() {

		$result = $this->testAction('/toasty_core/documents/delete/1.json',array(
        	'method' => 'DELETE',
    	));

		$result = json_decode($result, true);




	}

	public function testEdit() {
		 $data = array(
            'Document' => array(
                'id' => 1,
                'name' => 'New Name'
            )
        );

        $result = $this->testAction(
            '/toasty_core/documents/edit/1.json',
            array('data' => $data, 'method' => 'put')
        );

        $document = ClassRegistry::init('Document');

        $document->read(null, 1);

        $this->assertEquals($document->data['Document']['name'], $data['Document']['name']);

	}

	public function testAdd() {

		 $data = array(
            'Document' => array(
                'name' => 'New Name',
                'parent_id' => 1
            )
        );

        $result = $this->testAction(
            '/toasty_core/documents/add.json',
            array(
            	'data' => $data, 
            	'method' => 'post'
        	)
        );


	}

}

?>