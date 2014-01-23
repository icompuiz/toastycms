<?php

class TFileFixture extends CakeTestFixture {
    
    public $useDbConfig = 'test';

    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'name' => array('type' => 'string', 'length' => 255),
        't_directory_id' => array('type' => 'integer'),
        'created' => array('type' => 'datetime'),
        'modified' => array('type' => 'datetime'),
    );
    public $records = array(
        array(
            'id' => 1,
            'name' => 'FileOne.jpg',
            't_directory_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 2,
            'name' => 'FileThree.doc',
            't_directory_id' => 3,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 3,
            'name' => 'FileFive.css',
            't_directory_id' => 5,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );
}
?>
