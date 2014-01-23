<?php

class DocumentTypesControllerTest extends ControllerTestCase {


	public $fixtures = array(
        'plugin.ToastyCore.Document', 
        'plugin.ToastyCore.DocumentType', 
        'plugin.ToastyCore.DocumentTypeProperty', 
        'plugin.ToastyCore.DocumentTemplate', 
        'plugin.ToastyCore.DocumentProperty'
	);

	public function testIndex() {

		$result = $this->testAction('/toasty_core/document_types/index.json');

		$result = json_decode($result, true);

		// debug($result);

	}

	public function testView() {

		$result = $this->testAction('/toasty_core/document_types/view/1.json');
		$result = json_decode($result, true);
		
		// debug($result);
		
	}

	public function testAdd() {

		$data = array(
            'DocumentType' => array(
                'name' => 'New Type',
            )
        );

        $result = $this->testAction(
            '/toasty_core/document_types/add.json',
            array(
            	'data' => $data, 
            	'method' => 'post'
        	)
        );

        $result = json_decode($result, true);

        // debug($result);

	}
	
	public function testEdit() {


		$orig = $this->testAction('/toasty_core/document_types/view/1.json');

        $orig = json_decode($orig, true);

        $data['DocumentType']['id'] = $orig['document_type']['DocumentType']['id'];
        $data['DocumentType']['name'] = 'Updated Name';

        $result = $this->testAction(
            '/toasty_core/document_types/edit/1.json',
            array(
                'data' => $data, 
                'method' => 'put'
            )
        );

        $result = json_decode($result, true);

        $updated = $this->testAction('/toasty_core/document_types/view/1.json');

        // debug($updated); 

	}
	
	public function testDelete() {

		$data = array(
            'DocumentType' => array(
                'name' => 'New Type',
            )
        );

        $result = $this->testAction(
            '/toasty_core/document_types/add.json',
            array(
            	'data' => $data, 
            	'method' => 'post'
        	)
        );

        $result = json_decode($result, true);

        $id = $result['document_type']['DocumentType']['id'];

		$message = $this->testAction(
            "/toasty_core/document_types/delete/${id}.json",
            array(
                'method' => 'delete'
            )
        );

        $result = json_decode($message, true);

        // debug($result); 
        


	}


}