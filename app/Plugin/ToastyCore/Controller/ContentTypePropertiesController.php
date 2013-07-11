<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
/**
 * ContentTypeProperties Controller
 *
 * @property ContentTypeProperty $ContentTypeProperty
 */
class ContentTypePropertiesController extends ToastyCoreAppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ContentTypeProperty->recursive = 0;
		$this->set('contentTypeProperties', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ContentTypeProperty->exists($id)) {
			throw new NotFoundException(__('Invalid content type property'));
		}
		$options = array('conditions' => array('ContentTypeProperty.' . $this->ContentTypeProperty->primaryKey => $id));
		$this->set('contentTypeProperty', $this->ContentTypeProperty->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ContentTypeProperty->create();
			if ($this->ContentTypeProperty->save($this->request->data)) {
				$this->Session->setFlash(__('The content type property has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content type property could not be saved. Please, try again.'));
			}
		}
		$contentTypePropertySkels = $this->ContentTypeProperty->ContentTypePropertySkel->find('list');
		$contents = $this->ContentTypeProperty->Content->find('list');
		$this->set(compact('contentTypePropertySkels', 'contents'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ContentTypeProperty->exists($id)) {
			throw new NotFoundException(__('Invalid content type property'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ContentTypeProperty->save($this->request->data)) {
				$this->Session->setFlash(__('The content type property has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content type property could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ContentTypeProperty.' . $this->ContentTypeProperty->primaryKey => $id));
			$this->request->data = $this->ContentTypeProperty->find('first', $options);
		}
		$contentTypePropertySkels = $this->ContentTypeProperty->ContentTypePropertySkel->find('list');
		$contents = $this->ContentTypeProperty->Content->find('list');
		$this->set(compact('contentTypePropertySkels', 'contents'));
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
		$this->ContentTypeProperty->id = $id;
		if (!$this->ContentTypeProperty->exists()) {
			throw new NotFoundException(__('Invalid content type property'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ContentTypeProperty->delete()) {
			$this->Session->setFlash(__('Content type property deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Content type property was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
