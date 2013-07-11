<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');

class StaticfileBase extends ToastyCoreAppModel {

	public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
            ),
            'isunique' => array(
				'rule' => array('checkName', false),
                'message' => 'This file with this name already exists.',
				'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
			
			'isunique_edit' => array(
				'rule' => array('checkName', true),
                'message' => 'This file with this name already exists.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'update', // Limit validation to 'create' or 'update' operations
			)		
		),
        'content' => array(
            'rule' => array('file_check'),
            'message' => 'There are errors in the file'
        )
    );

	public function checkName($check, $edit = false) {

		$name = $check['name'];
		$type = $this->data[$this->alias]['type'];

		$name = trim($name);	
		$this->data[$this->alias]['name'] = $name;

		$same_name = false;
		$options = array('conditions' => array($this->alias . ".name" => $name));
		if ($edit) {
			$id = $this->data[$this->alias]['id'];

			$options = array('conditions' => 
				array(
					$this->alias . "." . $this->primaryKey . " != " => $id,
					$this->alias . ".name" => $name
				)
			);

		}


		$others = $this->find('first', $options);

		return empty($others);

	}

    private function getAbsolutePath($path_to_file) {

        $base_path = $this->staticPath;

        return $base_path . $path_to_file;
    }

    public function readFile($id = null) {

        $id = $this->checkId($id);

        $conditions = array($this->primaryKey => $id);
        $format = $this->find('first', array("conditions" => $conditions));
        $path_to_file = $format[$this->alias]['system_path'];
        $absPath = $this->getAbsolutePath($path_to_file);

        $contents = '';
        if (!empty($path_to_file)) {

            $contents = parent::readFile($absPath);
        }

        return $contents;
    }

    public function file_check($contents) {

        $data = $this->data;

        $name = $this->generateRandomString();
        $path = App::pluginPath('ToastyCore') . "tmp_files" . DS;

        if (!is_dir($path)) {
            mkdir($path);
        }

        $full_name = $path . $name;

        $file = new File($full_name);

        $file->create();

        $file->open('w');

        $file->write($contents['content']);

        $file->close();

        $this->data[$this->alias]['system_path'] = $full_name;
        return true;
    }


	public function beforeSave($options = array()) {

        parent::beforeSave($options);

        $data = $this->data;

        $path = App::pluginPath('ToastyCore') . "tmp_files" . DS;
        $path = str_replace("/", "\/", $path);



        $tmp_exists = preg_match("~$path~", $data[$this->alias]['system_path']);

        if ($tmp_exists) {

            $file = new File($data[$this->alias]['system_path']);
            $file->open();
            // debug($file->read()); exit;

            
            $path = $this->staticPath;



            if (!is_dir($path)) {
                mkdir($path);
            }


            $name = $data[$this->alias]['name'];
            $name = preg_replace("/\W/", "", $name);
            $name = Inflector::underscore($name);	

            $name .= $this->staticExtension;


            $old = isset($data[$this->alias]['previous_path']);
            if ($old) {
                $old = $data[$this->alias]['previous_path'];
                if ($old != $name) {
                    $old_file = new File($path . $old);
                    $old_file->delete();
                }
            }

            $dest = $path . $name;


            $file->copy($dest);

            $file->delete();
            $this->data[$this->alias]['system_path'] = $name;
        }

        return true;
    }

    public function getPath($id = null) {

        $id = $this->checkId($id);

        $staticFile = $this->findById( $id);

        $path = $staticFile[$this->alias]['system_path'];

        return $path;
    }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        $path = $this->staticPath;

        $path .= $this->getPath($this->id);

        
        $file = new File($path);
        
        if ($file->exists()) {
            $file->delete();
        }
        
        return true;
    }

}