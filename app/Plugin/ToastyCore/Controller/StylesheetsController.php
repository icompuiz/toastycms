<?php

App::uses("ToastyCoreAppController", "ToastyCore.Controller");

class StylesheetsController extends ToastyCoreAppController {

    public $components = array('RequestHandler');


	public function management_index() {

		$this->jsonRedirect();

		$stylesheets = $this->Stylesheet->find('all');

		$root = array(
			'Stylesheet' => array(
				'id' => '0',
				'name' => 'Stylesheet',
				'system_path' => 'Stylesheet',
				'type' => 'root'
			)
		);

        $root['Stylesheets'] = $stylesheets;

        // debug($root); exit;
        $this->set(array('stylesheets' => $root));

	}

	public function management_view($id = 0) {
		if ($id != 0) {
            throw new NotFoundException(__('Invalid stylesheet'));
        }

        $stylesheets = $this->Stylesheet->find('all');

		$root = array(
			'Stylesheet' => array(
				'id' => '0',
				'name' => 'Stylesheet',
				'system_path' => 'Stylesheet',
				'type' => 'root'
			)
		);

		$organized = array();

		foreach ($stylesheets as $ss) {
			$organized[] = $ss['Stylesheet'];
		}

        $root['Stylesheets'] = $organized;

        // debug($root); exit;
        $this->set(array('stylesheets' => $root));

	} 

	public function management_add() {

		if ($this->request->is('post')) {
			$this->Stylesheet->create();

			$data = $this->data;
			$stylesheet = $this->saveData($data);

			if ($stylesheet) {
				$this->Session->setFlash(__('The stylesheet has been saved'));
				$this->redirect(array('action' => 'edit', $stylesheet[$this->Stylesheet->alias]['id']));

			} else {
				$this->Session->setFlash(__('The stylesheet could not be saved. Please, try again.'));
			}
		}

	}

	public function management_edit($id = null) {

		$this->Stylesheet->id = $id;
		if (!$this->Stylesheet->exists()) {

			throw new NotFoundException(__('Cannot find the file specified'));

		}
        if ($this->request->is('post') || $this->request->is('put')) {

            $data = $this->request->data;

            $stylesheet = $this->saveData($data);

            if ($stylesheet) {
                $this->Session->setFlash(__('The stylesheet has been saved'));
                $this->redirect(array('action' => 'edit', $id));
            } else {
                $this->Session->setFlash(__('The stylesheet could not be saved. Please, try again.'));
            }
        } else {

            $options = array('conditions' => array('Stylesheet.' . $this->Stylesheet->primaryKey => $id));

            $data = $this->Stylesheet->find('first', $options);


            $content = $this->Stylesheet->readFile($id);

            $data['Stylesheet']['content'] = $content;

            $data['Stylesheet']['previous_path'] = $data['Stylesheet']['system_path'];
            $url = '/css/' . $data['Stylesheet']['system_path'];


            $this->request->data = $data;
            $this->set(compact('url'));
        }

	}

	private function saveData($data) {

		$data['Stylesheet']['type'] = 'text/css';

		$stylesheet = $this->Stylesheet->save($data);		

		return $stylesheet;
	}

	public function management_delete($id) {

		$this->Stylesheet->id = $id;

		if (!$this->Stylesheet->exists()) {

			throw new NotFoundException(__('Cannot find the file specified'));

		}

		$this->request->onlyAllow('post', 'delete');
        if ($this->Stylesheet->delete(null, true)) {
            $this->Session->setFlash(__('Stylesheet deleted'));
            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
        }
        $this->Session->setFlash(__('Stylesheet was not deleted'));
        $this->redirect(array('controller' => 'dashboard','action' => 'index'));

	}

	public function beforeFilter() {
		parent::beforeFilter();
	}

}

?>