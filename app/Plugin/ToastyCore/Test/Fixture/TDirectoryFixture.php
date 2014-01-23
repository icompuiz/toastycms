<?php

class TDirectoryFixture extends CakeTestFixture {

	public $useDbConfig = 'test';
	public $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'name' => array('type' => 'string', 'length' => 255),
		'parent_id' => array('type' => 'integer'),
		'lft' => array('type' => 'integer'),
		'rght' => array('type' => 'integer'),
		'created' => array('type' => 'datetime'),
		'modified' => array('type' => 'datetime')
	);

	public $records = array(
		 array(
            'id' => 1,
            'name' => 'Root Directory',
			'parent_id' => null,
			'lft' => 1,
			'rght' => 14,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            ),
		  array(
            'id' => 2,
            'name' => 'Node 2',
			'parent_id' => 1,
			'lft' => 2,
			'rght' => 7,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            ),
		  array(
            'id' => 3,
            'name' => 'Node 3',
			'parent_id' => 1,
			'lft' => 8,
			'rght' => 13,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            ),
		  array(
            'id' => 4,
            'name' => 'Node 4',
			'parent_id' => 2,
			'lft' => 3,
			'rght' => 4,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            ),
		  array(
            'id' => 5,
            'name' => 'Node 5',
			'parent_id' => 2,
			'lft' =>5,
			'rght' => 6,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            ),
		  array(
            'id' => 6,
            'name' => 'Node 6',
			'parent_id' => 3,
			'lft' => 9,
			'rght' => 10,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            ),
		  array(
            'id' => 7,
            'name' => 'Node 7',
			'parent_id' => 3,
			'lft' => 11,
			'rght' => 12,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            ),
		  array(
            'id' => 8,
            'name' => 'Root 2',
			'parent_id' => null,
			'lft' => 15,
			'rght' => 16,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            )
	);

}