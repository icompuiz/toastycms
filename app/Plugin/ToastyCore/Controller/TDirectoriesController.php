<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
App::uses('TDirectory', 'ToastyCore.Model');

/**
 * Contents Controller
 *
 * @property Content $Content
 */
class TDirectoriesController extends ToastyCoreAppController {

	public $components = array('RequestHandler');
	public $uses = array('ToastyCore.TDirectory');

	public function index() {

		$tDirectories = $this->TDirectory->find('threaded', array(
		    'fields' => array('id', 'parent_id', 'name'),
		    'order' => array('TDirectory.lft ASC') // or array('id ASC')
		));
		$this->set(compact('tDirectories'));
		$this->set('_serialize', array('tDirectories'));

		$this->render('index');

	}

	public function view($id) {

        if (!$this->TDirectory->exists($id)) {
            throw new NotFoundException(__('TDirectory not found'));
        }

        $tDirectory = $this->TDirectory->findById($id);

    	$this->set(compact('tDirectory'));
		$this->set('_serialize', array('tDirectory'));

		$this->render('view');
	}

	public function delete($id) { 

        $this->request->onlyAllow('delete');

        $this->TDirectory->id = $id;

		if (!$this->TDirectory->exists($id)) {
            throw new NotFoundException(__('TDirectory not found'));
        }



        if ($this->TDirectory->delete()) {
	        $message =  "TDirectory $id was successfully deleted";
        } else {
        	$message = "TDirectory $id was not deleted";
        }

    	$this->set(compact('message'));
		$this->set('_serialize', array('message'));
		$this->render('delete');
	}

	public function edit($id) {

        $this->request->onlyAllow('put');

        if (!$this->TDirectory->exists($id)) {
            throw new NotFoundException(__('TDirectory not found'));
        }

        $tDirectory = $this->TDirectory->save($this->request->data);

        if (!$tDirectory) {

        	$tDirectory = 'There were errors while saving the document';

        }

        $this->set(compact('tDirectory'));
		$this->set('_serialize', array('tDirectory'));

		$this->render('view');
	}

	public function add() {

        $this->request->onlyAllow('post');

        $this->TDirectory->create();
        $tDirectory = $this->TDirectory->save($this->data);

        if (!$tDirectory) {

        	$tDirectory = 'There were errors while saving the document';

        }

    	$this->set(compact('tDirectory'));

		$this->set('_serialize', array('tDirectory'));

		$this->render('view');

	}

}