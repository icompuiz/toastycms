<?php

class PropertyHelper extends AppHelper {

	public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);

        $this->view = $view;
    }

	private $view;

	public function output($item = null) {

		$outputFormat = $item['OutputFormat'];
		$property = $item['ContentTypeProperty'];
		$skel = $item['ContentTypePropertySkel'];



		$path = $outputFormat['system_path'];
		$output = "";
		if (!empty($path)) {
			$path = "ToastyCore.Formats/$path";

			$options = array(
				'id' => "ctp-" . $property['id'],
				'value' => $property['value'],
				'property' => $property,
				'skel' => $skel
			);

			$output = $this->view->element($path, $options);
		}
		return $output;

	}

}

?>