<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
/**
 * OutputFormats Controller
 *
 * @property OutputFormat $OutputFormat
 */
class OutputFormatsController extends ToastyCoreAppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->OutputFormat->recursive = 0;
		$this->set('outputFormats', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OutputFormat->exists($id)) {
			throw new NotFoundException(__('Invalid output format'));
		}
		$options = array('conditions' => array('OutputFormat.' . $this->OutputFormat->primaryKey => $id));
		$this->set('outputFormat', $this->OutputFormat->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->OutputFormat->create();
			if ($this->OutputFormat->save($this->request->data)) {
				$this->Session->setFlash(__('The output format has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The output format could not be saved. Please, try again.'));
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
		if (!$this->OutputFormat->exists($id)) {
			throw new NotFoundException(__('Invalid output format'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OutputFormat->save($this->request->data)) {
				$this->Session->setFlash(__('The output format has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The output format could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OutputFormat.' . $this->OutputFormat->primaryKey => $id));
			$this->request->data = $this->OutputFormat->find('first', $options);
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
		$this->OutputFormat->id = $id;
		if (!$this->OutputFormat->exists()) {
			throw new NotFoundException(__('Invalid output format'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->OutputFormat->delete()) {
			$this->Session->setFlash(__('Output format deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Output format was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
