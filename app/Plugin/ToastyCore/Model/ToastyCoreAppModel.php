<?php

App::uses('AppModel', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class ToastyCoreAppModel extends AppModel {

    public $name = 'ToastyCoreAppModel';
    public $base_path;    

    protected function checkId($id = null) {
        if (!$id) {
            $id = $this->id;
        }

        if (!$id) {
            $id = $this->data[$this->alias]['id'];
        }



        if (!$id) {
            throw new Exception("An Id must be provided");
        }

        return $id;
    }

    protected function readFile($path_to_file = null) {


        $file = new File($path_to_file);
        $contents = "";

        if ($file->exists()) {

            $file->open('r');
            $contents = $file->read();
        } else {
            throw new Exception("File at " . $path_to_file . " cannot be found");
        }

        return $contents;
    }

    protected function writeFile($contents = null, $path_to_file = null, $create = true) {

        $file = new File($path_to_file);


        $created = $create;
        if (!$file->exists()) {

            if ($create) {
                $created = $file->create();
            }
        }
//        debug(posix_getpwuid ($file->owner()));exit;
        if ($created) {

            $file->open('w');


            $file->write($contents, 'w', true);
            $file->close();
        } else {

            throw new Exception("File at " . $path_to_file . " cannot be found");
        }
    }

    protected function uploadFile($value = null, $base = "", $ignore_base = false) {

        if ($value) {
            $uploaded = $this->upload($value, $base, $ignore_base);
            if ($uploaded) {
                return $uploaded[$this->name]['path'];
            }
        }

        return false;
    }

    protected function isFileValue($value = null) {
        if ($value) {

            if (is_array($value) && isset($value['error'])) {

                return true;
            }
        }

        return false;
    }

    protected function isEmptyValue($value = null) {

        if ($this->isFileValue($value)) {
            return $value['error'] == 4;
        }

        if (!is_array($value)) {

            $value = trim($value);

        }

        return empty($value);

    }

    public $paths = array(
        'img' => 'img',
        'css' => 'css',
        'js' => 'js'
    );

    function getPath($type) {


        switch ($type) {

            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
            case 'image/pjpeg':
                $path = $this->paths['img'];
                break;
            case 'text/css':
                $path = $this->paths['css'];
                break;
            case 'application/x-javascript':
                $path = $this->paths['js'];
                break;
            default:
                $path = '';
                break;
        }

        return $path;
    }

    /**
      Upload a file to the appropriate webroot directory
      image types will be uploaded to the webroot/img
      css files will be uploaded to the webroot/css
      javascript files will be uploaded to the webroot/js
      If a base path is passed in the file will be
      uploaded to the base path
      If the the based path does not exist it will be created
     */
    function upload($options, $base = null, $ignore_base = false) {



        $tmp = $options;
        $file = $options['file'];

        if (isset($options['name'])) {

            $tmp_name = $options['name'];
            $file_name = $file['name'];
            $ext = $this->getFileExt($file_name);
            $file['name'] = "$tmp_name.$ext";
        }


        $uploaded = true;

        $replace = array(",", " ");
        $name = str_replace($replace, "_", $file['name']);
        $name = str_replace(" ", "_", $name);
        
        $path = '';
        $rel_url = '';
        $folder_url = '';

        if (!$ignore_base) {
            $path = $this->getPath($file['type']);
        }


        if ($path != '') {

            if (!Folder::isSlashTerm($path)) {
                $path .= DS;
            }

            $rel_url = $base ? $path . $base : $path;
            $folder_url = WWW_ROOT . $rel_url;

        } else {

            $rel_url = $base ? $base : '';
            $folder_url = WWW_ROOT . $rel_url;

        }

        if (!is_dir($folder_url)) {
            mkdir($folder_url);
        }

        if (!Folder::isSlashTerm($folder_url)) {
            $folder_url .= DS;
        }

        if (!Folder::isSlashTerm($rel_url)) {
            $rel_url .= DS;
        }

        $full_url = $folder_url . $name;
        $url = $rel_url . $name;
        

        $exists = false;
        if (file_exists($full_url)) {
            $exists = true;
        }

        $uploaded = move_uploaded_file($file['tmp_name'], $full_url);

        if ($uploaded)
            chmod($full_url, 0775);

        if ($uploaded) {
            unset($uploaded);
            $uploaded[$this->name]['name'] = $name;
            $uploaded[$this->name]['path'] = $url;
            $uploaded[$this->name]['fileType'] = $file['type'];
        }
        return $uploaded;
    }

    protected function getFileExt($file_name) {

        return substr($file_name, strrpos($file_name, ".") + 1);

    }

    protected function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    
    protected function deleteFile($rel_path) {
        if (file_exists($rel_path)) {
            return unlink($rel_path);
        }
        return false;
    }

}

?>
