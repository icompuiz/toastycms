<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');


class TFilesController extends ToastyCoreAppController {

    public $components = array('RequestHandler');
    public $uses = array('ToastyCore.TFile');

    public function index() {

        $tFiles = $this->TFile->find('all');

        $this->set(compact('tFiles'));
        $this->set('_serialize', array('tFiles'));

        $this->render('index');

    }

    public function add() {

        $this->request->onlyAllow('post');

        $this->TFile->create();
        $tFile = $this->TFile->save($this->data);

        if (!$tFile) {
            $tFile = __('There were errors while saving the file');
        }
        
        $this->set(compact('tFile'));
        $this->set('_serialize', array('tFile'));

        $this->render('view');

    }

    public function view($id) {

        if (!$this->TFile->exists($id)) {
            throw new NotFoundException(__('TFile not found'));
        }

        $tFile = $this->TFile->findById($id);

        $this->set(compact('tFile'));
        $this->set('_serialize', array('tFile'));

        $this->render('view');
    }

    public function edit($id) {

        $this->request->onlyAllow('put');

        if (!$this->TFile->exists($id)) {
            throw new NotFoundException(__('TFile not found'));
        }

        $tFile = $this->TFile->save($this->request->data);

        if (!$tFile) {

            $tFile = 'There were errors while saving the tfile';

        }

        $this->set(compact('tFile'));

        $this->set('_serialize', array('tFile'));

        $this->render('view');


    }

    public function delete($id) {

        $this->request->onlyAllow('delete');

        $this->TFile->id = $id;

        if (!$this->TFile->exists($id)) {
            throw new NotFoundException(__('TFile not found'));
        }


        $deleted = $this->TFile->delete();
        if ($deleted) {
            $message =  "TFile $id was successfully deleted";
        } else {
            $message = "TFile $id was not deleted";
        }

        $this->set(compact('message'));
        $this->set('_serialize', array('message'));
        $this->render('delete');

    }

}

?>