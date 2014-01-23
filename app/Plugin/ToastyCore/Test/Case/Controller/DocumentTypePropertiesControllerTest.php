<?php

class DocumentTypePropertiesControllerTest extends ControllerTestCase {

	public $fixtures = array(
        'plugin.ToastyCore.Document', 
        'plugin.ToastyCore.DocumentType', 
        'plugin.ToastyCore.DocumentTypeProperty', 
        'plugin.ToastyCore.DocumentTemplate', 
        'plugin.ToastyCore.DocumentProperty'
	);

	public function testIndex() {

		$result = $this->testAction('/toasty_core/document_type_properties/index.json');

		$result = json_decode($result, true);

		// debug($result);


	}

	public function testAdd() {

 		$data = array(
            'DocumentTypeProperty' => array(
                'name' => 'New Property',
                'document_type_id' => 1,
            )
        );

        $result = $this->testAction(
            '/toasty_core/document_type_properties/add.json',
            array(
            	'data' => $data, 
            	'method' => 'post'
        	)
        );
        $result = json_decode($result, true);


        // debug($result);



	}

    public function testEdit() {

        $orig = $this->testAction('/toasty_core/document_type_properties/view/1.json');

        $orig = json_decode($orig, true);

        $data['DocumentTypeProperty']['id'] = $orig['documentTypeProperty']['DocumentTypeProperty']['id'];
        $data['DocumentTypeProperty']['name'] = 'Updated Name';

        $result = $this->testAction(
            '/toasty_core/document_type_properties/edit/1.json',
            array(
                'data' => $data, 
                'method' => 'put'
            )
        );

        $result = json_decode($result, true);

        $updated = $this->testAction('/toasty_core/document_type_properties/view/1.json');

        // debug($updated);

    }

    public function testDelete() {


        $message = $this->testAction(
            '/toasty_core/document_type_properties/delete/1.json',
            array(
                'method' => 'delete'
            )
        );

        $result = json_decode($message, true);

        debug($result);

    }

}