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

	var $uses = array('Member','SocialProfile');

	public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('login','register', 'social_login','social_endpoint');
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
	        if ($this->Auth->login()) {
	            return $this->redirect($this->Auth->redirectUrl());
	        }
	        $this->Flash->error(__("L'email ou le mot de passe ne correspondent pas"));
	    }
	}

	// Logout
	public function logout() {
		$this->Hybridauth->logout();
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
		$user = $this->Member->find('first', array( 'conditions' => array('Member.email' => $this->Auth->user()['Member']['email'])));
		$this->set('userInfo', $user);
	}
	
	/** 
	 *	Code from http://miftyisbored.com/complete-social-login-application-tutorial-cakephp-2-3-twitter-facebook-google/
	 */

	// Login with Facebook and Google
	public function social_login($provider) {
	    if( $this->Hybridauth->connect($provider) ){
	        $this->_successfulHybridauth($provider,$this->Hybridauth->user_profile);
	        $this->redirect($this->Auth->loginRedirect);
	    } else {
	        // error
	        $this->Flash->error($this->Hybridauth->error);
	        $this->redirect($this->Auth->loginAction);
	    }
	}

	private function _successfulHybridauth($provider, $incomingProfile){
    	// #1 - check if user already authenticated using this provider before
	    $this->SocialProfile->recursive = -1;
	    $existingProfile = $this->SocialProfile->find('first', array(
	        'conditions' => array('social_network_id' => $incomingProfile['SocialProfile']['social_network_id'], 'social_network_name' => $provider)
	    ));
	     
	    if ($existingProfile) {
	        // #2 - if an existing profile is available, then we set the user as connected and log them in
	        $user = $this->Member->find('first', array(
	            'conditions' => array('id' => $existingProfile['SocialProfile']['user_id'])
	        ));
	         
	        $this->_doSocialLogin($user,true);
	    } else {
	         
	        // New profile.
	        if ($this->Auth->loggedIn()) {
	            // user is already logged-in , attach profile to logged in user.
	            // create social profile linked to current user
	            $incomingProfile['SocialProfile']['user_id'] = $this->Auth->user('id');
	            $this->SocialProfile->save($incomingProfile);
	             
	            $this->Flash->success('Your ' . $incomingProfile['SocialProfile']['social_network_name'] . ' account is now linked to your account.');
	            $this->redirect($this->Auth->redirectUrl());
	 
	        } else {
	            // no-one logged and no profile, must be a registration.
	            $user = $this->Member->createFromSocialProfile($incomingProfile);
	            $incomingProfile['SocialProfile']['user_id'] = $user['Member']['id'];
	            $this->SocialProfile->save($incomingProfile);
	 
	            // log in with the newly created user
	            $this->_doSocialLogin($user);
	        }
	    }   
	}

	private function _doSocialLogin($user, $returning = false) {
	    if ($this->Auth->login($user)) {
	        if($returning){
	            $this->Flash->success(__('Bienvenue, '. $this->Auth->user('username')));
	        } else {
	            $this->Flash->success(__('Bienvenue chez Sport Manager, '. $this->Auth->user('username')));
	        }
	        $this->redirect($this->Auth->loginRedirect);
	         
	    } else {
	        $this->Flash->error(__('Erreur inconnue, impossible de vérifier : '. $this->Auth->user('username')));
	    }
	}

	public function social_endpoint() {
	    $this->Hybridauth->processEndpoint();
	}

}


?>