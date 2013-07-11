<?php
App::uses('StaticfileBase', 'ToastyCore.Model');
define("CURRENT_PATH", APP . WEBROOT_DIR . DS . "css" . DS);
class Stylesheet extends StaticfileBase {

	public $useTable = 'stylesheets';

    public $name = 'Stylesheet';

    public $staticPath = CURRENT_PATH;

    public $staticExtension = ".css";

}

?>