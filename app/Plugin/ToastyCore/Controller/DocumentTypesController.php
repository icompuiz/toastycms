<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');

class DocumentTypesController extends ToastyCoreAppController {

	public $components = array('RequestHandler');
	public $uses = array('ToastyCore.DocumentType');

	public function index() {

		$document_types = $this->DocumentType->find('threaded', array(
		    'fields' => array('id', 'parent_id', 'name'),
		    'order' => array('DocumentType.lft ASC') // or array('id ASC')
		));

		$this->set(compact('document_types'));
		$this->set('_serialize', array('document_types'));

		$this->render('index');

	}


	public function view($id) {

        if (!$this->DocumentType->exists($id)) {
            throw new NotFoundException(__('Document Type not found'));
        }

        $document_type = $this->DocumentType->findById($id);


        if (!empty($document_type)) {
        	unset($document_type['Document ']);
        }


    	$this->set(compact('document_type'));
		$this->set('_serialize', array('document_type'));

		$this->render('view');

	}

	public function add() {

		$this->request->onlyAllow('post');

		$this->DocumentType->create();
        $document_type = $this->DocumentType->save($this->request->data);

        if (!$document_type) {
        	$document_type = 'There were errors while saving the document type';
        }
        
    	$this->set(compact('document_type'));
		$this->set('_serialize', array('document_type'));
		$this->render('view');
	}

	public function edit($id)
	{
		$this->request->onlyAllow('put');

		if (!$this->DocumentType->exists($id)) {
            throw new NotFoundException(__('Document not found'));
        }

        // debug($this->request->data); exit;

        $document_type = $this->DocumentType->saveAssociated($this->request->data);

        unset($this->request->data['Document']);

        if (!$document_type) {

        	$document_type = 'There were errors while saving the document type';

        } else {

        	if (isset($this->request->data['deletedProperties'])) {

        		foreach ($this->request->data['deletedProperties'] as $property) {

        			$this->DocumentType->DocumentTypeProperty->delete($property['id']);

        		}

        	}
        	
        	$document_type = $this->DocumentType->findById($id);

        }

    	$this->set(compact('document_type'));

		$this->set('_serialize', array('document_type'));

		$this->render('view');
	}

	public function delete($id)
	{
		$this->request->onlyAllow('delete');

        $this->DocumentType->id = $id;

		if (!$this->DocumentType->exists($id)) {
            throw new NotFoundException(__('DocumentType not found'));
        }

        $deleted = $this->DocumentType->delete();

        if ($deleted) {
	        $message =  "Document Type $id was successfully deleted";
        } else {
        	$message = "Document Type $id was not deleted";
        }

    	$this->set(compact('message'));
		$this->set('_serialize', array('message'));
		$this->render('delete');
	}

    public function beforeFilter() {
        parent::beforeFilter();

        // $this->Auth->allow('index', 'edit', 'delete', 'view');
    }

}