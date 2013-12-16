<?php
class UserPropertyFixture extends CakeTestFixture {
    
    public $import = array('table' => 'user_properties');
    public $records = array(
        array(
            'id' => 1,
            'value' => 'Isioma',
            'user_id' => 1,
            'user_property_skel_id' => 1,
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:39:23'
        )
    );
}
?>
