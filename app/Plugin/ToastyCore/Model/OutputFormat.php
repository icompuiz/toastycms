<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');

class OutputFormat extends ToastyCoreAppModel {

    public $name = 'OutputFormat';
    
    public $_schema = array(
        
        'id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'name' => array(
            'type' => 'string',
            'length' => 255
        ),
        'system_path' => array(
            'type' => 'text',
        ),
        'created' => array(
            'type' => 'datetime'
        ),
        'modified' => array(
            'type' => 'datetime'
        )
    );
    
    public $validate = array(
        
        'name' => array('notEmpty', 'isUnique'),
        'system_path' => array('notEmpty')
        
    );

    public function addOutputFormat($data = null) {
        
        if($data) {
            
            $this->create($data);
            $this->save();
            
            return;
            
        }
        
        throw new Exception("name must be provided");

        
    }
    
    public function getName($id = null) {

        $id = $this->checkId($id);

        $conditions = array('OutputFormat.id' => $id);
        $format = $this->find('first', array("conditions" => $conditions));



        $name = $format['OutputFormat']['name'];

        return $name;
    }

    public function setName($name = null, $id = null) {

        $id = $this->checkId($id);

        if ($name) {

            $data['OutputFormat'] = array(
                'id' => $id,
                'name' => $name
            );

            $this->save($data);
            
            return;
        }

        throw new Exception("name must be provided");
    }

    public function getPath($id = null) {

        $id = $this->checkId($id);

        $conditions = array('OutputFormat.id' => $id);
        $format = $this->find('first', array("conditions" => $conditions));



        $path = $format['OutputFormat']['system_path'];

        return $path;
    }

    public function setPath($system_path = null, $id = null) {

        $id = $this->checkId($id);

        if ($system_path) {

            $data['OutputFormat'] = array(
                'id' => $id,
                'system_path' => $system_path
            );

            $this->save($data);
            
            return;
        }

        throw new Exception("system_path must be provided");
    }

    public function readFile($id = null) {
                
        $id = $this->checkId($id);

        $conditions = array('OutputFormat.id' => $id);
        $format = $this->find('first', array("conditions" => $conditions));
        $path_to_file = $format['OutputFormat']['system_path'];
        $absPath = $this->getAbsolutePath($path_to_file);

        $contents = parent::readFile($absPath);

        return $contents;
    }

    public function writeFile($contents = null, $id = null, $create = true) {
    
        
        $id = $this->checkId($id);

        if ($contents) {

            $conditions = array('OutputFormat.id' => $id);
            $format = $this->find('first', array("conditions" => $conditions));
            $path_to_file = $format['OutputFormat']['system_path'];
            
            $absPath = $this->getAbsolutePath($path_to_file);

            parent::writeFile($contents, $absPath);

            return;
        }

        throw new Exception("contents must be provided");
    }
    
    private function getAbsolutePath($path_to_file) {
        $paths = App::path('View', 'ToastyCore') ;
        $base_path = $paths[0].  'Elements' . DS . 'Formats'. DS;
        
        return $base_path . $path_to_file;
    }
    
    public function fileExists($id = null) {
        
        $id = $this->check($id);
         
        $conditions = array('OutputFormat.id' => $id);
        $format = $this->find('first', array("conditions" => $conditions));
        $path_to_file = $format['OutputFormat']['system_path'];
        
        $absPath = $this->getAbsolutePath($path_to_file);
                
        $file_exists = parent::fileExists($absPath);
        
        return $file_exists;
        
        
    }

}

?>