<?php

class DocumentPropertyFixture extends CakeTestFixture {
    
    public $useDbConfig = 'test';

    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'document_type_property_id' => array('type' => 'integer'),
        'document_id' => array('type' => 'integer'),
        'value' => array('type' => 'text'),
        'created' => array('type' => 'datetime'),
        'modified' => array('type' => 'datetime'),
    );
    public $records = array(
        array(
            'id' => 1,
            'document_type_property_id' => 1,
            'document_id' => 6,
            'value' => 'This is a body',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 2,
            'document_type_property_id' => 2,
            'document_id' => 4,
            'value' => 'This is a valueee',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );
}
?>
