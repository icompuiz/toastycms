<?php

class TDirectoriesControllerTest extends ControllerTestCase {

	public $fixtures = array(
        'plugin.ToastyCore.TDirectory', 
        'plugin.ToastyCore.TFile', 
	);

	public function setUp() {
        parent::setUp();
        
        $this->Model = ClassRegistry::init("ToastyCore.TFile");
        // $this->Model->Behaviors->load('Tree');
    }

	public function tearDown() {
        $cleanUpPath = $this->Model->TDirectory->tFileRoot;
        $folder = new Folder();
        $deleted = $folder->delete($cleanUpPath);
    }

	public function testIndex() {

		$result = $this->testAction('/toasty_core/t_directories/index.json');

		$result = json_decode($result, true);
		// debug($result);

	}

	public function testView() {
		$result = $this->testAction('/toasty_core/t_directories/view/1.json');
		$result = json_decode($result, true);
		debug($result);

	}

	public function testNotView() {

		$message ="";
		try {

			$result = $this->testAction('/toasty_core/t_directories/view/100.json');

		} catch (NotFoundException $e) {

			$message = $e->getMessage();
			
		}

		$this->assertEquals($message, "TDirectory not found");
	}

	public function testDelete() {

		$result = $this->testAction('/toasty_core/t_directories/delete/1.json',array(
        	'method' => 'DELETE',
    	));

		$result = json_decode($result, true);




	}

	public function testEdit() {
		 $data = array(
            'TDirectory' => array(
                'id' => 1,
                'name' => 'New Name'
            )
        );

        $result = $this->testAction(
            '/toasty_core/t_directories/edit/1.json',
            array('data' => $data, 'method' => 'put')
        );

        $document = ClassRegistry::init('TDirectory');

        $document->read(null, 1);

        $this->assertEquals($document->data['TDirectory']['name'], $data['TDirectory']['name']);

	}

	public function testAdd() {

		 $data = array(
            'TDirectory' => array(
                'name' => 'New Name',
                'parent_id' => 1
            )
        );

        $result = $this->testAction(
            '/toasty_core/t_directories/add.json',
            array(
            	'data' => $data, 
            	'method' => 'post'
        	)
        );

		$result = json_decode($result, true);


        $this->assertTrue(isset($result['tDirectory']['TDirectory']['id']));
        $this->assertEquals($data['TDirectory']['name'], $result['tDirectory']['TDirectory']['name']);        


	}

}

?>