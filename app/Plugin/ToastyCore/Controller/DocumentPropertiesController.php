<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');


class DocumentPropertiesController extends ToastyCoreAppController {

    public $components = array('RequestHandler');
    public $uses = array('ToastyCore.DocumentProperty');

    public function index() {

        $documentProperties = $this->DocumentProperty->find('all');

        $this->set(compact('documentProperties'));
        $this->set('_serialize', array('documentProperties'));

        $this->render('index');

    }
    
    public function add() {

        $this->request->onlyAllow('post');

        $this->DocumentProperty->create();
        $documentProperty = $this->DocumentProperty->save($this->request->data);

        if (!$documentProperty) {
            $documentProperty = __('There were errors while saving the property');
        }
        
        $this->set(compact('documentProperty'));
        $this->set('_serialize', array('documentProperty'));

        $this->render('view');

    }
    public function edit($id) {

        $this->request->onlyAllow('put');

        if (!$this->DocumentProperty->exists($id)) {
            throw new NotFoundException(__('Property not found'));
        }

        $documentProperty = $this->DocumentProperty->save($this->request->data);

        if (!$documentProperty) {

            $documentProperty = 'There were errors while saving the document type';

        }

        $this->set(compact('documentProperty'));

        $this->set('_serialize', array('documentProperty'));

        $this->render('view');



    }
    public function view($id) {

        if (!$this->DocumentProperty->exists($id)) {
            throw new NotFoundException(__('Property not found'));
        }

        $documentProperty = $this->DocumentProperty->findById($id);

        $this->set(compact('documentProperty'));

        $this->set('_serialize', array('documentProperty'));

        $this->render('view');




    }
    public function delete($id) {

        $this->request->onlyAllow('delete');

        $this->DocumentProperty->id = $id;

        if (!$this->DocumentProperty->exists($id)) {
            throw new NotFoundException(__('Property not found'));
        }


        $deleted = $this->DocumentProperty->delete();
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