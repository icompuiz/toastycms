<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends ToastyCoreAppController {

	public $components = array('RequestHandler');

	public function management_index() {

		$groups = $this->Group->find('all');
        $this->set(array('groups' => $groups));


	}

	public function management_view($id = null) {
		$group = $this->Group->findById($id);
        $this->set(array(
            'group' => $group,
        ));
	}

	public function management_edit($id = null) {

		// TODO - make sure if group is type 'root' the following fields may not be edited
		// - type
		// - status
		// - id

		if (!$this->Group->exists($id)) {

            throw new NotFoundException(__('Invalid group'));
        }

		if ( $this->request->is('post') || $this->request->is('put')) {

			if ($this->Group->isRoot($id)) {
				if(isset($data['Group']['type'])) {
					unset($data['Group']['type']);
				}
			}

			$data = $this->request->data;
	        $deleted = array();
	        if (!empty($data['UserPropertySkel']['deleted'])) {
	            $deleted = $data['UserPropertySkel']['deleted'];
	        }
	        
	        unset($data['UserPropertySkel']['deleted']);

            if ($this->Group->save($data)) {

				if (!empty($data['UserPropertySkel'])) {

	                $properties = $data['UserPropertySkel'];
	                foreach ($properties as $property) {

	                    if (empty($property['id'])) {
	                        $this->Group->UserPropertySkel->create();
	                        $property['group_id'] = $id;
	                    }

	                    $this->Group->UserPropertySkel->save($property);
	                }
	            }

	            foreach ($deleted as $key => $value) {

	                $this->Group->UserPropertySkel->delete($value, true);
	            }

	          	$this->Session->setFlash(__('The group has been saved'));
	            $this->redirect(array('action' => 'edit', $id));
            } else {
                $this->Session->setFlash(__('The content type could not be saved. Please, try again.'));
            }

		} else {
            $options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
            
            $this->request->data = $this->Group->find('first', $options);

            $options = array('conditions' => array('UserPropertySkel.group_id' => $id));

            $properties = $this->Group->UserPropertySkel->find('all', $options);

            $this->set(compact('properties'));
        }

		$inputFormats = $this->Group->UserPropertySkel->OutputFormat->find('list', array('conditions' => array('OutputFormat.type' => '0')));
        $outputFormats = $this->Group->UserPropertySkel->OutputFormat->find('list', array('conditions' => array('OutputFormat.type' => '1')));

        $inputFormats = $this->padArray($inputFormats);
        $outputFormats = $this->padArray($outputFormats);

        $this->set(compact('outputFormats', 'inputFormats'));

        

	}

	public function management_add() {

		// TODO - make sure 'type' field is not 'root' same for users

		if ( $this->request->is('post')) {

			$data = $this->request->data;

			if (isset($data['Group']['type'])) {
                if ($data['Group']['type'] === 'root') {
    				throw new Exception(__("Forbidden field value: 'type' => 'root' is not allowed"));
                }
			}

			if ($this->Group->save($data)) {

                if (!empty($data['UserPropertySkel'])) {
                    $properties = $data['UserPropertySkel'];
                    unset($properties['modal']);
                    foreach ($properties as $property) {

                        $this->Group->UserPropertySkel->create();
                        $property['group_id'] = $this->Group->id;

                        $this->Group->UserPropertySkel->save($property);
                    }
                }

                $this->Session->setFlash(__('The group has been saved'));
                $this->redirect(array('action' => 'edit', $this->Group->id));
            }

		}

		$inputFormats = $this->Group->UserPropertySkel->OutputFormat->find('list', array('conditions' => array('OutputFormat.type' => '0')));
        $outputFormats = $this->Group->UserPropertySkel->OutputFormat->find('list', array('conditions' => array('OutputFormat.type' => '1')));

        $inputFormats = $this->padArray($inputFormats);
        $outputFormats = $this->padArray($outputFormats);

        $this->set(compact('outputFormats', 'inputFormats'));


	}

	public function management_delete($id = null) {


		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}

		// TODO - make sure if group is type 'root' the group cannot be deleted
		// if ($this->Group->isRoot()) {
		// 	throw new Exception(__("Invalid operation: Group $id is a root group"));

		// }

		$this->request->onlyAllow('post', 'delete');
		if ($this->Group->delete()) {
			$this->Session->setFlash(__('Group deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Group was not deleted'));
		$this->redirect(array('action' => 'index'));
		
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Group->recursive = 0;
		$this->set('groups', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
		$this->set('group', $this->Group->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
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
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Invalid group'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__('The group has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid group'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Group->delete()) {
			$this->Session->setFlash(__('Group deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Group was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
