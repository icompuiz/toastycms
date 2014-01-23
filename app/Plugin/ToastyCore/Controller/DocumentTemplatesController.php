<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
class DocumentTemplatesController extends ToastyCoreAppController {

	public $components = array('RequestHandler');
	public $uses = array('ToastyCore.DocumentTemplate');

	public function index() {

		$documentTemplates = $this->DocumentTemplate->find('threaded', array(
		    'fields' => array('id', 'parent_id', 'name'),
		    'order' => array('DocumentTemplate.lft ASC') // or array('id ASC')
		));
		$this->set(compact('documentTemplates'));
		$this->set('_serialize', array('documentTemplates'));

		$this->render('index');

	}

	public function view($id) {

        if (!$this->DocumentTemplate->exists($id)) {
            throw new NotFoundException(__('Document Template not found'));
        }

        $documentTemplate = $this->DocumentTemplate->findById($id);

    	$this->set(compact('documentTemplate'));
		$this->set('_serialize', array('documentTemplate'));

		$this->render('view');
	}

	public function delete($id) { 

        $this->request->onlyAllow('delete');

        $this->DocumentTemplate->id = $id;

		if (!$this->DocumentTemplate->exists($id)) {
            throw new NotFoundException(__('DocumentTemplate not found'));
        }



        if ($this->DocumentTemplate->delete()) {
	        $message =  "Document Template $id was successfully deleted";
        } else {
        	$message = "Document Template $id was not deleted";
        }

    	$this->set(compact('message'));
		$this->set('_serialize', array('message'));
		$this->render('delete');
	}

	public function edit($id) {

        $this->request->onlyAllow('put');

        if (!$this->DocumentTemplate->exists($id)) {
            throw new NotFoundException(__('Document Template not found'));
        }

         $this->DocumentTemplate->set($this->request->data);

         if($this->DocumentTemplate->validates()) {

         	$documentTemplate = $this->DocumentTemplate->save($this->request->data);

         } else {

        	$documentTemplate['errors'] = $this->DocumentTemplate->invalidFields();
         
         }




        $this->set(compact('documentTemplate'));
		$this->set('_serialize', array('documentTemplate'));

		$this->render('view');
	}

	public function add() {

        $this->request->onlyAllow('post');

         $this->DocumentTemplate->set($this->request->data);

         if($this->DocumentTemplate->validates()) {

         	$documentTemplate = $this->DocumentTemplate->save($this->request->data);

         } else {

        	$documentTemplate['errors'] = $this->DocumentTemplate->invalidFields();
        	
         
         }

    	$this->set(compact('documentTemplate'));

		$this->set('_serialize', array('documentTemplate'));

		$this->render('view');

	}


}

?>