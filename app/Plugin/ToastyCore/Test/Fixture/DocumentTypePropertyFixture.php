<?php

class DocumentTypePropertyFixture extends CakeTestFixture {

	public $useDbConfig = 'test';
	public $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'name' => array('type' => 'string', 'length' => 255),
		'document_type_id' => array('type' => 'integer'),
		'input_format_id' => array('type' => 'integer'),
		'output_format_id' => array('type' => 'integer'),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime'),
	);
	public $records = array(
        array(
            'id' => 1,
            'name' => 'Property 1',
            'document_type_id' => 6,
            'input_format_id' => null,
            'output_format_id' => null,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 2,
            'name' => 'Property 2',
            'document_type_id' => 3,
            'input_format_id' => null,
            'output_format_id' => null,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 3,
            'name' => 'Property 3',
            'document_type_id' => 4,
            'input_format_id' => null,
            'output_format_id' => null,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 4,
            'name' => 'Property 4',
            'document_type_id' => 1,
            'input_format_id' => null,
            'output_format_id' => null,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );

}