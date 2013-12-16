<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');

class DocumentTemplate extends ToastyCoreAppModel {

    public $name = 'DocumentTemplate';
    public $actsAs = array('Tree');

    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This template with this name already exists.'
            )
        ),
        'content' => array(
            'rule' => array('validateTemplate'),
            'message' => 'There are PHP errors in the template'
        ),
        'parent_id' => array(
            'rule' => array('checkDescendant'),
            'message' => 'You cannot set a child to be a parent'
        )
    );

    public function addTemplate($data = null) {
        if ($data) {
            $this->create($data);
            $this->save();
        }
    }

    public function deleteTemplate($id = null) {

        $id = $this->checkId($id);

        $this->delete($id);
    }

    public function getChildTemplates($id = null) {

        $id = $this->checkId($id);

        $children = $this->children($id);

        return $children;
    }

    public function setParentTemplate($template_id = null, $id = null) {
        $id = $this->checkId($id);

        if ($template_id) {

            $data = array(
                'DocumentTemplate' => array(
                    'id' => $id,
                    'parent_id' => $template_id
                )
            );

            $this->save($data);

            return;
        }

        throw new Exception("template_id parameter must be provided");
    }

    public function getParentTemplate($id = null) {

        $id = $this->checkId($id);

        $parent = $this->getParentNode($id);

        return $parent;
    }

    public function getName($id = null) {
        $id = $this->checkId($id);

        $template = $this->read(null, $id);

        $name = $template['DocumentTemplate']['name'];

        return $name;
    }

    public function setName($newName = null, $id = null) {

        $id = $this->checkId($id);

        if ($newName) {

            $data = array(
                'DocumentTemplate' => array(
                    'id' => $id,
                    'name' => $newName
                )
            );

            $this->save($data);

            return;
        }

        throw new Exception("newName parameter must be provided");
    }

    public function getSystemPath($id = null) {

        $id = $this->checkId($id);

        $template = $this->read(null, $id);

        $path = $template['DocumentTemplate']['system_path'];

        return $path;
    }

    public function setPath($newPath = null, $id = null) {

        $id = $this->checkId($id);

        if ($newPath) {

            $data = array(
                'DocumentTemplate' => array(
                    'id' => $id,
                    'system_path' => $newPath
                )
            );

            $this->save($data);

            return;
        }

        throw new Exception("newPath parameter must be provided");
    }

    public function readFile($id = null) {

        $id = $this->checkId($id);

        $conditions = array('DocumentTemplate.id' => $id);
        $format = $this->find('first', array("conditions" => $conditions));
        $path_to_file = $format['DocumentTemplate']['system_path'];
        $absPath = $this->getAbsolutePath($path_to_file);

        if (!empty($path_to_file)) {

            $contents = parent::readFile($absPath);
        } else {
            $contents = '';
        }

        return $contents;
    }

    public function writeFile($contents = null, $id = null, $create = true) {

        $id = $this->checkId($id);

        if ($contents) {

            $conditions = array('DocumentTemplate.id' => $id);
            $format = $this->find('first', array("conditions" => $conditions));
            $path_to_file = $format['DocumentTemplate']['system_path'];

            $absPath = $this->getAbsolutePath($path_to_file);

            parent::writeFile($contents, $absPath, $create);

            return;
        }

        throw new Exception("contents must be provided");
    }

    private function getAbsolutePath($path_to_file) {

        $paths = App::path('View');
        $path = array_shift($paths);
        $base_path = $path . Inflector::pluralize($this->alias) . DS;

        return $base_path . $path_to_file;

    }

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);
        
        $childCount = $this->childCount();

        if ($childCount > 0) { // cancel if it has children
            return false;
        }

        // Delete the template file as well
        $path = array_shift(App::path('View')) . Inflector::pluralize($this->alias) . DS;
        $path .= $this->getSystemPath($this->id);

        $file = new File($path);
        
        if ($file->exists()) {
            $file->delete();
        }
        
        return true;
    }

    public function beforeSave($options = array()) {

        parent::beforeSave($options);

        return $this->moveToFinalDestination();

        
    }

    public function moveToFinalDestination($data = null) {

        if ($this->isEmptyValue($data)) {
            if ($this->isEmptyValue($this->data)) {
                return false;
            } else {
                $data = $this->data;
            }
        }

        $path = TMP . 'toasty' . DS;
        $path = str_replace("/", "\/", $path);

        $tmp_exists = preg_match("~$path~", $data[$this->alias]['system_path']);

        if ($tmp_exists) {

            $tmpFile = new File($data[$this->alias]['system_path']);
            $tmpFile->open();

            $paths = App::path('View');
            $finalPath = array_shift($paths) . Inflector::pluralize($this->alias) . DS;

            if (!is_dir($finalPath)) {
                mkdir($finalPath);
            }

            $id = $data[$this->alias]['id'];

            $name = $data[$this->alias]['name'];
            $name = preg_replace("~\W~", "", $name);
            $name = Inflector::underscore($name);

            $name .= ".ctp";

            $old = isset($data[$this->alias]['original_path']);
            if ($old) {
                $old = $data[$this->alias]['original_path'];
                if ($old != $name) {
                    $old_file = new File($finalPath . $old);
                    $old_file->delete();
                }
            }

            $fullDestinationPath = $finalPath . $name;

            $tmpFile->copy($fullDestinationPath);

            $tmpFile->delete();

            $this->data[$this->alias]['system_path'] = $name;
        
            return true;
        }

        return false;



    }

    public function writeTemplate($content, $tmp_name = null) {


        $data = $this->data;

        $id = isset($data['DocumentTemplate']['id']) ? $data['DocumentTemplate']['id'] : $this->id;

        $parentTemplate = $this->getParentNode($id);

        $parentPath = false;
        if (!empty($parentTemplate)) {

            $hasParent = $parentTemplate['DocumentTemplate']['id'] !== null;

            if ($hasParent) {
                $parentPath = $parentTemplate['DocumentTemplate']['system_path'];
                $parentPath = str_replace('.ctp', '', $parentPath);

                // $parentPath = "$parentPath"; // Note: don't need this - 12/15/2013
            }

        }
        $name = '';
        if ($this->isEmptyValue($tmp_name)) {
            $name = $this->generateRandomString();
            
        } else {
            $name = $tmp_name;
        }

        $path = TMP . 'toasty' . DS;


        if (!is_dir($path)) {
            mkdir($path);
        }

        $full_name = $path . $name;

        $file = new File($full_name);

        $file->create();

        $file->open('w');

        if ($parentPath) {

            $extendStatement = '<?php $this->extend(\'' . $parentPath . '\');?>' . "\r\n";
            $content = preg_replace('~<\?(php)?\s*\$this->extend\(\'.*\'\);\s*\?>(\r\n)+~', "", $content);
            $content = $extendStatement . $content;

        }

        $file->write($content);

        $file->close();


        return $full_name;
    }

    public function validateTemplate($data) {

        $full_name = '';
        if (is_array($data)) {
            $full_name = $this->writeTemplate($data['content']);
        } else {
            $full_name = $data;
        }

        if ($this->isEmptyValue($full_name)) {
            return false;
        }

        $command = "php -l " . $full_name;

        $output_lines = array();
        $status = array();

        $output = exec("php -l $full_name  2>&1", $output_lines, $status);

        if (0 === $status) {
            $this->data['DocumentTemplate']['system_path'] = $full_name;
            return true;
        }

        $error_str = $output_lines[0];
        $error_str = str_replace("in $full_name", "", $error_str);

        return $error_str;
    }

    public function checkDescendant($options) {

        $parent_id = isset($options['parent_id']) ? $options['parent_id'] : null;

        if (empty($parent_id)) {
            return true;
        }

        $search_id = $this->data[$this->name]['id'];

        $options = array(
            'parent_id' => $parent_id,
            'search_id' => $search_id
        );


        return $this->isDescendant($options);
    }

    public function isDescendant($options) {
            

        $id = isset($options['parent_id']) ? $options['parent_id'] : null;
        $search_id = isset($options['search_id']) ? $options['search_id'] : null;
        $conditions = array(
            $this->name . '.id' => $id
        );

        $children = $this->children($id, false, 'id');

        foreach ($children as $child) {
            if ($search_id == $child[$this->name]['id']) {
                return true;
                break;
            }
        }

        return false;
    }


    public function getStack($model_id = null, $mapping_function = null) {

        if ($this->isEmptyValue($model_id)) {
            return null;
        }

        if (!is_callable($mapping_function)) {
            $mapping_function = function($model) {
                return $model;
            };
        }

        $model_id = $this->checkId($model_id);

        $templates = array();

        $currentDocument = $this->findById($model_id);
        $templates[] = $mapping_function($currentDocument);

        $parentNode = $this->getParentNode($model_id);
        while (!empty($parentNode))  {


            $templates[] = $mapping_function($parentNode);
        
            $model_id = $parentNode[$this->name]['id'];
            $parentNode = $this->getParentNode($model_id);

        }
        
        $templates = array_reverse($templates);


        return $templates;
    }

    public function getTemplateStack($model_id) {

        $model_id = $this->checkId($model_id);

        $template = $this->getStack($model_id);

        return $template;

    }

}

?>