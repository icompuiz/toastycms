<?php

App::uses('AppController', 'Controller');
App::uses('User', 'ToastyCore.Model');
App::uses('Setting', 'ToastyCore.Model');

class ToastyCoreAppController extends AppController {

    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'main', 'management' => true, 'plugin' => 'toasty_core'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login', 'management' => true, 'plugin' => 'toasty_core')
        )
    );
    
    protected function padArray($array) {
        
        $newArray[0] = "";
        
        foreach ($array as $key => $value) {
            
            $newArray[$key] = $value;
            
        }
                
        return $newArray;
        
    }

    public function beforeFilter() {

        parent::beforeFilter();

        $salt = Configure::read("Security.salt");
        $seed = Configure::read("Security.cipherSeed");
        $user = new User();
        $root_password = $user->find('list', array('conditions' => array('User.id' => 1, 'User.password' => ''), 'fields' => 'username'));

        if (empty($salt) || empty($seed)) {

            pr("Security.salt or Security.cipherSeed values not set in app/Config/core.security.php");
            pr("Auth is disabled until these values are set.");

            $this->Components->unload('Auth');

            pr("This message will not dissapear until those values are set");
            
        } elseif (!empty($root_password)) {

            $root_edit_url = Router::url(array('controller' => 'users','action' => 'edit', 1, 'management' => true));

            pr("Root password is not set");
            pr("Auth is disabled until these values are set.");
            pr("<a href=\"$root_edit_url\">Set root password</a>");

            $this->Components->unload('Auth');

        }
        
        $prefix = "";
        if (isset($this->request->params['prefix'])) {
            $prefix = $this->request->params['prefix'];
        }

        if ("management" === $prefix) {
            $this->layout = 'ToastyCore.management';
        } else {

            $this->layout = 'ToastyCore.default';
        }
        
        $siteBaseUrl = Router::url('/', array('full' => true));
        $cmsRoot = "toasty2";
        $coreRoot = "toasty_core";
                


        $sessionActive = null !== $this->Auth->user();

        if ($sessionActive) {
            $this->current_user = $this->Auth->user();

            // debug($this->current_user); exit;
            $this->set(array('current_user' => $this->current_user));
        }


        $setting = new Setting();
        $setting = $setting->findByName("site_name");
        $site_name = $setting['Setting']['value'];

        $this->set(compact('prefix', 'cmsRoot', 'coreRoot', 'siteBaseUrl', 'sessionActive', 'site_name'));
        
        $this->Auth->allow('view');



    }

    protected function valueEmpty($value = null) {

        if (empty($value)) {
            return true;
        } elseif (isset($value['error'])) {
            return $value['error'] == 4;
        }
    }

    protected function isFileValue($value = null) {
        if ($value) {

            if (is_array($value) && isset($value['error']) && ($value['error'] != 4)) {

                return true;
            }
        }

        return false;
    }

    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['type']) && $user['type'] === 'root') {
            return true;
        }

        // Default deny
        return false;
    }

    public function jsonRedirect() {
        if (isset($this->request->params)) {
            $ext = $this->request->params['ext'];

            if ($ext !== 'json') {
                
                $this->redirect(array('controller' => 'dashboard', 'action' => 'index'));

            }
        }
    }

    

}

?>
