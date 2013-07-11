<?php

App::uses("Group", "ToastyCore.Model");

class GroupTest extends CakeTestCase {

    public $fixtures = array(
        'plugin.ToastyCore.User', 
        'plugin.ToastyCore.Group', 
        'plugin.ToastyCore.UserPropertySkel', 
        'plugin.ToastyCore.UserProperty', 
        'plugin.ToastyCore.OutputFormat',
        'plugin.ToastyCore.Content',
        'plugin.ToastyCore.ContentTypePropertySkel',
        'plugin.ToastyCore.ContentTypeProperty',
        'plugin.ToastyCore.ContentType',
        'plugin.ToastyCore.ContentTemplate'
    );

    public function setUp() {

        parent::setUp();

        $this->Group = ClassRegistry::init("ToastyCore.Group");
    }

    public function testGetName() {

        $result = $this->Group->getName(1);
        $expected = "group1";

        $this->assertEqual($result, $expected);
    }

    public function testDeleteGroup() {

        $result = $this->Group->deleteGroup(1);
        $expected = true;

        $this->assertEqual($result, $expected);
    }

    public function testAddGroup() {

        $id = 3;
        $data['Group'] = array(
            'name' => 'group3',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        );

        $this->Group->addGroup($data);

        $result = $this->Group->read(null, $id);

        $expected = $data;
        $expected['Group']['id'] = $id;

        $this->assertEqual($result['Group'], $expected['Group']);
    }

    public function testGetUsers() {

        $expected = array(
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

        $result = $this->Group->getUsers(1);

        $this->assertEqual($result, $expected);
    }

    public function testSetName() {

        $expected = "group noblre";
        $this->Group->setName($expected, 1);

        $group = $this->Group->read(null, 1);

        $result = $group['Group']['name'];


        $this->assertEqual($result, $expected);
    }

}

?>
