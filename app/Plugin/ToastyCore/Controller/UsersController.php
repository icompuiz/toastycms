<?php
App::uses('ToastyCoreAppController', 'ToastyCore.Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends ToastyCoreAppController {

	public function management_index() {

	}

	public function management_view($id = null) {

	}

	public function management_edit($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;

            $user = $this->saveData($data, $id);

            if ($user) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'edit', $id, 'management' => true));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $user_data = $this->User->findById($id);

            $group = $this->User->Group->findById($user_data['Group']['id']);

            $property_skels = $group['UserPropertySkel'];

            $properties = array();
            foreach ($property_skels as $property_skel) {
                $skel = $this->User->Group->UserPropertySkel->findById($property_skel['id']);
                $properties[$property_skel['id']] = $skel;
            }

            foreach ($user_data['UserProperties'] as $property) {

                if (isset($properties[$property['user_property_skel_id']])) {

                    $properties[$property['user_property_skel_id']]['UserProperty'] = $property;
                }
            }

            unset($user_data['User']['password']);

            $user_data['User']['UserProperties'] = $properties;

            $this->request->data = $user_data;



        }

        $groups = $this->User->Group->find('list');

        $groups = $this->padArray($groups);


        $this->set(compact('groups'));
	}

	public function management_add($group_id = null ) {

		if (empty($group_id)) {

            $this->redirect(array('controller' => 'groups', 'action' => 'select', 'users', 'add', 'management' => true));
        }

        if (!$this->User->Group->exists($group_id)) {
            throw new NotFoundException(__('Invalid Group'));
        }

        if ($this->request->is('post')) { 
        	$data = $this->request->data;


            $user = $this->saveData($data);

            if ($user) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index', 'management' => true));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }

        $group = $this->User->Group->findById($group_id);
        $property_skels = $group['UserPropertySkel'];

        $properties = array();
        foreach ($property_skels as $property_skel) {
            $skel = $this->User->Group->UserPropertySkel->findById($property_skel['id']);
            $properties[$property_skel['id']] = $skel;
        }

        $user_data['Group'] = $group['Group'];
        $user_data['User']['group_id'] = $group['Group']['id'];

        $user_data['User']['UserProperties'] = $properties;

        $this->request->data = $user_data;

        $groups = $this->User->Group->find('list');

        $groups = $this->padArray($groups);


        $this->set(compact('groups'));

	}

	public function management_delete($id = null) {
		$this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
	}

	private function saveData($data) {


        $properties = isset($data['User']['UserProperties']) ? $data['User']['UserProperties'] : null;

        if (!empty($properties)) {
            unset($data['User']['UserProperties']);
        }

        if ('0' == $data['password_flag']) {

            unset($data['User']['password']);
            unset($data['User']['password_confirmation']);
        }

        $user = $this->User->save($data);
        if (!empty($user)) {

            foreach ($properties as $property) {

                $property['user_id'] = $user['User']['id'];
                $current['UserProperties'] = $property;

                $this->User->UserProperties->save($current);

            }

            return true;
        }
        return false;
    }

    public function management_login() {

        $this->layout = 'management_login';

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }

    }

    public function management_logout() {

        $this->layout = 'management_login';
        

        $this->Session->setFlash(__('You have been logged out, goodbye.'));

        $this->redirect($this->Auth->logout());

    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
