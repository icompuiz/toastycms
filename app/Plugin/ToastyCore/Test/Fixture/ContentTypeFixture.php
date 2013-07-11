<?php

class ContentTypeFixture extends CakeTestFixture {
    
    public $import = array('table' => 'content_types');
    public $records = array(
        array(
            'id' => 1,
            'name' => 'Web Page Standard',
            'content_template_id' => 1,
            'parent_content_type_id' => 0,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
        ,
        array(
            'id' => 2,
            'name' => 'Magic Page',
            'content_template_id' => 2,
            'parent_content_type_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
        ,
        array(
            'id' => 3,
            'name' => 'dfdgfkjkjngdfjknfgnjkfgnjkfgjfkg',
            'content_template_id' => 3,
            'parent_content_type_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
        ,
        array(
            'id' => 4,
            'name' => 'dfkjfdkjndfkfdkfdikfdikfdfdmkjl',
            'content_template_id' => 0,
            'parent_content_type_id' => 0,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
        ,
        array(
            'id' => 5,
            'name' => 'klfsdlkmfdlkmdfklmdfklmdfklmfdklmfdldkf',
            'content_template_id' => 0,
            'parent_content_type_id' => 4,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );
}
?>