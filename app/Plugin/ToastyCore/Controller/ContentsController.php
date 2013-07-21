<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');

/**
 * Contents Controller
 *
 * @property Content $Content
 */
class ContentsController extends ToastyCoreAppController {

    public $components = array('RequestHandler');
    public $helpers = array('ToastyCore.Multifile', 'ToastyCore.Property', 'ToastyCore.Snippet');

    public function home() {

        $options = array(
            'conditions' => array(
                'Content.home_page' => true
            )
        );
        $content = $this->Content->find('first', $options);

        if (empty($content)) {

            $this->layout = 'blank';
        
        } else {
            $this->view($content['Content']['id'], $content);
        }

    }

    public function management_index() {

        $options = array(
            'order' => array(
                'Content.sort',
                'Content.created'
            )
        );
        $contents = $this->Content->find('all', $options);

        $organized = array();
        $root = array();

        foreach ($contents as $content) {

            if ($content['Content']['type'] === 'root') {
                $root[] = $content;
                continue;
            }

            if ($content['ParentContent']['id'] === $content['Content']['id'] || $content['Content']['parent_content_id'] <= 0 || empty($content['ParentContent'])) {

                $organized[] = $content;
            }
        }

        $organized = array_merge($organized, $root);
        $this->set(array('contents' => $organized));
    }

    public function management_view($id) {

        if (!$this->Content->exists($id)) {
            throw new NotFoundException(__('Invalid content'));
        }

        $content = $this->Content->findById($id);

        $ext = isset($this->request->params['ext']) ? $this->request->params['ext'] : null;
        if ($ext === 'json') {

            $this->set(array(
                'content' => $content,
            ));


        } else {
        

            $this->view($id, $content);
        }
    }

    public function management_add($content_type_id = null, $parent_content_id = null , $parent_id = null) {

        if (empty($content_type_id)) {

            $this->redirect(array('controller' => 'content_types', 'action' => 'select', 'contents', 'add', 'management' => true));
        }

        if (!$this->Content->ContentType->exists($content_type_id)) {
            throw new NotFoundException(__('Invalid Content Type'));
        }

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $content = $this->saveData($data);

            if ($content) {
                $this->Session->setFlash(__('The content has been saved'));
                $this->redirect(array('action' => 'edit', $content['Content']['id'], 'management' => true));
            } else {
                $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
            }
        }

        $content_type = $this->Content->ContentType->findById($content_type_id);

        $property_skels = $content_type['ContentTypePropertySkel'];

        $properties = array();
        foreach ($property_skels as $property_skel) {
            $skel = $this->Content->ContentType->ContentTypePropertySkel->findById($property_skel['id']);
            $properties[$property_skel['id']] = $skel;
        }

        $content_data = array();

        $content_data['ContentType'] = $content_type['ContentType'];
        $content_data['Content']['content_type_id'] = $content_type['ContentType']['id'];

        $content_data['Content']['user_id'] = $this->current_user['id'];

        $content_data['Content']['ContentTypeProperties'] = $properties;

        if (!empty($parent_content_id)) {
            $content_data['Content']['parent_content_id'] = $parent_content_id;
        }

        $this->request->data = $content_data;

        $parentContents = $this->Content->ParentContent->find('list');

        $parentContents = $this->padArray($parentContents);

