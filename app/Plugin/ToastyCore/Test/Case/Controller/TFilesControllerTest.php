<?php

class TFilesControllerTest extends ControllerTestCase {

    public $fixtures = array(
        'plugin.ToastyCore.TDirectory', 
        'plugin.ToastyCore.TFile', 
    );

    public function setUp() {
        parent::setUp();
        
        $this->Model = ClassRegistry::init("ToastyCore.TFile");
    }

    public function tearDown() {
        $cleanUpPath = $this->Model->TDirectory->tFileRoot;
        $folder = new Folder();
        $deleted = $folder->delete($cleanUpPath);
    }

	public function testIndex() {

		$result = $this->testAction('/toasty_core/t_files/index.json');

		$result = json_decode($result, true);

        // debug($result); exit;

	}

    public function testAdd() {

        $data = array(
            $this->Model->alias => array(
                'name' => 'NewNode.jpg',
                't_directory_id' => 1
            )
        );

        $result = $this->testAction(
            '/toasty_core/t_files/add.json',
            array(
                'data' => $data, 
                'method' => 'post'
            )
        );

        $result = json_decode($result, true);


        $this->assertTrue(isset($result['tFile']['TFile']['id']));
        $this->assertEquals($data['TFile']['name'], $result['tFile']['TFile']['name']);
    
    }

    public function testView() {
        $result = $this->testAction('/toasty_core/t_files/view/1.json');
        $result = json_decode($result, true);
        debug($result);

    }

    public function testNotView() {

        $message ="";
        try {

            $result = $this->testAction('/toasty_core/t_files/view/100.json');

        } catch (NotFoundException $e) {

            $message = $e->getMessage();
            
        }

        $this->assertEquals($message, "TFile not found");
    }

    public function testEdit() {

        $orig = $this->testAction('/toasty_core/t_files/view/1.json');

        $orig = json_decode($orig, true);


        $data['TFile']['id'] = $orig['tFile']['TFile']['id'];
        $data['TFile']['name'] = 'AnotherName.jpg';

        $result = $this->testAction(
            '/toasty_core/t_files/edit/1.json',
            array(
                'data' => $data, 
                'method' => 'put'
            )
        );


        $updated = $this->testAction('/toasty_core/t_files/view/1.json');

        $updated = json_decode($updated, true);

        $this->assertEquals($data['TFile']['name'], $updated['tFile']['TFile']['name']);
        

    }

    public function testDelete() {


        $message = $this->testAction(
            '/toasty_core/t_files/delete/1.json',
            array(
                'method' => 'delete'
            )
        );

        $result = json_decode($message, true);

        $this->assertEquals($result['message'], 'TFile 1 was successfully deleted');


    }
}
?>
