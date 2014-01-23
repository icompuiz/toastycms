<?php

class DocumentsTemplatesControllerTest extends ControllerTestCase {

	public $fixtures = array(
        'plugin.ToastyCore.Document', 
        'plugin.ToastyCore.DocumentType', 
        'plugin.ToastyCore.DocumentTypeProperty', 
        'plugin.ToastyCore.DocumentTemplate', 
        'plugin.ToastyCore.DocumentProperty'
	);

	public function testIndex() {
		$result = $this->testAction('/toasty_core/document_templates/index.json');

		$result = json_decode($result, true);
	}

	public function testView() {
		$result = $this->testAction('/toasty_core/document_templates/view/1.json');
		$result = json_decode($result, true);

	}

	public function testNotView() {

		$message ="";
		try {

			$result = $this->testAction('/toasty_core/document_templates/view/100.json');

		} catch (NotFoundException $e) {

			$message = $e->getMessage();
			
		}

		$this->assertEquals($message, "Document Template not found");
	}

	public function testDelete() {

		$result = $this->testAction('/toasty_core/document_templates/delete/1.json',array(
        	'method' => 'DELETE',
    	));

		$result = json_decode($result, true);


	}

	public function testEdit() {

		$data = array(
            'DocumentTemplate' => array(

                'id' => 1,
                'name' => 'New Name',
                'system_path' => 'test'
            )
        );

        $result = $this->testAction(
            '/toasty_core/document_templates/edit/1.json',
            array('data' => $data, 'method' => 'put')
        );

        $document = ClassRegistry::init('DocumentTemplate');

        $document->read(null, 1);

        $this->assertEquals("New Name", $document->data['DocumentTemplate']['name']);

    }

    public function testAdd() {

         $data = array(
            'DocumentTemplate' => array(
                'parent_id' => 1,
                'name' => 'New Name',
                'system_path' => 'test'
            )
        );

        $result = $this->testAction(
            '/toasty_core/document_templates/add.json',
            array(
            	'data' => $data, 
            	'method' => 'post'
        	)
        );
        debug($result);



	}

}

?>