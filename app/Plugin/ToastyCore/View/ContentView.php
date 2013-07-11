<?php

App::uses('View', 'View');
App::uses('Setting', 'ToastyCore.Model');

class ContentView extends View {

	public function __construct(Controller $controller = null) {
		parent::__construct($controller);

		$this->controller = $this->c = $controller;
	}
	public function snippet($snippet_name, $options = array()) {

		return $this->Snippet->render($snippet_name, $options);
		
	}

	public function property($property_name) {


		$variable = $this->getVar($property_name);
		return $this->Property->output($variable);


	}

	public function setting($setting_name) {

		$setting = new Setting();

		$setting = $setting->findByName($setting_name);

		$value = "No setting with name: $setting_name";

		if (!empty($setting)) {
			$value = $setting['Setting']['value'];
		}

		return $value;

	}

	public function site($site_variable_name) {

		return "&lt;$site_variable_name&gt;";

	}

	public function getContent($content_id) {

		$content = $this->c->Content;

		return $content->findById($content_id);



	}
}

?>