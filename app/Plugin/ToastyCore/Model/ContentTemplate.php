<?php

App::uses('ToastyCoreAppModel', 'ToastyCore.Model');

class ContentTemplate extends ToastyCoreAppModel {

    public $name = 'ContentTemplate';
    public $_schema = array(
        'id' => array(
            'type' => 'integer',
            'length' => 11
        ),
        'parent_content_template_id' => array(
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
            'rule' => array('php_check'),
            'message' => 'There are PHP errors in the template'
        ),
        'parent_content_id' => array(
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

        $template = $this->read(null, $id);

        $children = $template['ChildContentTemplates'];

        return $children;
    }

    public function setParentTemplate($template_id = null, $id = null) {
        $id = $this->checkId($id);

        if ($template_id) {

            $data = array(
                'ContentTemplate' => array(
                    'id' => $id,
                    'parent_content_template_id' => $template_id
                )
            );

            $this->save($data);

            return;
        }

        throw new Exception("template_id parameter must be provided");
    }

    public function getParentTemplate($id = null) {

        $id = $this->checkId($id);

        $template = $this->read(null, $id);

        $parent = $template['ParentContentTemplate'];

        return $parent;
    }

    public function getName($id = null) {
        $id = $this->checkId($id);

        $template = $this->read(null, $id);

        $name = $template['ContentTemplate']['name'];

        return $name;
    }

    public function setName($newName = null, $id = null) {

        $id = $this->checkId($id);

        if ($newName) {

            $data = array(
                'ContentTemplate' => array(
                    'id' => $id,
                    'name' => $newName
                )
            );

            $this->save($data);

            return;
        }

        throw new Exception("newName parameter must be provided");
    }

    public function getPath($id = null) {

        $id = $this->checkId($id);

        $template = $this->read(null, $id);

        $path = $template['ContentTemplate']['system_path'];

        return $path;
    }

    public function setPath($newPath = null, $id = null) {

        $id = $this->checkId($id);

        if ($newPath) {

            $data = array(
                'ContentTemplate' => array(
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

        $conditions = array('ContentTemplate.id' => $id);
        $format = $this->find('first', array("conditions" => $conditions));
        $path_to_file = $format['ContentTemplate']['system_path'];
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

            $conditions = array('ContentTemplate.id' => $id);
            $format = $this->find('first', array("conditions" => $conditions));
            $path_to_file = $format['ContentTemplate']['system_path'];

            $absPath = $this->getAbsolutePath($path_to_file);

            parent::writeFile($contents, $absPath, $create);

            return;
        }

        throw new Exception("contents must be provided");
    }

    private function getAbsolutePath($path_to_file) {

        $paths = App::path('View');
        $path = array_shift($paths);
        $base_path = $path . 'ContentTemplates' . DS;

        return $base_path . $path_to_file;
    }

    public $hasMany = array(
        'ChildContentTemplates' => array(
            'className' => 'ToastyCore.ContentTemplate',
            'foreignKey' => 'parent_content_template_id'
        )
    );
    public $belongsTo = array(
        'ParentContentTemplate' => array(
            'className' => 'ToastyCore.ContentTemplate'
        )
    );

    public function beforeDelete($cascade = true) {
        parent::beforeDelete($cascade);

        $path = array_shift(App::path('View')) . 'ContentTemplates' . DS;
        $path .= $this->getPath($this->id);
        
        if ( !empty($this->data['ChildContentTemplates'])) {
            return false;
        }
        
        $file = new File($path);
        
        if ($file->exists()) {
            $file->delete();
        }
        
        return true;
    }

    public function beforeSave($options = array()) {

        parent::beforeSave($options);

        $data = $this->data;

        
        $path = App::pluginPath('ToastyCore') . "tmp_files" . DS;
        $path = str_replace("/", "\/", $path);

        $tmp_exists = preg_match("/$path/", $data['ContentTemplate']['system_path']);

        if ($tmp_exists) {

            $file = new File($data['ContentTemplate']['system_path']);
            $file->open();
            // debug($file->read()); exit;

            $paths = App::path('View');
            $path = array_shift($paths) . 'ContentTemplates' . DS;

            if (!is_dir($path)) {
                mkdir($path);
            }

            $id = $data['ContentTemplate']['id'];

            $name = $data['ContentTemplate']['name'];
            $name = preg_replace("/\W/", "", $name);
            $name = Inflector::underscore($name);

            $name .= ".ctp";

            $old = isset($data['ContentTemplate']['original_path']);
            if ($old) {
                $old = $data['ContentTemplate']['original_path'];
                if ($old != $name) {
                    $old_file = new File($path . $old);
                    $old_file->delete();
                }
            }

            $dest = $path . $name;

           // debug($dest); exit;

            $file->copy($dest);

            $file->delete();

            $this->data['ContentTemplate']['system_path'] = $name;
        }
    }

    public function php_check($contents) {

        $data = $this->data;
        $pct = $this->findById($data['ContentTemplate']['parent_content_template_id']);

        $parentPath = false;
        if (!empty($pct)) {


            $hasParent = $pct['ParentContentTemplate']['id'] !== null;

            if ($hasParent) {
                $parentPath = $pct['ContentTemplate']['system_path'];
                $parentPath = str_replace('.ctp', '', $parentPath);

                $parentPath = "$parentPath";
            }

        }

        $name = $this->generateRandomString();
        $path = App::pluginPath('ToastyCore') . "tmp_files" . DS;


        if (!is_dir($path)) {
            mkdir($path);
        }

        $full_name = $path . $name;

        $file = new File($full_name);

        $file->create();

        $file->open('w');

        if ($parentPath) {



            $extendStatement = '<?php $this->extend(\'' . $parentPath . '\');?>' . "\r\n";
            $contents['content'] = preg_replace('~<\?(php)?\s*\$this->extend\(\'.*\'\);\s*\?>(\r\n)+~', "", $contents['content']);
            $contents['content'] = $extendStatement . $contents['content'];

        }

        $file->write($contents['content']);

        $file->close();

        $command = "php -l " . $full_name;

        $output_lines = array();
        $status = array();

        $output = exec("php -l $full_name  2>&1", $output_lines, $status);

        if (0 === $status) {
            $this->data['ContentTemplate']['system_path'] = $full_name;
            return true;
        }

        $error_str = $output_lines[0];
        $error_str = str_replace("in $full_name", "", $error_str);

        return $error_str;
    }

     public function checkDescendant($options) {
        
        $id = isset($options['parent_content_template_id']) ? $options['parent_content_template_id'] : null;

        $ct = $this->Data['ContentTemplate']['id'];


        return !$this->isDescendant($ct, $id);
    }

    public function isDescendant($parent, $id) {

        if (empty($id)) {
            return false;
        }

        $isDescendant = false;

        $current_id = $id;
        do {

            $data = $this->findById($current_id);

            $pid = $data['ParentContentTemplate']['id'];
            $current_id = $pid;
            
            if ($pid === $parent) {
                $isDescendant = true;
            }

        } while ( !$isDescendant && null !== $pid );


        return $isDescendant;
    }

    public function getTemplateStack($id = null) {
        $id = $this->checkId($id);

        if (!empty($id)) {

            $this->read(null, $id);

            $tmpls[] = $this->data['ContentTemplate'];


            $pid = $this->getParentTemplate($id);
            $pid = $this->data['ParentContentTemplate']['id'];

            if (null !== $pid) {

                do {

                    $parent = new ContentTemplate();
                    $parent->read(null, $pid);
                    $tmpls[] = $parent->data['ContentTemplate'];

                    $pid = $parent->data['ParentContentTemplate']['id'];


                } while ( null !== $pid );

                $tmpls = array_reverse($tmpls);


            }
            return $tmpls;

        }

        return null;



    }

}

?>