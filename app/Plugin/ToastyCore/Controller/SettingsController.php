<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');

class SettingsController extends ToastyCoreAppController {

	public function management_index() {

		$settings = $this->Setting->find('all');

		$this->set(compact('settings'));
		
	}

	public function management_add() {


		if($this->request->is('post')) {

			$data = $this->request->data;

			$this->Setting->create();
			$setting = $this->Setting->save($data);

			if ($setting) {

                $this->Session->setFlash(__('The setting has been successfully added'));


			} else {

				$this->Session->setFlash(__('The setting has not been saved'));

			}

		}
		$this->redirect(array('action' => 'management_index'));

	}

	public function management_edit($id) {

		if (!$this->Setting->exists($id)) {
            throw new NotFoundException(__('Could not find a setting with that identifier'));

		}

		if($this->request->is('post') || $this->request->is('put')) {
			
			$data = $this->request->data;

			$setting = $this->Setting->save($data);

			if ($setting) {

                $this->Session->setFlash(__('The setting has been successfully saved'));


			} else {

				$this->Session->setFlash(__('The setting has not been saved'));
				
			}

		}
		$this->redirect(array('action' => 'management_index'));

	}

	public function management_delete($id) {

		$this->Setting->id = $id;
		if (!$this->Setting->exists()) {
            throw new NotFoundException(__('Could not find a setting with that identifier'));

		}

		$is_root = $this->Setting->isRoot($id);

		if ($is_root) {

			throw new Exception(__('Cannot delete this setting'));

		}

		if($this->request->is('post')) {
			
			if ($this->Setting->delete()) {
				$this->Session->setFlash(__('The setting has been successfully deleted'));
			} else {
				$this->Session->setFlash(__('The setting has been successfully deleted'));
			}

		}

		$this->redirect(array('action' => 'management_index'));

	}

	private function saveData($data) {

		$this->Setting->save($data);

	} 

	public function beforeFilter() {

		parent::beforeFilter();

	}


}