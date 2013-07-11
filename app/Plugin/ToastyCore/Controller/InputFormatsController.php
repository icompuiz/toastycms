<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
/**
 * InputFormats Controller
 *
 * @property InputFormat $InputFormat
 */
class InputFormatsController extends ToastyCoreAppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->InputFormat->recursive = 0;
		$this->set('inputFormats', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->InputFormat->exists($id)) {
			throw new NotFoundException(__('Invalid input format'));
		}
		$options = array('conditions' => array('InputFormat.' . $this->InputFormat->primaryKey => $id));
		$this->set('inputFormat', $this->InputFormat->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InputFormat->create();
			if ($this->InputFormat->save($this->request->data)) {
				$this->Session->setFlash(__('The input format has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The input format could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->InputFormat->exists($id)) {
			throw new NotFoundException(__('Invalid input format'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->InputFormat->save($this->request->data)) {
				$this->Session->setFlash(__('The input format has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The input format could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('InputFormat.' . $this->InputFormat->primaryKey => $id));
			$this->request->data = $this->InputFormat->find('first', $options);
		}
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
		$this->InputFormat->id = $id;
		if (!$this->InputFormat->exists()) {
			throw new NotFoundException(__('Invalid input format'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->InputFormat->delete()) {
			$this->Session->setFlash(__('Input format deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Input format was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
