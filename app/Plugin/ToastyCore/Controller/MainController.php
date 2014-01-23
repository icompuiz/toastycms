<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');

class MainController extends ToastyCoreAppController {

	public function management_index() {
 
		$this->layout = 'angular';

		$this->render('index');


	}

	public function view() {

		
	}

	public function templates($view) {

	 
		$this->layout = 'ajax';
		$this->render('Main/templates/'. $view);

	}

    public function beforeFilter() {
        parent::beforeFilter();
  
        // $this->Auth->allow('index', 'templates');
    }
 


}

?>