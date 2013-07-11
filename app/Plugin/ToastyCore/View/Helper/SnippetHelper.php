<?php

class SnippetHelper extends AppHelper {

	public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);

        $this->view = $view;
    }

	public function render($snippet_name, $options) {



		if (!is_array($options)) {

			$options = json_decode($options, true);

			if (null === $options) {

				return "Error: second parameter must be an array or json string";

			}

		}

		$path = "Snippets/$snippet_name";
		if ( preg_match('~Toasty~', $snippet_name) ) {

			$snippet_name = preg_replace("~Toasty.*\.~", "", $snippet_name);
			$path = "ToastyCore.Snippets/$snippet_name";
			
		}


		$output = $this->view->element($path, $options);

		return $output;


	}

}

?>