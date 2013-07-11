<?php
class UserPropertySkelFixture extends CakeTestFixture {
    
    public $import = array('table' => 'user_property_skels');
    public $records = array(
        array(
            'id' => 1,
            'name' => 'first_name',
            'group_id' => 1,
            'input_format_id' => 1,
            'output_format_id' => 2,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        ),
        array(
            'id' => 2,
            'name' => 'last_name',
            'group_id' => 1,
            'input_format_id' => 3,
            'output_format_id' => 4,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );
}
?>
