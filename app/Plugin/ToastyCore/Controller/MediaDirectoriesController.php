<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
/**
 * MediaDirectories Controller
 *
 * @property MediaDirectory $MediaDirectory
 */
class MediaDirectoriesController extends ToastyCoreAppController {

    public $components = array('RequestHandler');


/**
 * management_index method
 *
 * @return void
 */
	public function management_index() {

		$media_directories = $this->MediaDirectory->find('all');

		$media_options = array(
			'conditions' => array('ChildMedia.media_directory_id' => 'null')
		);
		$root_media = $this->MediaDirectory->ChildMedia->find('all', $media_options);

		$root = array(
			'MediaDirectory' => array(
				'id' => '0',
				'name' => 'Media',
				'system_path' => 'Media',
				'type' => 'root_directory' 
			),
			'ChildMedia' => array(),
			'ChildMediaDirectory' => array()
		);

		// debug($root_media); exit;

        $organized = array();

        foreach ($media_directories as $media_directory) {

            if ($media_directory['ParentMediaDirectory']['id'] === $media_directory['MediaDirectory']['id'] || $media_directory['MediaDirectory']['parent_media_directory_id'] <= 0 || empty($media_directory['ParentMediaDirectory'])) {

                $organized[] = $media_directory;
            }
        }

        $root['ChildMedia'] = $root_media;
        $root['ChildMediaDirectory'] = $organized;

        // debug($root); exit;

        $this->set(array('media_directories' => $root));
	}

/**
 * management_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function management_view($id = null) {

		if ('0' === $id) {

			$media_directory_options = array(
				'conditions' => array('MediaDirectory.parent_media_directory_id' => 'null')
			);

			$root_media_directories = $this->MediaDirectory->find('all', $media_directory_options);

			$media_options = array(
				'conditions' => array('ChildMedia.media_directory_id' => 'null')
			);
			$root_media = $this->MediaDirectory->ChildMedia->find('all', $media_options);

			foreach ($root_media as &$item) {
				$item = $item['ChildMedia'];
			}

			foreach ($root_media_directories as &$item) {
				$item = $item['MediaDirectory'];
			}

			$root = array(
				'MediaDirectory' => array(
					'id' => '0',
					'name' => 'Media',
					'system_path' => 'Media',
					'type' => 'root_directory' 
				),
				'ChildMedia' => array(),
				'ChildMediaDirectory' => array()
			);

			$root['ChildMedia'] = $root_media;
       		 $root['ChildMediaDirectory'] = $root_media_directories;



			$media_directory = $root;


		} elseif (!$this->MediaDirectory->exists($id)) {
			throw new NotFoundException(__('Invalid media directory'));
		} else {

			$media_directory = $this->MediaDirectory->findById($id);
		}

		// debug($media_directory); exit;

        $ext = isset($this->request->params['ext']) ? $this->request->params['ext'] : null;
        if ($ext === 'json') {

            $this->set(array(
                'media_directory' => $media_directory,
            ));


        } else {

			$options = array('conditions' => array('MediaDirectory.' . $this->MediaDirectory->primaryKey => $id));
			$this->set('mediaDirectory', $this->MediaDirectory->find('first', $options));

		}
	}

/**
 * management_add method
 *
 * @return void
 */
	public function management_add($id = null) {

		if (!empty($id)) {
		
			$this->MediaDirectory->id = $id;
			if (!$this->MediaDirectory->exists()) {

				throw new NotFoundException(__('Invalid media directory'));

			}
		}

		if ($this->request->is('post')) {

			$data = $this->data;

			$this->MediaDirectory->create();

			$md = $this->saveData($data);
			if ($md) {
				$this->Session->setFlash(__('The media directory has been saved'));
				$this->redirect(array('action' => 'edit', $md['MediaDirectory']['id']));
			} else {
				$this->Session->setFlash(__('The media directory could not be saved. Please, try again.'));
			}
		}

		$data = array('MediaDirectory' => array('parent_media_directory_id' => $id));

		$this->data = $data;

		$parentMediaDirectories = $this->MediaDirectory->ParentMediaDirectory->find('list');
		$parentMediaDirectories = $this->padArray($parentMediaDirectories);

		$this->set(compact('parentMediaDirectories'));
	}

/**
 * management_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function management_edit($id = null) {
		if (!$this->MediaDirectory->exists($id)) {
			throw new NotFoundException(__('Invalid media directory'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$data = $this->data;


			$md = $this->saveData($data);

			if ($md) {
				$this->Session->setFlash(__('The media directory has been saved'));
				$this->redirect(array('action' => 'edit', $id));
				
			} else {
				$this->Session->setFlash(__('The media directory could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('MediaDirectory.' . $this->MediaDirectory->primaryKey => $id));
			$data = $this->MediaDirectory->find('first', $options);

			$data['MediaDirectory']['previous_value'] = $data['MediaDirectory']['system_path'];

			$this->request->data = $data;
		}

		$options = array('conditions' => array($this->MediaDirectory->primaryKey . " !=" => $id));
		$parentMediaDirectories = $this->MediaDirectory->ParentMediaDirectory->find('list', $options);

        $parentMediaDirectories = $this->removeDescendants($parentMediaDirectories, $id);

		$parentMediaDirectories = $this->padArray($parentMediaDirectories);

		$this->set(compact('parentMediaDirectories'));
	}

	private function removeDescendants($array, $id) {

        $copy = array();

        // $this->MediaDirectory->id = $id;
        foreach ($array as $key => $value) {
            $item['parent_media_directory_id'] = $key;
            if (!$this->MediaDirectory->isDescendant($id, $key)) {
                $copy[$key] = $value;
                // debug($value);
            }
        }
        return $copy;
    }

	private function saveData($data) {

		$data['MediaDirectory']['type'] = 'directory';

		$media = $this->MediaDirectory->save($data);		

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
		$this->MediaDirectory->id = $id;
		if (!$this->MediaDirectory->exists()) {
			throw new NotFoundException(__('Invalid media directory'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MediaDirectory->delete()) {
			$this->Session->setFlash(__('Media directory deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Media directory was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->MediaDirectory->recursive = 0;
		$this->set('mediaDirectories', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MediaDirectory->exists($id)) {
			throw new NotFoundException(__('Invalid media directory'));
		}
		$options = array('conditions' => array('MediaDirectory.' . $this->MediaDirectory->primaryKey => $id));
		$this->set('mediaDirectory', $this->MediaDirectory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MediaDirectory->create();
			if ($this->MediaDirectory->save($this->request->data)) {
				$this->Session->setFlash(__('The media directory has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media directory could not be saved. Please, try again.'));
			}
		}
		$parentMediaDirectories = $this->MediaDirectory->ParentMediaDirectory->find('list');
		$this->set(compact('parentMediaDirectories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->MediaDirectory->exists($id)) {
			throw new NotFoundException(__('Invalid media directory'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MediaDirectory->save($this->request->data)) {
				$this->Session->setFlash(__('The media directory has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The media directory could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('MediaDirectory.' . $this->MediaDirectory->primaryKey => $id));
			$this->request->data = $this->MediaDirectory->find('first', $options);
		}
		$parentMediaDirectories = $this->MediaDirectory->ParentMediaDirectory->find('list');
		$this->set(compact('parentMediaDirectories'));
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
		$this->MediaDirectory->id = $id;
		if (!$this->MediaDirectory->exists()) {
			throw new NotFoundException(__('Invalid media directory'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MediaDirectory->delete()) {
			$this->Session->setFlash(__('Media directory deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Media directory was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function beforeFilter() {
		parent::beforeFilter();
	}

}
