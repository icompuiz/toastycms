<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
App::uses('Document', 'ToastyCore.Model');

/**
 * Contents Controller
 *
 * @property Content $Content
 */
class DocumentsController extends ToastyCoreAppController {

	public $components = array('RequestHandler');
	public $uses = array('ToastyCore.Document');

	public function index() {

		$documents = $this->Document->find('threaded', array(
		    'fields' => array('id', 'parent_id', 'name'),
		    'order' => array('Document.lft ASC') // or array('id ASC')
		));
		$this->set(compact('documents'));
		$this->set('_serialize', array('documents'));

		$this->render('index');

	}

	public function view($id) {

        if (!$this->Document->exists($id)) {
            throw new NotFoundException(__('Document not found'));
        }

        $document = $this->Document->findById($id);
        $document['children'] = $this->Document->children($id, true);
        $document['parent'] = $this->Document->getParentNode($id);

        $tmp = $document['DocumentType'];
        $document['DocumentType'] = array();
        $document['DocumentType']['DocumentType'] = $tmp;


        $document['DocumentType']['DocumentTypeProperty'] = $this->Document->DocumentType->DocumentTypeProperty->find(
            'all', 
            array(
                'conditions' => array(
                    'DocumentTypeProperty.document_type_id' => $tmp['id']
                )
            )
        );

        $pathStack = $this->Document->getStack($id, $this->Document->getDefaultMappingFunction());
        $document['Document']['path'] = array(
            'stack' => $pathStack,
            'string' => $this->Document->stackToString($pathStack)
        );


    	$this->set(compact('document'));
		$this->set('_serialize', array('document'));

		$this->render('view');
	}

	public function delete($id) { 

        $this->request->onlyAllow('delete');

        $this->Document->id = $id;

		if (!$this->Document->exists()) {
            
            $error = "Document $id not found";
            $this->set(compact('error'));
            $this->set('_serialize', array('error'));
            $this->response->statusCode(404);

        } else {


            if ($this->Document->delete()) {
                $error =  "Document $id was successfully deleted";
                $this->set(compact('error'));
                $this->set('_serialize', array('error'));
            } else {
                $error = "Document $id was not deleted";
                $this->set(compact('error'));
                $this->set('_serialize', array('error'));
                $this->response->statusCode(400);

            }

        }

		$this->render('delete');
	}

	public function edit($id) {

        $this->request->onlyAllow('put');

        if (!$this->Document->exists($id)) {

            $error = "Document $id not found";
            $this->set(compact('error'));
            $this->set('_serialize', array('error'));
            $this->response->statusCode(404);

        } else {


            $this->Document->set($this->request->data);

            if ($this->Document->validates()) {

                $document = $this->Document->save($this->request->data);
                $this->set(compact('document'));
                $this->set('_serialize', array('document'));

            } else {

                $errors = $this->Document->validationErrors;
                $this->set(compact('errors'));
               $this->set('_serialize', array('errors'));
                $this->response->statusCode(400);


            }

        }

		$this->render('view');
	}

	public function add() {

        $this->request->onlyAllow('post');

        $this->Document->create();
        $this->Document->set($this->request->data);

        if ($this->Document->validates()) {

            $document = $this->Document->save($this->request->data);
            $this->set(compact('document'));
            $this->set('_serialize', array('document'));

        } else {

            $errors = $this->Document->validationErrors;
            $this->set(compact('errors'));
           $this->set('_serialize', array('errors'));
            $this->response->statusCode(400);


        }

		$this->render('view');

	}

    public function beforeFilter() {
        parent::beforeFilter();

        // $this->Auth->allow('index', 'add', 'edit', 'delete', 'view');
    }




}