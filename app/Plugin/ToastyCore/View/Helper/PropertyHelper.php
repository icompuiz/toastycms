<?php

class PropertyHelper extends AppHelper {

	public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);

        $this->view = $view;
    }

	private $view;

	private function outputCTP($item = null) {

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

	public function output($arg1, $arg2 = null) {

		if (is_array($arg1)) {
			return $this->outputCTP($arg1);
		}

		$content_id = $arg1;
		$property_name = $arg2;

		$content = $this->view->controller->Content->findById($content_id);

        $options = array(
    		'conditions' => array(
    			'ContentTypePropertySkel.name' => $property_name,
    			'ContentTypePropertySkel.content_type_id' => $content['ContentType']['id']
			)
    	);

        $skel = $this->view->controller->Content->ContentTypeProperties->ContentTypePropertySkel->find('first', $options);

        if ($skel){
    
            $options = array(
        		'conditions' => array(
        			'ContentTypeProperties.content_id' => $content['Content']['id'],
        			'ContentTypeProperties.content_type_property_skel_id' => $skel['ContentTypePropertySkel']['id']
    			)
        	);
    
        	$property = $this->view->controller->Content->ContentTypeProperties->find('first', $options);
    
    
            $index = $skel['ContentTypePropertySkel']['name'];
            $indexUnderscore = Inflector::underscore($index);
            $indexUnderscore = preg_replace("~\W~", "_", $indexUnderscore);
    
    
            $value = array(
                'ContentTypePropertySkel' => $skel['ContentTypePropertySkel'],
                'OutputFormat' => $skel['OutputFormat'],
                'ContentTypeProperty' => $property['ContentTypeProperties']
            );


    
            return $this->outputCTP($value);
        }

        return "Invalid property name";

	}

}

?>