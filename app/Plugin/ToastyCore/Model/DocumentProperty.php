<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');
App::uses('PropertyBase', 'ToastyCore.Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');


class DocumentProperty extends PropertyBase {

    public $name = 'DocumentProperty';

    public function addDocumentProperty($data = null) {


        if (!empty($data['DocumentProperty'])) {

            $this->create($data);
            $this->save();

            return;
        }

        throw new Exception("index DocumentProperty must be defined");
    }

    public function setValue($value = null, $id = null) {

        $id = $this->checkId($id);

        if (!empty($value)) {

            $data['DocumentProperty'] = array(
                'id' => $id,
                'value' => $value
            );

            $this->save($data);
        }

        return;
    }

    public function getValue($id = null) {

        $id = $this->checkId($id);

        $conditions = array('DocumentProperty.id' => $id);
        $property = $this->find('first', array("conditions" => $conditions));
        $value = json_decode($property['DocumentProperty']['value'], true);
        
        if ($this->isEmptyValue($value)) {
            $value = $property['DocumentProperty']['value'];
        }
        
        return $value;
    }

    public function getDocument($id = null) {
        $id = $this->checkId($id);

        $conditions = array('DocumentProperty.id' => $id);
        $property = $this->find('first', array("conditions" => $conditions));

        $user = $property['Document'];

        return $user;
    }

    public $belongsTo = array(
        'Document' => array(
            'className' => 'ToastyCore.Document'
        ),
        'DocumentTypeProperty' => array(
            'className' => 'ToastyCore.DocumentTypeProperty'
        )
    );





}

?>
