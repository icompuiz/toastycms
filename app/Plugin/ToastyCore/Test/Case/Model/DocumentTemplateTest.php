<?php
class DocumentTemplateTest extends CakeTestCase {

    public $fixtures = array(
        'plugin.ToastyCore.DocumentTemplate',
    );

    public function setUp() {
        parent::setUp();
        
        $this->Model = ClassRegistry::init("ToastyCore.DocumentTemplate");
    }

     public function testGetTemplateStack() {

		// $this->Model->id = 2;
		$stack = $this->Model->getTemplateStack(5);
		
		$result = $stack[0]['DocumentTemplate']['name'];
		$expected = 'Template 1';
		$this->assertEqual($result, $expected);

		$result = $stack[1]['DocumentTemplate']['name'];
		$expected = 'Template 3';
		$this->assertEqual($result, $expected);

		$result = $stack[2]['DocumentTemplate']['name'];
		$expected = 'Template 5';
		$this->assertEqual($result, $expected);

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

		$data = array( 'Document' => array('parent_id' => $parent_id));

		$result = $this->Model->isDescendant($data);

		$expected = false;


		$this->assertEqual($result, $expected);

    }

    public function testWriteRootTemplate() {

    	// Heredoc syntax
    	$this->Model->id = 1;
    	$this->Model->read();

    	$expected = <<<EOT
<?php

	echo "Hello world";

?>
EOT;
	
		$full_name = $this->Model->writeTemplate($expected);

        $file = new File($full_name);
		$file->open('r');
		$result = $file->read();



		$this->assertEqual($result, $expected);

		$file->delete();

    }

    public function testPHPValid() {

    	// Heredoc syntax
    	$this->Model->id = 1;
    	$this->Model->read();

    	$content = <<<EOT
<?php

	echo "Hello world";

?>
EOT;

		$full_name = $this->Model->writeTemplate($content);
		
	
		$result = $this->Model->validateTemplate($full_name);

		$result = is_string($result);

		$expected = false;

		unlink($full_name);

		$this->assertEqual($result, $expected);


    }


    public function testPHPInvalid() {

    	// Heredoc syntax
    	$this->Model->id = 1;
    	$this->Model->read();

    	$content = <<<EOT
<?php

	echo "Hello world

?>
EOT;

		$full_name = $this->Model->writeTemplate($content);
		
	
		$result = $this->Model->validateTemplate($full_name);

		$result = is_string($result);

		$expected = true;

		unlink($full_name);

		$this->assertEqual($result, $expected);


    }

    public function testMoveToFinalDestination() {



    	$this->Model->id = 1;
    	$this->Model->read();

    	$expected = <<<EOT
<?php

	echo "Hello world";

?>
EOT;

		$full_name = $this->Model->writeTemplate($expected);
		$valid = $this->Model->validateTemplate($full_name);

		if ($valid) {
			$result = $this->Model->moveToFinalDestination();
		}

	 	$paths = App::path('View');
        $finalPath = array_shift($paths) . Inflector::pluralize($this->Model->alias) . DS;

        $name = $this->Model->data[$this->Model->alias]['system_path'];

        $destFile = $finalPath . $name;

        $file = new File($destFile);
        $file->open('r');
		$result = $file->read();

		$this->assertEqual($result, $expected);

		$file->delete();
    }

    public function testWriteL1DescendantTemplate() {

    	$this->Model->id = 5;

    	$content = <<<EOT
<?php

	echo "Hello world";

?>
EOT;
	
		$full_name = $this->Model->writeTemplate($content);

        $file = new File($full_name);
		$file->open('r');
		$result = $file->read();

		$expected = '<?php $this->extend(\'template_3\');?>' . "\r\n".$content;


		$this->assertEqual($result, $expected);

		$file->delete();

    }

}

?>