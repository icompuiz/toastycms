<?php

class DocumentPropertiesControllerTest extends ControllerTestCase {

	public $fixtures = array(
        'plugin.ToastyCore.Document', 
        'plugin.ToastyCore.DocumentType', 
        'plugin.ToastyCore.DocumentTypeProperty', 
        'plugin.ToastyCore.DocumentTemplate', 
        'plugin.ToastyCore.DocumentProperty'
	);

	public function testIndex() {

		$result = $this->testAction('/toasty_core/document_properties/index.json');

		$result = json_decode($result, true);

		// debug($result);
	}

	public function testAdd() {

 		$data = array(
            'DocumentProperty' => array(
                'document_type_property_id' => 1,
                'document_id' => 6,
                'value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
            )
        );

        $result = $this->testAction(
            '/toasty_core/document_properties/add.json',
            array(
            	'data' => $data, 
            	'method' => 'post'
        	)
        );

        $result = json_decode($result, true);


        $this->assertTrue(isset($result['documentProperty']['DocumentProperty']['id']));
        $this->assertEquals($data['DocumentProperty']['value'], $result['documentProperty']['DocumentProperty']['value']);
        



	}

    public function testEdit() {

        $orig = $this->testAction('/toasty_core/document_properties/view/1.json');

        $orig = json_decode($orig, true);

        $data['DocumentProperty']['id'] = $orig['documentProperty']['DocumentProperty']['id'];
        $data['DocumentProperty']['value'] = 'El snort testosterone trophy driving gloves handsome, dis el snort handsome gent testosterone trophy Fallen eyebrow driving gloves cardinal richelieu gentleman face broom, chevron driving gloves dis cardinal richelieu gentleman gent el snort handsome ron burgundy Leonine funny walk groucho marx Fallen eyebrow rock n roll star great dictator testosterone trophy face broom?';

        $result = $this->testAction(
            '/toasty_core/document_properties/edit/1.json',
            array(
                'data' => $data, 
                'method' => 'put'
            )
        );


        $updated = $this->testAction('/toasty_core/document_properties/view/1.json');

        $updated = json_decode($updated, true);

        $this->assertEquals($data['DocumentProperty']['value'], $updated['documentProperty']['DocumentProperty']['value']);
        

    }

    public function testDelete() {


        $message = $this->testAction(
            '/toasty_core/document_properties/delete/1.json',
            array(
                'method' => 'delete'
            )
        );

        $result = json_decode($message, true);

        $this->assertEquals($result['message'], 'Property 1 was successfully deleted');


    }

}