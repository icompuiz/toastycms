<?php

App::uses("User", "ToastyCore.Model");
class UserFixture extends CakeTestFixture {
    
    public $import = array('table' => 'users');
    public $records = array(
        array(
            'id' => 1, 
            'username' => 'user1', 
            'password' => 'a1fc568e8104d91580079594101035b92e3fcce1', 
            'email' => 'user1@email.com', 
            'status' => "ACTIVE",
            'group_id' => 1, 
            'created' => '2007-03-18 10:39:23', 
            'modified' => '2007-03-18 10:41:31'
        ),
        array(
            'id' => 2, 
            'username' => 'user2', 
            'password' => '2aa60a8ff7fcd473d321e0146afd9e26df395147', 
            'email' => 'user2@email.com', 
            'status' => "ACTIVE",
            'group_id' => 1, 
            'created' => '2010-03-18 10:39:23', 
            'modified' => '2010-03-18 10:41:31'
        )
    );
 }
?>
