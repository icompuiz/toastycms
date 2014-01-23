<?php
App::uses("Folder", "Utility");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class TFileTest extends CakeTestCase {
    
    public $fixtures = array(
        'plugin.ToastyCore.TDirectory', 
        'plugin.ToastyCore.TFile'
        
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

     public function testValidateName() {

        $data = array(
            $this->Model->alias => array(
                'name' => 'NewNode.png',
                't_directory_id' => 1
            )
        );

        $this->Model->set($data);
        $this->Model->validates();

        $invalidFields = $this->Model->validationErrors;

        $this->assertTrue(empty($invalidFields));

        $data = array(
            $this->Model->alias => array(
                'name' => 'FileOne.jpg',
                't_directory_id' => 1
            )
        );

        $this->Model->create();
        $this->Model->set($data);

        $this->Model->validates();

        $invalidFields = $this->Model->validationErrors;

        $this->assertTrue(isset($invalidFields['name']));
        
    }

    public function testSave() {

        $data = array(
            $this->Model->alias => array(
                'name' => 'NewNode.jpg',
                't_directory_id' => 1
            )
        );

        $this->Model->create();
        $this->Model->set($data);

        $result = $this->Model->save();

        $path = $this->Model->TDirectory->tFileRoot . DS . $this->Model->TDirectory->getPathFromId($data[$this->Model->alias]['t_directory_id']) . DS . $this->Model->TDirectory->normalizeName($data[$this->Model->alias]['name']);
        $this->assertTrue(is_file($path));

        return $result;

    }

    public function testRename() {

        $new = $this->testSave();

        $data = array(
            $this->Model->alias => array(
                'name' => 'UpdateDirectory.jpg',
                't_directory_id' => 1
            )
        );

        $this->Model->id = $new[$this->Model->alias]['id'];
        $this->Model->read();
        
        $oldName = $new[$this->Model->alias]['name'];
        $oldPath = $this->Model->TDirectory->tFileRoot . DS . $this->Model->TDirectory->getPathFromId($new[$this->Model->alias]['t_directory_id'])  . $this->Model->TDirectory->normalizeName($oldName);
        $newPath = $this->Model->TDirectory->tFileRoot . DS . $this->Model->TDirectory->getPathFromId($data[$this->Model->alias]['t_directory_id'])  . $this->Model->TDirectory->normalizeName($data[$this->Model->alias]['name']);


        $this->assertTrue(is_file($oldPath));
       

        $this->Model->data[$this->Model->alias]['name'] = $data[$this->Model->alias]['name'];
        $result = $this->Model->save();


        $this->assertTrue(is_file($newPath));
        $this->assertFalse(is_file($oldPath));

    }

    public function testMove() {

        $dir = $this->createDir();


        $new = $this->testSave();

        $data = array(
            $this->Model->alias => array(
                'name' => 'MoveDirectory.jpg',
                't_directory_id' => $dir[$this->Model->TDirectory->alias]['id']
            )
        );

        $this->Model->id = $new[$this->Model->alias]['id'];
        $this->Model->read();
        
        $oldName = $new[$this->Model->alias]['name'];
        $oldPath = $this->Model->TDirectory->tFileRoot . DS . $this->Model->TDirectory->getPathFromId($new[$this->Model->alias]['t_directory_id'])  . $this->Model->TDirectory->normalizeName($oldName);
        $newPath = $this->Model->TDirectory->tFileRoot . DS . $this->Model->TDirectory->getPathFromId($data[$this->Model->alias]['t_directory_id'])  . $this->Model->TDirectory->normalizeName($data[$this->Model->alias]['name']);


        $this->assertTrue(is_file($oldPath));

        $result = $this->Model->save($data);

        $result = $this->Model->findById($result[$this->Model->alias]['id']);

        $this->assertTrue(is_file($newPath));
        $this->assertFalse(is_file($oldPath));
    }

    public function testDelete() {

        $new = $this->testSave();

        $path = $this->Model->TDirectory->getAbsolutePath($this->Model->TDirectory->getPathFromId($new[$this->Model->alias]['t_directory_id'])) . $new[$this->Model->alias]['name'];


        $exists = is_file($path);
        $this->assertTrue($exists);
        
        $this->Model->delete();

        $deleted = !is_file($path);
        $this->assertTrue($deleted);

        

    }

    private function createDir() {

        $data = array(
            $this->Model->TDirectory->alias => array(
                'name' => 'Move Directory',
                'parent_id' => 6
            )
        );

        $this->Model->TDirectory->create();
        $this->Model->TDirectory->set($data);

        return $this->Model->TDirectory->save();

    }
}
?>