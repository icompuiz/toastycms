<?php

class ContentTypePropertySkelFixture extends CakeTestFixture {
    
    public $import = array('table' => 'content_type_property_skels');
    public $records = array(
        array(
            'id' => 1,
            'name' => 'body',
            'content_type_id' => 1,
            'input_format_id' => 1,
            'output_format_id' => 2,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 2,
            'name' => 'new_property',
            'content_type_id' => 2,
            'input_format_id' => 3,
            'output_format_id' => 4,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );
}
?>