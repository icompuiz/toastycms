<?php

class OutputFormatFixture extends CakeTestFixture {
     
    public $import = array('table' => 'output_formats');
    public $records = array(
        array(
            'id' => 1,
            'name' => 'test_one_format',
            'system_path' => 'test_format.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 2,
            'name' => 'test_two_format',
            'system_path' => 'test_format2.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 3,
            'name' => 'input_image_format',
            'system_path' => 'test_format3.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 4,
            'name' => 'output_image_format',
            'system_path' => 'test_format4.php',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );
}
?>
