<?php
App::uses('StaticfileBase', 'ToastyCore.Model');
define("CURRENT_PATH", APP . WEBROOT_DIR . DS . "js" . DS);
class Javascript extends StaticfileBase {

	public $useTable = 'javascripts';

    public $name = 'Javascript';

    public $staticPath = CURRENT_PATH;

    public $staticExtension = ".js";

}

?>