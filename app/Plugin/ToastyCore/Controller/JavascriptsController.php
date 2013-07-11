<?php

App::uses("ToastyCoreAppController", "ToastyCore.Controller");

class JavascriptsController extends ToastyCoreAppController {

    public $components = array('RequestHandler');


	public function management_index() {

		$this->jsonRedirect();
		

		$javascripts = $this->Javascript->find('all');

		$root = array(
			'Javascript' => array(
				'id' => '0',
				'name' => 'Javascript',
				'system_path' => 'Javascript',
				'type' => 'root'
			)
		);

        $root['Javascripts'] = $javascripts;

        // debug($root); exit;
        $this->set(array('javascripts' => $root));

	}

	public function management_view($id = 0) {
		if ($id != 0) {
            throw new NotFoundException(__('Invalid stylesheet'));
        }

        $stylesheets = $this->Javascript->find('all');

		$root = array(
			'Javascript' => array(
				'id' => '0',
				'name' => 'Javascript',
				'system_path' => 'Javascript',
				'type' => 'root'
			)
		);

		$organized = array();

		foreach ($stylesheets as $ss) {
			$organized[] = $ss['Javascript'];
		}

        $root['Javascripts'] = $organized;

        // debug($root); exit;
        $this->set(array('javascripts' => $root));

	} 

	public function management_add() {

		if ($this->request->is('post')) {
			$this->Javascript->create();

			$data = $this->data;
			$script = $this->saveData($data);

			if ($script) {
				$this->Session->setFlash(__('The script has been saved'));
				$this->redirect(array('action' => 'edit', $script[$this->Javascript->alias]['id']));

			} else {
				$this->Session->setFlash(__('The script could not be saved. Please, try again.'));
			}
		}

	}

	public function management_edit($id = null) {

		$this->Javascript->id = $id;
		if (!$this->Javascript->exists()) {

			throw new NotFoundException(__('Cannot find the file specified'));

		}
        if ($this->request->is('post') || $this->request->is('put')) {

            $data = $this->request->data;

            $script = $this->saveData($data);

            if ($script) {
                $this->Session->setFlash(__('The script has been saved'));
                $this->redirect(array('action' => 'edit', $id));
            } else {
                $this->Session->setFlash(__('The script could not be saved. Please, try again.'));
            }
        } else {

            $options = array('conditions' => array('Javascript.' . $this->Javascript->primaryKey => $id));

            $data = $this->Javascript->find('first', $options);


            $content = $this->Javascript->readFile($id);

            $data['Javascript']['content'] = $content;

            $data['Javascript']['previous_path'] = $data['Javascript']['system_path'];
            $url = '/js/' . $data['Javascript']['system_path'];

            $this->request->data = $data;

			$this->set(compact('url'));
        }

	}

	private function saveData($data) {

		$data['Javascript']['type'] = 'text/javascript';

		$script = $this->Javascript->save($data);		

		return $script;
	}

	public function management_delete($id) {

		$this->Javascript->id = $id;

		if (!$this->Javascript->exists()) {

			throw new NotFoundException(__('Cannot find the file specified'));

		}

		$this->request->onlyAllow('post', 'delete');
        if ($this->Javascript->delete(null, true)) {
            $this->Session->setFlash(__('Javascript deleted'));
            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
        }
        $this->Session->setFlash(__('Javascript was not deleted'));
        $this->redirect(array('controller' => 'dashboard','action' => 'index'));

	}

	public function beforeFilter() {
		parent::beforeFilter();
	}

}

?>