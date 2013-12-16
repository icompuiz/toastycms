<?php

class ContentTemplateFixture extends CakeTestFixture {
    
    public $import = array('table' => 'content_templates');
    public $records = array(
        array(
            'id' => 1,
            'parent_content_template_id' => 0,
            'name' => 'Web Page Standard Template',
            'system_path' => 'test_template1.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 2,
            'parent_content_template_id' => 1,
            'name' => 'Magic Page Template',
            'system_path' => 'test_template2.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 3,
            'parent_content_template_id' => 1,
            'name' => 'Magic Page Template 2',
            'system_path' => 'test_template3.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 4,
            'parent_content_template_id' => 3,
            'name' => 'fgngfndfnhfnnhdnhhd',
            'system_path' => 'test_template4.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 5,
            'parent_content_template_id' => 3,
            'name' => 'hghjgm,jhhgsgsgfbsgfbgfb',
            'system_path' => 'test_template5.ctp',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );
}
?>