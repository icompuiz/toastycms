<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class OutputFormatTest extends CakeTestCase {

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
        $this->OutputFormat = ClassRegistry::init("ToastyCore.OutputFormat");
        
        $paths = App::path('View', 'ToastyCore') ;
        $base_path = $paths[0].  'Elements' . DS . 'Formats'. DS . 'test_format.ctp';
        
        $file = new File($base_path);
        
        $file->create();
        $file->open('w');
        $file->write($this->test_contents);
        $file->close();
        
    }
    
    public function tearDown() {
        parent::tearDown();
        
        $paths = App::path('View', 'ToastyCore') ;
        $base_path = $paths[0].  'Elements' . DS . 'Formats'. DS;
        
        $folder = new Folder($base_path);
        
        $files = $folder->read();
        
        foreach ( $files[1] as $item) {
            
            if (preg_match('/^test_/', $item)) {
                $file = new File($folder->path . $item);
                $file->delete();
            }
        }
        
    }
    
    public function testAddOutputFormat() {
        
        $next_id = 5;
        
        $data['OutputFormat'] = array(
            'name' => 'new_format_template',
            'system_path' => 'test_formatx.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        );
        
        $this->OutputFormat->addOutputFormat($data);
        
        $expected = $data;
        $expected['OutputFormat']['id'] = $next_id;
        
        $format = $this->OutputFormat->read(null, $next_id);
        $result = $format;
        
        $this->assertEqual($result, $expected);
        
        
        
    }

    public function testGetName() {
        
        $id = 1;
        $result = $this->OutputFormat->getName($id);
        $expected = "test_one_format";

        $this->assertEqual($expected, $result);
    }

    public function testSetName() {
        
        $id = 1;
        
        $expected = "new_name";
        $this->OutputFormat->setName($expected, $id);
        
        $format = $this->OutputFormat->read(null, $id);
        $result = $format['OutputFormat']['name'];

        $this->assertEqual($expected, $result);
    }

    public function testGetPath() {

        $id = 1;
        $expected = "test_format.ctp";
        $result =$this->OutputFormat->getPath($id);

        $this->assertEqual($expected, $result);
    }

    public function testSetPath() {

        $id = 1;
        
        $expected = "test_formaty.ctp";
        $this->OutputFormat->setPath($expected, $id);
        
        $format = $this->OutputFormat->read(null, $id);
        $result = $format['OutputFormat']['system_path'];

        $this->assertEqual($expected, $result);
    }

    public function testReadFile() {

        $id = 1;
        
        $result = $this->OutputFormat->readFile($id);
        
        $expected = $this->test_contents;
        
        $this->assertEqual($expected, $result);
    }

    public function testWriteFile() {
        $id = 1;
        
        $expected = $this->test_contents_2;
        
        $this->OutputFormat->writeFile($expected, $id);
        
        
        $paths = App::path('View', 'ToastyCore') ;
        $base_path = $paths[0].  'Elements' . DS . 'Formats'. DS;
        
        $absPath = $base_path . 'test_format.ctp';
        
        $file = new File($absPath);

        $file->open('r');
        
        $result = $file->read();
        
        $file->close();

        $this->assertEqual($expected, $result);
    }

}

?>
