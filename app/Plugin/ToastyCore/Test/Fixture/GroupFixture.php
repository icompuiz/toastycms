<?php

class GroupFixture extends CakeTestFixture {
    
    public $import = array('table' => 'groups');
    public $records = array(
        array(
            'id' => 1, 
            'name' => 'group1',  
            'created' => '2007-03-18 10:39:23', 
            'modified' => '2007-03-18 10:41:31'
        ),
        array(
            'id' => 2, 
            'name' => 'group2',  
            'created' => '2007-03-18 10:39:23', 
            'modified' => '2007-03-18 10:41:31'
        )
    );
 }
?>
