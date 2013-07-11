<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');
App::uses('PropertyBase', 'ToastyCore.Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');


class ContentTypeProperty extends PropertyBase {

    public $name = 'ContentTypeProperty';
    public $_schema = array(
        'id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'content_type_property_id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'content_type_property_skel' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'value' => array(
            'type' => 'text'
        ),
        'content_id' => array(
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

    public function addContentTypeProperty($data = null) {


        if (!empty($data['ContentTypeProperty'])) {

            $this->create($data);
            $this->save();

            return;
        }

        throw new Exception("index ContentTypeProperty must be defined");
    }

    public function setValue($value = null, $id = null) {

        $id = $this->checkId($id);

        if (!empty($value)) {

            $data['ContentTypeProperty'] = array(
                'id' => $id,
                'value' => $value
            );

            $this->save($data);
        }

        return;
    }

    public function getValue($id = null) {

        $id = $this->checkId($id);

        $conditions = array('ContentTypeProperty.id' => $id);
        $property = $this->find('first', array("conditions" => $conditions));

        $value = json_decode($property['ContentTypeProperty']['value'], true);

        return $value;
    }

    public function getContent($id = null) {
        $id = $this->checkId($id);

        $conditions = array('ContentTypeProperty.id' => $id);
        $property = $this->find('first', array("conditions" => $conditions));

        $user = $property['Content'];

        return $user;
    }

    public $belongsTo = array(
        'Content' => array(
            'className' => 'ToastyCore.Content'
        ),
        'ContentTypePropertySkel' => array(
            'className' => 'ToastyCore.ContentTypePropertySkel'
        )
    );





}

?>
