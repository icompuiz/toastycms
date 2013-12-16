<?php

class DocumentTypeFixture extends CakeTestFixture {

	public $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'name' => array('type' => 'string', 'length' => 255),
		'document_template_id' => array('type' => 'integer'),
		'parent_id' => array('type' => 'integer'),
		'lft' => array('type' => 'integer'),
		'rght' => array('type' => 'integer'),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime'),
	);
	public $records = array(
        array(
            'id' => 1,
            'name' => 'Root Document Type 1',
            'document_template_id' => null,
            'parent_id' => null,
            'lft' => 1,
            'rght' => 10,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
        ,
        array(
            'id' => 2,
            'name' => 'Document Type 2',
            'document_template_id' => null,
            'parent_id' => 1,
            'lft' => 2,
            'rght' => 5,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
        ,
        array(
            'id' => 3,
            'name' => 'Document Type 3',
            'document_template_id' => null,
            'parent_id' => 1,
            'lft' => 6,
            'rght' => 9,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
        ,
        array(
            'id' => 4,
            'name' => 'Document Type 4',
            'document_template_id' => null,
            'parent_id' => 2,
            'lft' => 3,
            'rght' => 4,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
        ,
        array(
            'id' => 5,
            'name' => 'Document Type 5',
            'document_template_id' => null,
            'parent_id' => 3,
            'lft' => 7,
            'rght' => 8,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 6,
            'name' => 'Root Document Type 2',
            'document_template_id' => null,
            'parent_id' => null,
            'lft' => 11,
            'rght' => 12,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );


}

?>