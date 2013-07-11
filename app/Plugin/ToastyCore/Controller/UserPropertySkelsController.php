<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
/**
 * UserPropertySkels Controller
 *
 * @property UserPropertySkel $UserPropertySkel
 */
class UserPropertySkelsController extends ToastyCoreAppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->UserPropertySkel->recursive = 0;
		$this->set('userPropertySkels', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->UserPropertySkel->exists($id)) {
			throw new NotFoundException(__('Invalid user property skel'));
		}
		$options = array('conditions' => array('UserPropertySkel.' . $this->UserPropertySkel->primaryKey => $id));
		$this->set('userPropertySkel', $this->UserPropertySkel->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->UserPropertySkel->create();
			if ($this->UserPropertySkel->save($this->request->data)) {
				$this->Session->setFlash(__('The user property skel has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user property skel could not be saved. Please, try again.'));
			}
		}
		$groups = $this->UserPropertySkel->Group->find('list');
		$inputFormats = $this->UserPropertySkel->InputFormat->find('list');
		$outputFormats = $this->UserPropertySkel->OutputFormat->find('list');
		$this->set(compact('groups', 'inputFormats', 'outputFormats'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->UserPropertySkel->exists($id)) {
			throw new NotFoundException(__('Invalid user property skel'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->UserPropertySkel->save($this->request->data)) {
				$this->Session->setFlash(__('The user property skel has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user property skel could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('UserPropertySkel.' . $this->UserPropertySkel->primaryKey => $id));
			$this->request->data = $this->UserPropertySkel->find('first', $options);
		}
		$groups = $this->UserPropertySkel->Group->find('list');
		$inputFormats = $this->UserPropertySkel->InputFormat->find('list');
		$outputFormats = $this->UserPropertySkel->OutputFormat->find('list');
		$this->set(compact('groups', 'inputFormats', 'outputFormats'));
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
		$this->UserPropertySkel->id = $id;
		if (!$this->UserPropertySkel->exists()) {
			throw new NotFoundException(__('Invalid user property skel'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->UserPropertySkel->delete()) {
			$this->Session->setFlash(__('User property skel deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User property skel was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
