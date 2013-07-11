<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');

class UserPropertySkel extends ToastyCoreAppModel {

    public $name = "UserPropertySkel";
    public $_schema = array(
        'id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'name' => array(
            'type' => 'string',
            'length' => 255
        ),
        'group_id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'input_format_id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'output_format_id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'created' => array(
            'type' => 'datetime'
        ),
        'modified' => array(
            'type' => 'datetime'
        )
    );

    public function addSkel($data = null) {

        if (!empty($data)) {

            $this->create($data);
            $this->save();

            return;
        }

        throw new Exception("index UserPropertySkel not defined");
    }

    public function getName($id = null) {
        $id = $this->checkId($id);

        $conditions = array(
            'UserPropertySkel.id' => $id
        );
        $skel = $this->find('first', array("conditions" => $conditions));

        $name = $skel['UserPropertySkel']['name'];

        return $name;
    }

    public function setName($name = null, $id = null) {

        $id = $this->checkId($id);

        if (!empty($name)) {

            $data['UserPropertySkel'] = array(
                'id' => $id,
                'name' => $name
            );

            $this->save($data);

            return;
        }

        throw new Exception("name must be provided");
    }

    public function getInputFormat($id = null) {
        $id = $this->checkId($id);

        $conditions = array(
            'UserPropertySkel.id' => $id
        );
        $skel = $this->find('first', array("conditions" => $conditions));

        $format = $skel['InputFormat'];

        return $format;
    }

    public function setInputFormat($format_id = null, $id = null) {
        $id = $this->checkId($id);

        if (!empty($format_id)) {

            $data['UserPropertySkel'] = array(
                'id' => $id,
                'input_format_id' => $format_id
            );

            $this->save($data);

            return;
        }

        throw new Exception("format_id must be provided");
    }

    public function getOutputFormat($id = null) {
        $id = $this->checkId($id);

        $conditions = array(
            'UserPropertySkel.id' => $id
        );
        $skel = $this->find('first', array("conditions" => $conditions));

        $format = $skel['OutputFormat'];

        return $format;
    }

    public function setOutputFormat($format_id = null, $id = null) {
        $id = $this->checkId($id);

        if (!empty($format_id)) {

            $data['UserPropertySkel'] = array(
                'id' => $id,
                'output_format_id' => $format_id
            );

            $this->save($data);

            return;
        }

        throw new Exception("format_id must be provided");
    }
    
    
    public function getGroup($id = null) {
        $id = $this->checkId($id);

        $conditions = array(
            'UserPropertySkel.id' => $id
        );
        $skel = $this->find('first', array("conditions" => $conditions));

        $format = $skel['Group'];

        return $format;
    }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        $userPropertyModel = ClassRegistry::init("ToastyCore.UserProperty");

        $up = $userPropertyModel->find('all', array('conditions' =>
            array('UserProperty.user_property_skel_id' => $this->id)
        ));

        foreach ($up as $p) {
            $userPropertyModel->id = $p['UserProperty']['id'];
            $userPropertyModel->delete();
        }

        return true;
    }


    public $belongsTo = array(
        'Group' => array(
            'className' => 'ToastyCore.Group'
        ),
        'InputFormat' => array(
            'className' => 'ToastyCore.OutputFormat',
            'foreignKey' => 'input_format_id'
        ),
        'OutputFormat' => array(
            'className' => 'ToastyCore.OutputFormat',
            'foreignKey' => 'output_format_id'
        )
    );

}

?>
