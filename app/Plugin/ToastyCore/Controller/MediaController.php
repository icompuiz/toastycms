<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');

/**
 * Media Controller
 *
 * @property Media $Media
 */
class MediaController extends ToastyCoreAppController {

/**
 * management_index method
 *
 * @return void
 */
	public function management_index() {
		$this->Media->recursive = 0;
		$this->set('media', $this->paginate());
	}

/**
 * management_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function management_view($id = null) {
		if (!$this->Media->exists($id)) {
			throw new NotFoundException(__('Invalid media'));
		}
		$options = array('conditions' => array('Media.' . $this->Media->primaryKey => $id));
		$this->set('media', $this->Media->find('first', $options));
	}

/**
 * management_add method
 *
 * @return void
 */
	public function management_add($id = null) {

		if (!empty($id)) {
			$this->Media->MediaDirectory->id = $id;
			if (!$this->Media->MediaDirectory->exists()) {

				throw new NotFoundException(__('Cannot find the media directory specified'));

			}
		}

		if ($this->request->is('post')) {
			$this->Media->create();

			$data = $this->data;

			$media = $this->saveData($data);

			if ($media) {
				$this->Session->setFlash(__('The media has been saved'));
				$this->redirect(array('action' => 'edit', $media['Media']['id']));
			} else {
				$this->Session->setFlash(__('The media could not be saved. Please, try again.'));
			}
		}

		$data = array('Media' => array('media_directory_id' => $id));

		$this->data = $data;

		$mediaDirectories = $this->Media->MediaDirectory->find('list');
		$mediaDirectories = $this->padArray($mediaDirectories);
		$this->set(compact('mediaDirectories'));
	}

/**
 * management_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function management_edit($id = null) {

		if (!$this->Media->exists($id)) {
			throw new NotFoundException(__('Invalid media'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {

			$data = $this->data;



			$media = $this->saveData($data);

			if ($media) {
				$this->Session->setFlash(__('The media has been saved'));
				$this->redirect(array('action' => 'edit', $id));
				
			} else {
				$this->Session->setFlash(__('The media could not be saved. Please, try again.'));
			}
		} else {

			$options = array('conditions' => array('Media.' . $this->Media->primaryKey => $id));
			$data = $this->Media->find('first', $options);

			$data['Media']['previous_value'] = $data['Media']['system_path'];

			$this->request->data = $data;

		}


		$mediaDirectories = $this->Media->MediaDirectory->find('list');
		$mediaDirectories = $this->padArray($mediaDirectories);
		$this->set(compact('mediaDirectories'));
	}

	private function saveData($data) {


		if ($this->isFileValue($data['Media']['system_path'])) {

			$data['Media']['type'] = $data['Media']['system_path']['type'];

		}

		$media = $this->Media->save($data);		

		return $media;
	}

/**
 * management_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function management_delete($id = null) {
		$this->Media->id = $id;
		if (!$this->Media->exists()) {
			throw new NotFoundException(__('Invalid media'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Media->delete()) {
			$this->Session->setFlash(__('Media deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Media was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Media->recursive = 0;
		$this->set('media', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Media->exists($id)) {
			throw new NotFoundException(__('Invalid media'));
		}
		$options = array('conditions' => array('Media.' . $this->Media->primaryKey => $id));
		$this->set('media', $this->Media->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Media->create();
			if ($this->Media->save($this->request->data)) {
				$this->Session->setFlash(__('The media has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media could not be saved. Please, try again.'));
			}
		}
		$mediaDirectories = $this->Media->MediaDirectory->find('list');
		$this->set(compact('mediaDirectories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Media->exists($id)) {
			throw new NotFoundException(__('Invalid media'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Media->save($this->request->data)) {
				$this->Session->setFlash(__('The media has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Media.' . $this->Media->primaryKey => $id));
			$this->request->data = $this->Media->find('first', $options);
		}
		$mediaDirectories = $this->Media->MediaDirectory->find('list');
		$this->set(compact('mediaDirectories'));
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
		$this->Media->id = $id;
		if (!$this->Media->exists()) {
			throw new NotFoundException(__('Invalid media'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Media->delete()) {
			$this->Session->setFlash(__('Media deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Media was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function beforeFilter() {
		parent::beforeFilter();
	}

}
