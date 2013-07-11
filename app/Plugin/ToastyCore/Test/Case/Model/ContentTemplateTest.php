<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ContentTemplateTest extends CakeTestCase {

    public $fixtures = array(
        'plugin.ToastyCore.User', 
        'plugin.ToastyCore.Group', 
        'plugin.ToastyCore.UserPropertySkel', 
        'plugin.ToastyCore.UserProperty', 
        'plugin.ToastyCore.OutputFormat',
        'plugin.ToastyCore.Content',
        'plugin.ToastyCore.ContentTypePropertySkel',
        'plugin.ToastyCore.ContentTypeProperty',
        'plugin.ToastyCore.ContentType',
        'plugin.ToastyCore.ContentTemplate'
    );
    
    public $test_contents = "t I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain c";
    public $test_contents_2 = "t iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae si";


    public function setUp() {
        parent::setUp();

        $this->ContentTemplate = ClassRegistry::init("ToastyCore.ContentTemplate");
        
        $paths = App::path('View', 'ToastyCore') ;
        $base_path = $paths[0].  'Elements' . DS . 'ContentTemplates'. DS . 'test_template1.ctp';
        
        $file = new File($base_path);
        
        $file->create();
        $file->open('w');
        $file->write($this->test_contents);
        $file->close();
    }
    
    public function tearDown() {
        parent::tearDown();
        
        $paths = App::path('View', 'ToastyCore') ;
        $base_path = $paths[0].  'Elements' . DS . 'ContentTemplates'. DS;
        
        $folder = new Folder($base_path);
        
        $files = $folder->read();
        
        foreach ( $files[1] as $item) {
            
            if (preg_match('/^test_/', $item)) {
                $file = new File($folder->path . $item);
                $file->delete();
            }
        }
        
    }

    public function testAddTemplate() {
        
        $data = array(
            'parent_content_template_id' => 0,
            'name' => 'Added Template',
            'system_path' => 'test_templatex.ctp',
            'created' => '2010-03-18 10:39:23',
            'modified' => '2010-03-18 10:39:23'
        );
        
        
        
        $this->ContentTemplate->addTemplate($data);
        
        $expected_id = 6;
        
        $expected = $data;
        $expected['id'] = $expected_id;
        
        $template = $this->ContentTemplate->read(null, $expected_id);
        $result = $template['ContentTemplate'];
        
//        debug($result); exit;

        $this->assertEquals($expected, $result);
    }

    public function testDeleteTemplate() {
        
        $id = 1;
        
        $this->ContentTemplate->deleteTemplate($id);
        
        $template = $this->ContentTemplate->read(null, $id);
        
        $result = empty($template);
        
        $expected = true;

        $this->assertEquals($expected, $result);
    }

    public function testGetChildTemplates() {
        $result = $this->ContentTemplate->getChildTemplates(3);
        $expected = array(
            array(
                'id' => 4,
                'parent_content_template_id' => 3,
                'name' => 'fgngfndfnhfnnhdnhhd',
                'system_path' => 'test_template4.ctp',
                'created' => '2007-03-18 10:39:23',
                'modified' => '2007-03-18 10:39:23'
            ),
            array(
                'id' => 5,
                'parent_content_template_id' => 3,
                'name' => 'hghjgm,jhhgsgsgfbsgfbgfb',
                'system_path' => 'test_template5.ctp',
                'created' => '2007-03-18 10:39:23',
                'modified' => '2007-03-18 10:39:23'
            )  
        );
        $this->assertEquals($expected, $result);
    }

    public function testGetParentTemplate() {
        
        $expected = array(
            'id' => 1,
            'parent_content_template_id' => 0,
            'name' => 'Web Page Standard Template',
            'system_path' => 'test_template1.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        
        $result = $this->ContentTemplate->getParentTemplate(2);

        $this->assertEquals($expected, $result);
    }

    public function testGetName() {
        $result = $this->ContentTemplate->getName(4);
        $expected = 'fgngfndfnhfnnhdnhhd';
        
        $this->assertEquals($expected, $result);
    }

    public function testSetName() {
        
        $expected = "New Name";
        $id = 4;
        
        $this->ContentTemplate->setName('New Name', $id);
        
        $template = $this->ContentTemplate->read(null, $id);
        
        $result = $template['ContentTemplate']['name'];
        
        $this->assertEquals($expected, $result);
    }

    public function testGetPath() {
        
        $result = $this->ContentTemplate->getPath(3);
        $expected = 'test_template3.ctp';

        $this->assertEquals($expected, $result);
    }

    public function testSetPath() {
        $expected = 'test_templatey.ctp';
        $id = 4;
        
        $this->ContentTemplate->setPath($expected,$id);
        
        $template = $this->ContentTemplate->read(null, $id);
        
        $result = $template['ContentTemplate']['system_path'];
        
        $this->assertEquals($expected, $result);
    }

    public function testReadFile() {
        $id = 1;
        
        $result = $this->ContentTemplate->readFile($id);
        
        $expected = $this->test_contents;
        
        $this->assertEqual($expected, $result);
    }

    public function testWriteFile() {
        $id = 1;
        
        $expected = $this->test_contents_2;
        
        $this->ContentTemplate->writeFile($expected, $id);
        
        
        $paths = App::path('View', 'ToastyCore') ;
        $base_path = $paths[0].  'Elements' . DS . 'ContentTemplates'. DS;
        
        $absPath = $base_path . 'test_template1.ctp';
        
        $file = new File($absPath);

        $file->open('r');
        
        $result = $file->read();
        
        $file->close();

        $this->assertEqual($expected, $result);
    }

}

?>
