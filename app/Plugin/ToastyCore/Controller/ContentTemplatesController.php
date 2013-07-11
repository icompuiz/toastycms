<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');

/**
 * ContentTemplates Controller
 *
 * @property ContentTemplate $ContentTemplate
 */
class ContentTemplatesController extends ToastyCoreAppController {

    public $components = array('RequestHandler');

    public function management_index() {
        $content_templates = $this->ContentTemplate->find('all');

        $organized = array();

        foreach ($content_templates as $content_template) {

            if ($content_template['ParentContentTemplate']['id'] === $content_template['ContentTemplate']['id'] || $content_template['ContentTemplate']['parent_content_template_id'] <= 0 || empty($content_template['ParentContentTemplate'])) {

                $organized[] = $content_template;
            }
        }

        $this->set(array('content_templates' => $organized));
    }
    
    public function management_view($id) {
        $content = $this->ContentTemplate->findById($id);
        $this->set(array(
            'content_template' => $content,
        ));
    }

    public function management_add($parent_id = null) {

        if ($this->request->is('post')) {

            $data = $this->request->data;

            $this->ContentTemplate->create();

            $contentTemplate = $this->saveData($data);
            if ($contentTemplate) {
                $this->Session->setFlash(__('The content template has been saved'));
                $this->redirect(array('action' => 'edit', $this->ContentTemplate->id));
            } else {
                $this->Session->setFlash(__('The content template could not be saved. Please, try again.'));
            }
        }
        
        
        if ($this->ContentTemplate->exists($parent_id)) {
            $this->request->data['ContentTemplate']['parent_content_template_id'] = $parent_id;
        }


        $parentContentTemplates = $this->ContentTemplate->ParentContentTemplate->find('list');
        $parentContentTemplates = $this->padArray($parentContentTemplates);

        $this->set(compact('parentContentTemplates'));
    }

    public function management_edit($id) {

        if (!$this->ContentTemplate->exists($id)) {
            throw new NotFoundException(__('Content Template not found'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            $data = $this->request->data;
            $contentTemplate = $this->saveData($data);

            if ($contentTemplate) {
                $this->Session->setFlash(__('The content template has been saved'));
                $this->redirect(array('action' => 'edit', $id));
            } else {
                $this->Session->setFlash(__('The content template could not be saved. Please, try again.'));
            }
        } else {

            $options = array('conditions' => array('ContentTemplate.' . $this->ContentTemplate->primaryKey => $id));


            $this->request->data = $this->ContentTemplate->find('first', $options);
            $this->request->data['ContentTemplate']['content'] = $this->ContentTemplate->readFile($id);
        }
        $parentContentTemplates = $this->ContentTemplate->ParentContentTemplate->find('list',  array('conditions' => array('ParentContentTemplate.id !=' => $id, 'id !=' => $id)));
        $parentContentTemplates = $this->removeDescendants($parentContentTemplates, $id);
        $parentContentTemplates = $this->padArray($parentContentTemplates);

        $this->set(compact('parentContentTemplates'));
    }
    
    private function removeDescendants($array, $id) {

        $copy = array();

        foreach ($array as $key => $value) {
            if (!$this->ContentTemplate->isDescendant($id, $key)) {
                $copy[$key] = $value;
            }
        }

        return $copy;
    }

    public function management_delete($id) {
        $this->ContentTemplate->id = $id;
        if (!$this->ContentTemplate->exists()) {
            throw new NotFoundException(__('Invalid content template'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->ContentTemplate->delete()) {
            $this->Session->setFlash(__('Content template deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Content template was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    private function saveData($data) {

        $contentTemplate = $this->ContentTemplate->save($data);

        if (!empty($contentTemplate)) {
            return true;
        }
        return false;
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->ContentTemplate->recursive = 0;
        $this->set('contentTemplates', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->ContentTemplate->exists($id)) {
            throw new NotFoundException(__('Invalid content template'));
        }
        $options = array('conditions' => array('ContentTemplate.' . $this->ContentTemplate->primaryKey => $id));
        $this->set('contentTemplate', $this->ContentTemplate->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->ContentTemplate->create();
            if ($this->ContentTemplate->save($this->request->data)) {
                $this->Session->setFlash(__('The content template has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The content template could not be saved. Please, try again.'));
            }
        }
        $parentContentTemplates = $this->ContentTemplate->ParentContentTemplate->find('list');
        $this->set(compact('parentContentTemplates'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->ContentTemplate->exists($id)) {
            throw new NotFoundException(__('Invalid content template'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ContentTemplate->save($this->request->data)) {
                $this->Session->setFlash(__('The content template has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The content template could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ContentTemplate.' . $this->ContentTemplate->primaryKey => $id));
            $this->request->data = $this->ContentTemplate->find('first', $options);
        }
        $parentContentTemplates = $this->ContentTemplate->ParentContentTemplate->find('list');
        $this->set(compact('parentContentTemplates'));
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
        $this->ContentTemplate->id = $id;
        if (!$this->ContentTemplate->exists()) {
            throw new NotFoundException(__('Invalid content template'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->ContentTemplate->delete()) {
            $this->Session->setFlash(__('Content template deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Content template was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
