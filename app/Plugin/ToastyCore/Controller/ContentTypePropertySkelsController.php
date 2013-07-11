<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');

/**
 * ContentTypePropertySkels Controller
 *
 * @property ContentTypePropertySkel $ContentTypePropertySkel
 */
class ContentTypePropertySkelsController extends ToastyCoreAppController {
    
        public $components = array('RequestHandler');


    public function management_index() {
        
        $all_ctps = $this->ContentTypePropertySkel->find('all');
        
        
        $this->set(array('all_ctps' => $all_ctps)); 
        
    }

    public function management_view($id) {
        
        if (!$this->ContentTypePropertySkel->exists($id)) {
            throw new NotFoundException(__('Invalid content type property skel'));
        }
        
        exit;
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->ContentTypePropertySkel->recursive = 0;
        $this->set('contentTypePropertySkels', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->ContentTypePropertySkel->exists($id)) {
            throw new NotFoundException(__('Invalid content type property skel'));
        }
        $options = array('conditions' => array('ContentTypePropertySkel.' . $this->ContentTypePropertySkel->primaryKey => $id));
        $this->set('contentTypePropertySkel', $this->ContentTypePropertySkel->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->ContentTypePropertySkel->create();
            if ($this->ContentTypePropertySkel->save($this->request->data)) {
                $this->Session->setFlash(__('The content type property skel has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The content type property skel could not be saved. Please, try again.'));
            }
        }
        $contentTypes = $this->ContentTypePropertySkel->ContentType->find('list');
        $inputFormats = $this->ContentTypePropertySkel->InputFormat->find('list');
        $outputFormats = $this->ContentTypePropertySkel->OutputFormat->find('list');
        $this->set(compact('contentTypes', 'inputFormats', 'outputFormats'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->ContentTypePropertySkel->exists($id)) {
            throw new NotFoundException(__('Invalid content type property skel'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ContentTypePropertySkel->save($this->request->data)) {
                $this->Session->setFlash(__('The content type property skel has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The content type property skel could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ContentTypePropertySkel.' . $this->ContentTypePropertySkel->primaryKey => $id));
            $this->request->data = $this->ContentTypePropertySkel->find('first', $options);
        }
        $contentTypes = $this->ContentTypePropertySkel->ContentType->find('list');
        $inputFormats = $this->ContentTypePropertySkel->InputFormat->find('list');
        $outputFormats = $this->ContentTypePropertySkel->OutputFormat->find('list');
        $this->set(compact('contentTypes', 'inputFormats', 'outputFormats'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->ContentTypePropertySkel->id = $id;
        if (!$this->ContentTypePropertySkel->exists()) {
            throw new NotFoundException(__('Invalid content type property skel'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->ContentTypePropertySkel->delete()) {
            $this->Session->setFlash(__('Content type property skel deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Content type property skel was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
