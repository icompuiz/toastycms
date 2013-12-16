<?php

class DocumentFixture extends CakeTestFixture {

	public $useDbConfig = 'test';
	public $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'name' => array('type' => 'string', 'length' => 255),
		'alias' => array('type' => 'string', 'length' => 255),
		'user_id' => array('type' => 'integer'),
		'parent_id' => array('type' => 'integer'),
		'lft' => array('type' => 'integer'),
		'rght' => array('type' => 'integer'),
		'document_type_id' => array('type' => 'integer'),
		'published' => array('type' => 'binary'),
		'home_page' => array('type' => 'binary'),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime'),
		'type' => array('type' => 'string', 'length' => 255, 'default' => 'normal')
	);

	public $records = array(
		 array(
            'id' => 1,
            'name' => 'Root Page',
			'alias' => 'root_page',
            'user_id' => 1,
			'parent_id' => null,
			'lft' => 1,
			'rght' => 14,
			'document_type_id' => 1,
			'published' => 0,
			'home_page' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23',
			'type'  => 'normal'
            ),
		  array(
            'id' => 2,
            'name' => 'Node 2',
			'alias' => 'node_2',
            'user_id' => 1,
			'parent_id' => 1,
			'lft' => 2,
			'rght' => 7,
			'document_type_id' => 2,
			'published' => 0,
			'home_page' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23',
			'type'  => 'normal'
            ),
		  array(
            'id' => 3,
            'name' => 'Node 3',
			'alias' => 'node_3',
            'user_id' => 1,
			'parent_id' => 1,
			'lft' => 8,
			'rght' => 13,
			'document_type_id' => 6,
			'published' => 0,
			'home_page' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23',
			'type'  => 'normal'
            ),
		  array(
            'id' => 4,
            'name' => 'Node 4',
			'alias' => 'node_4',
            'user_id' => 1,
			'parent_id' => 2,
			'lft' => 3,
			'rght' => 4,
			'document_type_id' => 3,
			'published' => 0,
			'home_page' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23',
			'type'  => 'normal'
            ),
		  array(
            'id' => 5,
            'name' => 'Node 5',
			'alias' => 'node_5',
            'user_id' => 1,
			'parent_id' => 2,
			'lft' =>5,
			'rght' => 6,
			'document_type_id' => null,
			'published' => 0,
			'home_page' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23',
			'type'  => 'normal'
            ),
		  array(
            'id' => 6,
            'name' => 'Node 6',
			'alias' => 'node_6',
            'user_id' => 1,
			'parent_id' => 3,
			'lft' => 9,
			'rght' => 10,
			'document_type_id' => null,
			'published' => 0,
			'home_page' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23',
			'type'  => 'normal'
            ),
		  array(
            'id' => 7,
            'name' => 'Node 7',
			'alias' => 'node_7',
            'user_id' => 1,
			'parent_id' => 3,
			'lft' => 11,
			'rght' => 12,
			'document_type_id' => null,
			'published' => 0,
			'home_page' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23',
			'type'  => 'normal'
            ),
		  array(
            'id' => 8,
            'name' => 'Root 2',
			'alias' => 'root_2',
            'user_id' => 1,
			'parent_id' => null,
			'lft' => 15,
			'rght' => 16,
			'document_type_id' => 1,
			'published' => 0,
			'home_page' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23',
			'type'  => 'normal'
            )
	);

}