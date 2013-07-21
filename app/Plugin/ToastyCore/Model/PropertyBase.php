<?php
App::uses('ToastyCoreAppModel', 'ToastyCore.Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class PropertyBase extends ToastyCoreAppModel {

    public function beforeSave($options = array()) {
        parent::beforeSave($options);



        $data = $this->data;

        $value = $data[$this->alias]['value'];

        if ($this->isFileValue($value)) {


            if (!$this->isEmptyValue($value)) {


                $name = "tp_" . $this->generateRandomString();
                $base = DS . strtolower($this->name);
            
                if (  isset($data[$this->alias]['previous_value'] ) ) {
                    
                
                    if(!$this->isEmptyValue($data[$this->alias]['previous_value'])) {
                        $name = $data[$this->alias]['previous_value'];

                        $file = new File($name);
                        $file->delete();

                        $name = preg_replace("/^(img|js|css|$base)\//", "", $name);
                        $name = preg_replace("/^($base)\//", "", $name);
                        $name = preg_replace("/\.\w+$/", "", $name); 
                    }

                }

                $file = array(
                    'name' => $name,
                    'file' => $value
                );
                
                $path = $this->uploadFile($file, $base, true);
                
                $data[$this->alias]['value'] = $path;

            } else {

                $data[$this->alias]['value'] = "";
                if (  isset($data[$this->alias]['previous_value'] ) ) {
                    $data[$this->alias]['value'] = $data[$this->alias]['previous_value'];
                }
                
            }          

        } 

        if (!$this->isEmptyValue($data[$this->alias]['value'])) {

            if (is_array($data[$this->alias]['value'])) {

                $data[$this->alias]['value'] = json_encode($data[$this->alias]['value']);

            }

            $this->data = $data;

            return true;
            
        }

        return false;
    }

    public function beforeDelete($cascade = true) {

        parent::beforeDelete($cascade);

        $current = $this->findById($this->id);

        // debug($current[$this->alias]['value']);

        $value = $current[$this->alias]['value'];

        $value = ltrim($value, DS);

        if (file_exists($value)) {

            $file = new File($value);
            $file->delete();

        }

        return true;


    }
}
?>