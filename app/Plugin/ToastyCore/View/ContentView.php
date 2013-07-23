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

	public function property($arg1, $arg2 = null) {

		$output = "";
		if (!$arg2) {

			$property_name = $arg1;
			$variable = $this->getVar($property_name);
			if (!empty($variable)) {
				$output = $this->Property->output($variable);
			}

		} else {

			$content_id = $arg1;
			$property_name = $arg2;
			$output = $this->Property->output($content_id, $property_name);

		}

		return $output;
		
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

	public function getContent($arg1, $arg2 = array()) {

		$content = $this->c->Content;
		
		$output = array();

		if (is_numeric($arg1)) {

			$content_id = $arg1;

			$output = $content->findById($content_id);

			return $output;

		}

		if (is_array($arg2)) {

			$scope = $arg1;

			$options = $arg2;

			$output = $content->find($scope, $options);
			
			return $output;

		} 



	}

	public function implode_associative($pieces) {
		$output = "";

		if (null !== $pieces ) {
			foreach ($pieces as $key => $value) {
				$output .= "$key=\"$value\"";
			}
		}

		$output = " " . trim($output);
		return $output;

	}
}

?>