<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');


class DocumentTypePropertiesController extends ToastyCoreAppController {

	public $components = array('RequestHandler');
	public $uses = array('ToastyCore.DocumentTypeProperty');

	public function index() {

		$documentTypeProperties = $this->DocumentTypeProperty->find('all');

		$this->set(compact('documentTypeProperties'));
		$this->set('_serialize', array('documentTypeProperties'));

		$this->render('index');

	}
	
	public function add() {

		$this->request->onlyAllow('post');

		$this->DocumentTypeProperty->create();
        $documentTypeProperty = $this->DocumentTypeProperty->save($this->data);

        if (!$documentTypeProperty) {
        	$documentTypeProperty = __('There were errors while saving the property');
        }
        
    	$this->set(compact('documentTypeProperty'));
		$this->set('_serialize', array('documentTypeProperty'));

		$this->render('view');

	}
	public function edit($id) {

		$this->request->onlyAllow('put');

		if (!$this->DocumentTypeProperty->exists($id)) {
            throw new NotFoundException(__('Property not found'));
        }

        $documentTypeProperty = $this->DocumentTypeProperty->save($this->data);

        if (!$documentTypeProperty) {

        	$documentTypeProperty = 'There were errors while saving the document type';

        }

    	$this->set(compact('documentTypeProperty'));

		$this->set('_serialize', array('documentTypeProperty'));

		$this->render('view');



	}
	public function view($id) {

		if (!$this->DocumentTypeProperty->exists($id)) {
            throw new NotFoundException(__('Property not found'));
        }

        $documentTypeProperty = $this->DocumentTypeProperty->findById($id);

        $this->set(compact('documentTypeProperty'));

		$this->set('_serialize', array('documentTypeProperty'));

		$this->render('view');




	}
	public function delete($id) {

		$this->request->onlyAllow('delete');

        $this->DocumentTypeProperty->id = $id;

		if (!$this->DocumentTypeProperty->exists($id)) {
            throw new NotFoundException(__('Property not found'));
        }


        $deleted = $this->DocumentTypeProperty->delete();
        if ($deleted) {
	        $message =  "Property $id was successfully deleted";
        } else {
        	$message = "Property $id was not deleted";
        }

    	$this->set(compact('message'));
		$this->set('_serialize', array('message'));
		$this->render('delete');

	}

}