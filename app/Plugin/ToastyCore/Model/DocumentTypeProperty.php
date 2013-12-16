<?php
App::uses('ToastyCoreAppModel', 'ToastyCore.Model');

class DocumentTypeProperty extends ToastyCoreAppModel {
    
    public $name = "DocumentTypeProperty";

    
    public function addSkel($data = null) {

        if (!empty($data)) {

            $this->create($data);
            $this->save();

            return;
        }

        throw new Exception("index DocumentTypeProperty not defined");
    }

    public function getName($id = null) {
        $id = $this->checkId($id);

        $conditions = array(
            'DocumentTypeProperty.id' => $id
        );
        $skel = $this->find('first', array("conditions" => $conditions));

        $name = $skel['DocumentTypeProperty']['name'];

        return $name;
    }

    public function setName($name = null, $id = null) {

        $id = $this->checkId($id);

        if (!empty($name)) {

            $data['DocumentTypeProperty'] = array(
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
            'DocumentTypeProperty.id' => $id
        );
        $skel = $this->find('first', array("conditions" => $conditions));

        $format = $skel['InputFormat'];

        return $format;
    }

    public function setInputFormat($format_id = null, $id = null) {
        $id = $this->checkId($id);

        if (!empty($format_id)) {

            $data['DocumentTypeProperty'] = array(
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
            'DocumentTypeProperty.id' => $id
        );
        $skel = $this->find('first', array("conditions" => $conditions));

        $format = $skel['OutputFormat'];

        return $format;
    }

    public function setOutputFormat($format_id = null, $id = null) {
        $id = $this->checkId($id);

        if (!empty($format_id)) {

            $data['DocumentTypeProperty'] = array(
                'id' => $id,
                'output_format_id' => $format_id
            );

            $this->save($data);

            return;
        }

        throw new Exception("format_id must be provided");
    }
    
    
    public function getDocumentType($id = null) {
        $id = $this->checkId($id);

        $conditions = array(
            'DocumentTypeProperty.id' => $id
        );
        $skel = $this->find('first', array("conditions" => $conditions));

        $format = $skel['DocumentType'];

        return $format;
    }
    
    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        $propertyModel = ClassRegistry::init("ToastyCore.DocumentProperty");

        $all = $propertyModel->find('all', array('conditions' =>
            array('DocumentProperty.document_type_property_id' => $this->id)
        ));

        foreach ($all as $one) {
            $propertyModel->id = $one['DocumentProperty']['id'];
            $propertyModel->delete();
        }

        return true;
    }
    
    
    public $belongsTo = array(
        // 'InputFormat' => array(
        //     'className' => 'ToastyCore.OutputFormat',
        //     'foreignKey' => 'input_format_id'
        // ),
        // 'OutputFormat' => array(
        //     'className' => 'ToastyCore.OutputFormat',
        //     'foreignKey' => 'output_format_id'
        // ),
        'DocumentType' => array(
            'className' => 'ToastyCore.DocumentType'
            
        )
    );
    
    
}
?>
