<?php

class ContentFixture extends CakeTestFixture {
    
    public $import = array('table' => 'contents');
    public $records = array(
        array(
            'id' => 1,
            'name' => 'New Page',
            'user_id' => 1,
            'parent_content_id' => 0,
            'content_type_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            ),
        array( 
            'id' => 2,
            'name' => 'Magical New Page',
            'user_id' => 1,
            'parent_content_id' => 1,
            'content_type_id' => 2,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
            )
    );
}
?>
