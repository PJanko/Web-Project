<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

class MembersController extends AppController {

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(/*'login','register', 'socialLogin', 'logout'*/);
    }

	public function beforeRender() {
	    parent::beforeRender();
	}

	// Redirect to login
	public function index() {
		$this->redirect(array('action' => 'login'));
	}

	// Login a user
	public function login() {
		if ($this->request->is('post')) {
	        if ($this->Auth->login($this->request->data)) {
	            return $this->redirect($this->Auth->redirectUrl());
	        }
	        $this->Flash->error(__("L'email ou le mot de passe ne correspondent pas"));
	    }
	}

	// Logout
	public function logout() {       
		return $this->redirect($this->Auth->logout());
	}

	// Register a new user
	public function register() {
		if ($this->request->is('post')) {

			if($this->request->data['Member']['password'] != $this->request->data['Member']['confirm']) {
				$this->Flash->error(__('Les mots de passe ne correspondent pas'));
				return $this->redirect(array('action' => 'login'));
			}

            $this->Member->create();
            if ($this->Member->save($this->request->data)) {
                $this->Flash->success(__("L'utilisateur a été correctement enregistré !"));
                return $this->redirect(array('action' => 'login'));
            }
            $this->Flash->error(__("L'utilisateur n'a pas pu être enregistré, veuillez réessayer !"));
            return $this->redirect(array('action' => 'login'));
        }
	}
	
	public function account() {
		$user = $this->Member->find('first', array( 'conditions' => array('Member.username' => $this->Auth->user()['Member']['username'])));
		$this->set('userInfo', $user);
	}
	
	/*
	public function dateFrToUsa() {  
		$myinput='12/15/2005'; 
		$sqldate=date('Y-m-d',strtotime($myinput)); 
	}

	public function dateUsaToFr() {  
		$sqldate= $this->Member->find('first', array( 'conditions' => array('Member.naissance' => $this->Auth->user()['Member']['naissance'])));
		$myinput=date('d/m/Y',strtotime($sqldate)); 
	}	*/
	// Login with Facebook and Google
	public function socialLogin() {
	}

}


?>