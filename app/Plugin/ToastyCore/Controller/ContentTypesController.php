<?php

App::uses('ToastyCoreAppController', 'ToastyCore.Controller');

/**
 * ContentTypes Controller
 *
 * @property ContentType $ContentType
 */
class ContentTypesController extends ToastyCoreAppController {

    public $components = array('RequestHandler');

    public function management_index() {

        $content_types = $this->ContentType->find('all');

        $organized = array();


        foreach ($content_types as $content_type) {

            if ($content_type['ParentContentType']['id'] === $content_type['ContentType']['id'] || $content_type['ContentType']['parent_content_type_id'] <= 0 || empty($content_type['ParentContentType'])) {

                $organized[] = $content_type;
            }
        }


        $this->set(array('content_types' => $organized));
    }

    public function management_add($parent_id = null) {


        if ($this->request->is('post')) {

            $data = $this->request->data;

            if ($this->ContentType->save($data)) {

                if (!empty($data['ContentTypePropertySkel'])) {
                    $properties = $data['ContentTypePropertySkel'];
                    unset($properties['modal']);
                    foreach ($properties as $property) {

                        $this->ContentType->ContentTypePropertySkel->create();
                        $property['content_type_id'] = $this->ContentType->id;

                        $this->ContentType->ContentTypePropertySkel->save($property);
                    }
                }

                $this->Session->setFlash(__('The content type has been saved'));
                $this->redirect(array('action' => 'edit', $this->ContentType->id));
            }
        }
        
        // if a parent_id is specified, set the starting parent id.
        if ($this->ContentType->exists($parent_id)) {
            $this->request->data['ContentType']['parent_content_type_id'] = $parent_id;
        }
        
        
        $inputFormats = $this->ContentType->ContentTypePropertySkel->OutputFormat->find('list', array('conditions' => array('OutputFormat.type' => '0')));
        $outputFormats = $this->ContentType->ContentTypePropertySkel->OutputFormat->find('list', array('conditions' => array('OutputFormat.type' => '1')));
        $contentTemplates = $this->ContentType->ContentTemplate->find('list');

        $inputFormats = $this->padArray($inputFormats);
        $outputFormats = $this->padArray($outputFormats);
        $contentTemplates = $this->padArray($contentTemplates);

        $parentContentTypes = $this->ContentType->ParentContentType->find('list');

        $parentContentTypes = $this->padArray($parentContentTypes);

        $this->set(compact('parentContentTypes', 'inputFormats', 'outputFormats', 'contentTemplates'));
    }

    public function management_view($id) {
        $content = $this->ContentType->findById($id);
        $this->set(array(
            'content_type' => $content,
        ));
    }

    public function management_edit($id) {

        if (!$this->ContentType->exists($id)) {

            throw new NotFoundException(__('Invalid content type'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;

            $deleted = array();
            if (!empty($data['ContentTypePropertySkel']['deleted'])) {
                $deleted = $data['ContentTypePropertySkel']['deleted'];
            }
            unset($data['ContentTypePropertySkel']['deleted']);

            if ($this->ContentType->save($data)) {
                if (!empty($data['ContentTypePropertySkel'])) {

                    $properties = $data['ContentTypePropertySkel'];

                    foreach ($properties as $property) {

                        if (empty($property['id'])) {
                            $this->ContentType->ContentTypePropertySkel->create();
                            $property['content_type_id'] = $id;
                        }

                        $this->ContentType->ContentTypePropertySkel->save($property);
                    }
                }

                foreach ($deleted as $key => $value) {

                    $this->ContentType->ContentTypePropertySkel->delete($value, true);
                }

                $this->Session->setFlash(__('The content type has been saved'));
                $this->redirect(array('action' => 'edit', $id));
            } else {
                $this->Session->setFlash(__('The content type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ContentType.' . $this->ContentType->primaryKey => $id));
            $this->request->data = $this->ContentType->find('first', $options);
            $options = array('conditions' => array('ContentTypePropertySkel.content_type_id' => $id));
            $properties = $this->ContentType->ContentTypePropertySkel->find('all', $options);

            $this->set(compact('contentTemplates', 'properties'));
        }

        $inputFormats = $this->ContentType->ContentTypePropertySkel->OutputFormat->find('list', array('conditions' => array('OutputFormat.type' => '0')));
        $outputFormats = $this->ContentType->ContentTypePropertySkel->OutputFormat->find('list', array('conditions' => array('OutputFormat.type' => '1')));
        $contentTemplates = $this->ContentType->ContentTemplate->find('list');

        $inputFormats = $this->padArray($inputFormats);
        $outputFormats = $this->padArray($outputFormats);
        $contentTemplates = $this->padArray($contentTemplates);

        $parentContentTypes = $this->ContentType->ParentContentType->find('list', array('conditions' => array('ParentContentType.id !=' => $id, 'id !=' => $id)));

        $parentContentTypes = $this->removeDescendants($parentContentTypes, $id);

        $parentContentTypes = $this->padArray($parentContentTypes);


        $this->set(compact('inputFormats', 'outputFormats', 'contentTemplates', 'parentContentTypes'));
    }

    private function removeDescendants($array, $id) {

        $copy = array();

        foreach ($array as $key => $value) {
            if (!$this->ContentType->isDescendant($id, $key)) {
                $copy[$key] = $value;
            }
        }

        return $copy;
    }

    public function management_delete($id = null) {

        $this->ContentType->id = $id;
        if (!$this->ContentType->exists()) {
            throw new NotFoundException(__('Invalid content type'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->ContentType->delete()) {
            $this->Session->setFlash(__('Content type deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Content type was not deleted. There may still be content associated with this type. Delete that content first then try again.'));
        $this->redirect(array('action' => 'edit', $id));
        exit;
    }

    public function management_select($content_parent_id = null) {

        if ($this->request->is('post')) {
            
        }
        
        $this->Session->setFlash(__('You must select a content type before adding new content'));
        $contentTypes = $this->ContentType->find('all');
        $this->set(compact('contentTypes', 'content_parent_id'));


        
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->ContentType->recursive = 0;
        $this->set('contentTypes', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->ContentType->exists($id)) {
            throw new NotFoundException(__('Invalid content type'));
        }
        $options = array('conditions' => array('ContentType.' . $this->ContentType->primaryKey => $id));
        $this->set('contentType', $this->ContentType->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->ContentType->create();
            if ($this->ContentType->save($this->request->data)) {
                $this->Session->setFlash(__('The content type has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The content type could not be saved. Please, try again.'));
            }
        }
        $contentTemplates = $this->ContentType->ContentTemplate->find('list');
        $parentContentTypes = $this->ContentType->ParentContentType->find('list');

        $this->set(compact('contentTemplates', 'parentContentTypes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->ContentType->exists($id)) {
            throw new NotFoundException(__('Invalid content type'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ContentType->save($this->request->data)) {
                $this->Session->setFlash(__('The content type has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The content type could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('ContentType.' . $this->ContentType->primaryKey => $id));
            $this->request->data = $this->ContentType->find('first', $options);
        }
        $contentTemplates = $this->ContentType->ContentTemplate->find('list');
        $parentContentTypes = $this->ContentType->ParentContentType->find('list');
        $this->set(compact('contentTemplates', 'parentContentTypes'));
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
        $this->ContentType->id = $id;
        if (!$this->ContentType->exists()) {
            throw new NotFoundException(__('Invalid content type'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->ContentType->delete()) {
            $this->Session->setFlash(__('Content type deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Content type was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
