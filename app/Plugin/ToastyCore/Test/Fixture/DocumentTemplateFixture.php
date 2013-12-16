<?php

class DocumentTemplateFixture extends CakeTestFixture {
    
    public $useDbConfig = 'test';

    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'name' => array('type' => 'string', 'length' => 255),
        'system_path' => array('type' => 'string', 'length' => 255),
        'parent_id' => array('type' => 'integer'),
        'lft' => array('type' => 'integer'),
        'rght' => array('type' => 'integer'),
        'created' => array('type' => 'datetime'),
        'modified' => array('type' => 'datetime'),
    );

    public $records = array(
        array(
            'id' => 1,
            'name' => 'Template 1',
            'parent_id' => 0,
            'lft' => 1,
            'rght' => 10,
            'system_path' => 'template_1.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 2,
            'name' => 'Template 2',
            'parent_id' => 1,
            'lft' => 2,
            'rght' => 3,
            'system_path' => 'template_2.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 3,
            'name' => 'Template 3',
            'parent_id' => 1,
            'lft' => 4,
            'rght' => 9,
            'system_path' => 'template_3.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 4,
            'name' => 'Template 4',
            'parent_id' => 3,
            'lft' => 5,
            'rght' => 6,
            'system_path' => 'template_4.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 5,
            'name' => 'Template 5',
            'parent_id' => 3,
            'lft' => 7,
            'rght' => 8,
            'system_path' => 'template_5.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 6,
            'name' => 'Template 6',
            'parent_id' => null,
            'lft' => 11,
            'rght' => 12,
            'system_path' => 'template_6.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );
}
?>