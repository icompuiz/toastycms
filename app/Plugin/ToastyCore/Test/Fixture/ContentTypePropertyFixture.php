<?php

class ContentTypePropertyFixture extends CakeTestFixture {
    
    public $import = array('table' => 'content_type_properties');
    public $records = array(
        array(
            'id' => 1,
            'content_type_property_skel_id' => 1,
            'content_id' => 1,
            'value' => 'This is a body',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 2,
            'content_type_property_skel_id' => 2,
            'content_id' => 1,
            'value' => 'This is a valueee',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );
}
?>