        $this->set(compact('parentContents'));
    }

    public function management_edit($id = null) {

        if (!$this->Content->exists($id)) {
            throw new NotFoundException(__('Invalid content'));
        }

        if ($this->Content->isRoot($id)) {
                $this->redirect(array('controller' => 'dashboard', 'action' => 'index', 'management' => true));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $data = $this->request->data;


            $content = $this->saveData($data, $id);

            if ($content) {
                $this->Session->setFlash(__('The content has been saved'));
                $this->redirect(array('action' => 'edit', $id, 'management' => true));
            } else {
                $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
            }
        } else {

            $content_data = $this->Content->findById($id);

            $content_type = $this->Content->ContentType->findById($content_data['ContentType']['id']);

            $property_skels = $content_type['ContentTypePropertySkel'];

            $properties = array();
            foreach ($property_skels as $property_skel) {
                $skel = $this->Content->ContentType->ContentTypePropertySkel->findById($property_skel['id']);
                $properties[$property_skel['id']] = $skel;
            }


            foreach ($content_data['ContentTypeProperties'] as $property) {

                if (isset($properties[$property['content_type_property_skel_id']])) {


                    $decode_value = json_decode($property['value'], true);

                    if (null !== $decode_value) {
                        $property['value'] = $decode_value;
                    }


                    $properties[$property['content_type_property_skel_id']]['ContentTypeProperty'] = $property;
                }
            }


            $content_data['Content']['ContentTypeProperties'] = $properties;
            $this->request->data = $content_data;
        }

        $parentContents = $this->Content->ParentContent->find('list', array('conditions' => array('ParentContent.id !=' => $id, 'id !=' => $id)));

        $parentContents = $this->removeDescendants($parentContents, $id);

        $parentContents = $this->padArray($parentContents);

        $content_path = $this->Content->getPathFromId($id);


        $this->set(compact('parentContents', 'content_path'));
    }

    private function removeDescendants($array, $id) {

        $copy = array();

        $this->Content->id = $id;
        foreach ($array as $key => $value) {
            $item['parent_content_id'] = $key;
            if ($this->Content->isDescendant($item)) {
                $copy[$key] = $value;
            }
        }

        return $copy;
    }

    public function management_delete($id = null) {
        $this->Content->id = $id;
        if (!$this->Content->exists()) {
            throw new NotFoundException(__('Invalid content'));
        }

        $this->request->onlyAllow('post', 'delete');
        if ($this->Content->delete(null, true)) {
            $this->Session->setFlash(__('Content deleted'));
            $this->redirect(array('controller' => 'dashboard','action' => 'index'));
        }
        $this->Session->setFlash(__('Content was not deleted'));
        $this->redirect(array('controller' => 'dashboard','action' => 'index'));
    }

    

    private function saveData($data) {


        $properties = isset($data['Content']['ContentTypeProperties']) ? $data['Content']['ContentTypeProperties'] : null;

        if (!empty($properties)) {
            unset($data['Content']['ContentTypeProperties']);
        }
        if (isset($data['Content']['parent_content_id'])) {
            if (empty($data['Content']['parent_content_id'])) {
                $data['Content']['parent_content_id'] = 0;
            }
        }

        $content = $this->Content->save($data);
        if (!empty($content)) {

            foreach ($properties as $property) {

                $property['content_id'] = $content['Content']['id'];
                $current['ContentTypeProperties'] = $property;

                $this->Content->ContentTypeProperties->save($current);
            }


            return $content;
        }
        return false;
    }

    public function isAuthorized($user) {
        // All registered users can add posts
        if ($this->action === 'management_add') {
            return true;
        }

        // The owner of a post can edit and delete it
        if (in_array($this->action, array('management_edit', 'management_delete'))) {
            $postId = $this->request->params['pass'][0];
            if ($this->Content->isOwnedBy($postId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    /**
     * index method
     *
     * @return void
     */
    private function index() {
        $this->Content->recursive = 0;
        $this->set('contents', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null, $content = null) {

        $is_numeric = is_numeric($id);
        if (null === $content) {

            if (!$is_numeric) {

                $id = $this->Content->getIdFromPath($id);

            }

            if (!$this->Content->exists($id)) {
                throw new NotFoundException(__('Invalid content'));
            }

            $content = $this->Content->findById($id);

        }

        $published = $content['Content']['published'];

        if (isset($this->request->params['prefix'])) {
           $management = $this->request->params['prefix'] == 'management';
            $published = $management;
        }

        if (!$published) {
            
            $this->redirect("/404");

        } else {
        
            $content_path = $id;
            if (!$is_numeric) {
                $content_path = $this->Content->getPathFromId($id);
            }
    
            
            $template = $this->Content->ContentType->getTemplate($content['ContentType']['id']);
            $templateStack = $this->Content->ContentType->ContentTemplate->getTemplateStack($content['ContentType']['content_template_id']);
    
            // Layout is always the first element
            $path = $templateStack[0]['system_path'];
            $path = str_replace('.ctp', '', $path);
            $path = "../ContentTemplates/$path";
            
    
            $this->layout = $path;
    
    
    
            
            $path = $template['system_path'];
            $path = str_replace('.ctp', '', $path);
            $path = Inflector::underscore($path);
            $path = "$path";
    
    
            $this->plugin = false;
    
            $this->viewPath = "ContentTemplates";
            $this->viewClass = "ToastyCore.Content";
    
            $this->set(array(
                'content' => $content,
                'template' => $template,
                'content_path' => $content_path
            ));
    
            $properties = $content['ContentTypeProperties'];
    
            $values = array();
    
            foreach ($properties as $property) {
    
                $populatedProperty = $this->Content->ContentTypeProperties->findById($property['id']);
    
                $skel = $this->Content->ContentTypeProperties->ContentTypePropertySkel->findById($populatedProperty['ContentTypePropertySkel']['id']);
    
    
                $index = $skel['ContentTypePropertySkel']['name'];
                $indexUnderscore = Inflector::underscore($index);
    
                $indexUnderscore = preg_replace("~\W~", "_", $indexUnderscore);
    
                $values[$index] = array(
                    'ContentTypePropertySkel' => $skel['ContentTypePropertySkel'],
                    'OutputFormat' => $skel['OutputFormat'],
                    'ContentTypeProperty' => $property
                );
    
                $values[$indexUnderscore] = $values[$index];
    
    
            }
    
            // debug($values); exit;
    
            $this->set($values);
    
    
            $this->render($path);
        }
    }

    /**
     * add method
     *
     * @return void
     */
    private function add() {
        if ($this->request->is('post')) {
            $this->Content->create();
            if ($this->Content->save($this->request->data)) {
                $this->Session->setFlash(__('The content has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
            }
        }
        $users = $this->Content->User->find('list');
        $parentContents = $this->Content->ParentContent->find('list');
        $contentTypes = $this->Content->ContentType->find('list');

        $parentContents = $this->padArray($parentContents);
        $contentTypes = $this->padArray($contentTypes);

        $this->set(compact('users', 'parentContents', 'contentTypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    private function edit($id = null) {
        if (!$this->Content->exists($id)) {
            throw new NotFoundException(__('Invalid content'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Content->save($this->request->data)) {
                $this->Session->setFlash(__('The content has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The content could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Content.' . $this->Content->primaryKey => $id));
            $this->request->data = $this->Content->find('first', $options);
        }
        $users = $this->Content->User->find('list');
        $parentContents = $this->Content->ParentContent->find('list');
        $contentTypes = $this->Content->ContentType->find('list');

        $parentContents = $this->padArray($parentContents);
        $contentTypes = $this->padArray($contentTypes);

        $this->set(compact('users', 'parentContents', 'contentTypes'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    private function delete($id = null) {
        $this->Content->id = $id;
        if (!$this->Content->exists()) {
            throw new NotFoundException(__('Invalid content'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Content->delete()) {
            $this->Session->setFlash(__('Content deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Content was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Auth->allow('home');
    }

}
