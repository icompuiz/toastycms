<?php

App::uses("ToastyCoreAppController", "ToastyCore.Controller");

class SnippetsController extends ToastyCoreAppController {

    public $components = array('RequestHandler');


	public function management_index() {

		$this->jsonRedirect();
		

		$snippets = $this->Snippet->find('all');

		$root = array(
			'Snippet' => array(
				'id' => '0',
				'name' => 'Snippet',
				'system_path' => 'Snippet',
				'type' => 'root'
			)
		);

        $root['Snippets'] = $snippets;

        // debug($root); exit;
        $this->set(array('snippets' => $root));

	}

	public function management_view($id = 0) {
		if ($id != 0) {
            throw new NotFoundException(__('Invalid snippet'));
        }

        $snippets = $this->Snippet->find('all');

		$root = array(
			'Snippet' => array(
				'id' => '0',
				'name' => 'Snippet',
				'system_path' => 'Snippet',
				'type' => 'root'
			)
		);

		$organized = array();

		foreach ($snippets as $ss) {
			$organized[] = $ss['Snippet'];
		}

        $root['Snippets'] = $organized;

        // debug($root); exit;
        $this->set(array('snippets' => $root));

	} 

	public function management_add() {

		if ($this->request->is('post')) {
			$this->Snippet->create();

			$data = $this->data;
			$snippet = $this->saveData($data);

			if ($snippet) {
				$this->Session->setFlash(__('The snippet has been saved'));
				$this->redirect(array('action' => 'edit', $snippet[$this->Snippet->alias]['id']));

			} else {
				$this->Session->setFlash(__('The snippet could not be saved. Please, try again.'));
			}
		}

	}

	public function management_edit($id = null) {

		$this->Snippet->id = $id;
		if (!$this->Snippet->exists()) {

			throw new NotFoundException(__('Cannot find the file specified'));

		}
        if ($this->request->is('post') || $this->request->is('put')) {

            $data = $this->request->data;

            $snippet = $this->saveData($data);

            if ($snippet) {
                $this->Session->setFlash(__('The snippet has been saved'));
                $this->redirect(array('action' => 'edit', $id));
            } else {
                $this->Session->setFlash(__('The snippet could not be saved. Please, try again.'));
            }
        } else {

            $options = array('conditions' => array('Snippet.' . $this->Snippet->primaryKey => $id));

            $data = $this->Snippet->find('first', $options);


            $content = $this->Snippet->readFile($id);

            $data['Snippet']['content'] = $content;

            $data['Snippet']['previous_path'] = $data['Snippet']['system_path'];

            $this->request->data = $data;
        }

	}

	private function saveData($data) {

		$data['Snippet']['type'] = 'application/x-httpd-php';

		$snippet = $this->Snippet->save($data);		

		return $snippet;
	}

	public function management_delete($id) {

		$this->Snippet->id = $id;

		if (!$this->Snippet->exists()) {

			throw new NotFoundException(__('Cannot find the file specified'));

		}

		$this->request->onlyAllow('post', 'delete');
        if ($this->Snippet->delete(null, true)) {
            $this->Session->setFlash(__('Snippet deleted'));
            $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));
        }
        $this->Session->setFlash(__('Snippet was not deleted'));
        $this->redirect(array('controller' => 'dashboard','action' => 'index'));

	}

	public function beforeFilter() {
		parent::beforeFilter();
	}

}

?>