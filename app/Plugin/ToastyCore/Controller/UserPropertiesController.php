<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
/**
 * UserProperties Controller
 *
 * @property UserProperty $UserProperty
 */
class UserPropertiesController extends ToastyCoreAppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->UserProperty->recursive = 0;
		$this->set('userProperties', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->UserProperty->exists($id)) {
			throw new NotFoundException(__('Invalid user property'));
		}
		$options = array('conditions' => array('UserProperty.' . $this->UserProperty->primaryKey => $id));
		$this->set('userProperty', $this->UserProperty->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->UserProperty->create();
			if ($this->UserProperty->save($this->request->data)) {
				$this->Session->setFlash(__('The user property has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user property could not be saved. Please, try again.'));
			}
		}
		$users = $this->UserProperty->User->find('list');
		$userPropertySkels = $this->UserProperty->UserPropertySkel->find('list');
		$this->set(compact('users', 'userPropertySkels'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->UserProperty->exists($id)) {
			throw new NotFoundException(__('Invalid user property'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->UserProperty->save($this->request->data)) {
				$this->Session->setFlash(__('The user property has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user property could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('UserProperty.' . $this->UserProperty->primaryKey => $id));
			$this->request->data = $this->UserProperty->find('first', $options);
		}
		$users = $this->UserProperty->User->find('list');
		$userPropertySkels = $this->UserProperty->UserPropertySkel->find('list');
		$this->set(compact('users', 'userPropertySkels'));
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
		$this->UserProperty->id = $id;
		if (!$this->UserProperty->exists()) {
			throw new NotFoundException(__('Invalid user property'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->UserProperty->delete()) {
			$this->Session->setFlash(__('User property deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User property was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
