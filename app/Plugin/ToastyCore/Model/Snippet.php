<?php
App::uses('StaticfileBase', 'ToastyCore.Model');
define("CURRENT_PATH", APP . "View" . DS . "Elements" . DS . "Snippets" . DS);

class Snippet extends StaticfileBase {

	public $useTable = 'snippets';

    public $name = 'Snippet';

    public $staticPath = CURRENT_PATH;
    public $staticExtension = ".ctp";

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


        $command = "php -l " . $full_name;

        $output_lines = array();
        $status = array();

        $output = exec("php -l $full_name  2>&1", $output_lines, $status);

        if (0 === $status) {
            $this->data[$this->alias]['system_path'] = $full_name;
            return true;
        }

        $error_str = $output_lines[0];
        $error_str = str_replace("in $full_name", "", $error_str);

        return $error_str;
    }

}

?>