<?php
App::uses("Folder", "Utility");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class TDirectoryTest extends CakeTestCase {
    
    public $fixtures = array(
        'plugin.ToastyCore.TDirectory', 
        'plugin.ToastyCore.TFile'
        
	);

	public function setUp() {
        parent::setUp();
        
        $this->Model = ClassRegistry::init("ToastyCore.TDirectory");
        // $this->Model->Behaviors->load('Tree');
    }

    public function tearDown() {
        $cleanUpPath = $this->Model->tFileRoot;
        $folder = new Folder();
        $deleted = $folder->delete($cleanUpPath);
    }

    public function testValidateName() {

        $data = array(
            $this->Model->alias => array(
                'name' => 'New Node',
                'parent_id' => 1
            )
        );

        $this->Model->set($data);
        $this->Model->validates();

        $invalidFields = $this->Model->validationErrors;

        $this->assertTrue(empty($invalidFields));


        $data = array(
            $this->Model->alias => array(
                'name' => 'Node 2',
                'parent_id' => 1
            )
        );

        $this->Model->create();
        $this->Model->set($data);

        $this->Model->validates();

        $invalidFields = $this->Model->validationErrors;

        $this->assertTrue(isset($invalidFields['name']));
        
    }

    public function testGetFullPath() {

        $testName = 'test';
        $expected = $this->Model->tFileRoot . DS . $testName;

        $result = $this->Model->getAbsolutePath($testName);

        $this->assertEquals($expected, $result);

    }

    public function testSave() {

        $data = array(
            $this->Model->alias => array(
                'name' => 'New Save Directory',
                'parent_id' => 1
            )
        );

        $this->Model->create();
        $this->Model->set($data);

        $result = $this->Model->save();

        $path = $this->Model->tFileRoot . DS . $this->Model->getPathFromId($data[$this->Model->alias]['parent_id']) . DS . $this->Model->normalizeName($data[$this->Model->alias]['name']);
        $this->assertTrue(is_dir($path));

        return $result;

    }

    public function testRename() {

        $new = $this->testSave();

        $data = array(
            $this->Model->alias => array(
                'name' => 'Update Directory',
                'parent_id' => 1
            )
        );

        $this->Model->id = $new[$this->Model->alias]['id'];
        $this->Model->read();
        
        $oldName = $new[$this->Model->alias]['name'];
        $oldPath = $this->Model->tFileRoot . DS . $this->Model->getPathFromId(1) . DS . $this->Model->normalizeName($oldName);
        $newPath = $this->Model->tFileRoot . DS . $this->Model->getPathFromId(1) . DS . $this->Model->normalizeName($data[$this->Model->alias]['name']);

        $this->assertTrue(is_dir($oldPath));

        $this->Model->data[$this->Model->alias]['name'] = $data[$this->Model->alias]['name'];
        $result = $this->Model->save();


        $this->assertTrue(is_dir($newPath));
        $this->assertFalse(is_dir($oldPath));
    }

    public function testMove() {

        $new = $this->testSave();

        $data = array(
            $this->Model->alias => array(
                'name' => 'Move Directory',
                'parent_id' => 6
            )
        );

        $this->Model->id = $new[$this->Model->alias]['id'];
        $this->Model->read();
        
        $oldName = $new[$this->Model->alias]['name'];
        $oldPath = $this->Model->tFileRoot . DS . $this->Model->getPathFromId(1) . DS . $this->Model->normalizeName($oldName);
        $newPath = $this->Model->tFileRoot . DS . $this->Model->getPathFromId($data[$this->Model->alias]['parent_id']) . DS . $this->Model->normalizeName($data[$this->Model->alias]['name']);

        $this->assertTrue(is_dir($oldPath));

        $this->Model->data[$this->Model->alias]['name'] = $data[$this->Model->alias]['name'];
        $this->Model->data[$this->Model->alias]['parent_id'] = $data[$this->Model->alias]['parent_id'];
        $result = $this->Model->save();

        $this->assertTrue(is_dir($newPath));
        $this->assertFalse(is_dir($oldPath));

    }

    public function testDelete() {

        $new = $this->testSave();

        $path = $this->Model->getAbsolutePath($this->Model->getPathFromId($this->Model->id));


        $exists = is_dir($path);
        $this->assertTrue($exists);
        
        $children = $this->Model->delete();

        $deleted = !is_dir($path);
        $this->assertTrue($deleted);

        

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

        $data = array( 
            $this->Model->alias => array(
                'parent_id' => $parent_id
            )
        );

        $result = $this->Model->isDescendant($data);

        $expected = false;


        $this->assertEqual($result, $expected);

    }

    

    

}