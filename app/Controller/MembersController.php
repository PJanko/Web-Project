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
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class MembersController extends AppController {

	var $uses = array('Member');

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'login','register', 'social_login','social_endpoint');
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
	            return $this->redirect($this->Auth->loginRedirect);
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
		$user = $this->Auth->user();
		$user['image'] = $this->Member->createImagePath($user['id']);
		$this->set('userInfo', $user);
	}
	
	public function changeprofil() { 
		$user = $this->Auth->user();
		if ($this->request->is('post')) {
			$filename = $this->Member->createImageAbsPath($user['id']);
			if (move_uploaded_file($this->data['Member']['image']['tmp_name'],$filename)) {
				$this->Flash->success(__("Votre photo de profil est mise à jour !"));
			} else $this->Flash->success(__("Votre photo de profil est mise à jour !"));
		}
		$this->redirect(array('action' => 'account'));
	}
	
	public function changepassword() {
		//Accès aux infos liés à l'ID	
		$user = $this->Member->findByEmail($this->Auth->user()['email']);
		
		//Récupération du mot de passe hashé dans la BDD
		$storedHash = $user['Member']['password'];
		
					
		//Hashage de l'ancien mot de passe saisie par l'utilisation
		$newHash = Security::hash($this->request->data['Member']['old_password'], 'blowfish', $storedHash);
		
		//Tronquage du hashage au 45 premiers caractères
		//$oldpass45 = substr ($newHash , 0, 45);
		
		//Création variable correct pour vérifier si le mot de passe saisie correspond à celui dans la base de données
		// $correct = $storedHash == $oldpass45;	
		
		if ($storedHash == $newHash) {
			//Vérification que la saisie du nouveau mot de passe et de sa confirmation
			if ($this->request->data['Member']['new_password'] == $this->request->data['Member']['confirm_password']){
				//Récupération du nouveau mot de passe saisie par l'utilisateur
				$user['Member']['password'] = $this->request->data['Member']['new_password'];
				
				//Enregistrer member avec new_password
				
				//$this->Member->saveField($this->request->data['Member']['password'], $password_bdd['Member']['password']);
				
				$this->Member->save($user);
						
				
				//Remplacer le password de la BDD par le new_password hashé
				$this->Flash->success(__('Mot de passe modifié'));
				return $this->redirect(array('action' => 'account'));
			}
			
			else {
				$this->Flash->error(__('Les mots de passe ne correspondent pas'));
				return $this->redirect(array('action' => 'account'));
			}
		}
		else {
			$this->Flash->error(__('Le mot de passe saisie ne correspond pas à votre ancien mot de passe'));
			return $this->redirect(array('action' => 'account'));
		}
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

		$existingProfile = $this->Member->find('first', array(
	        'conditions' => array('email' => $incomingProfile['SocialProfile']['email']) ));

	     
	    if ($existingProfile) {
	        // #2 - if an existing profile is available, then we set the user as connected and log them in
	        $user = array('id' => $existingProfile['Member']['id'], 'email' => $existingProfile['Member']['email']);
	        $this->_doSocialLogin($user,true);
	    } else {
            // no-one logged and no profile, must be a registration.
            $user = $this->Member->createFromSocialProfile($incomingProfile);
            //$incomingProfile['SocialProfile']['user_id'] = $user['Member']['id'];
            $this->Member->getImageFromURL($incomingProfile['SocialProfile']['picture'], $user['id']);
 
            // log in with the newly created user
            $this->_doSocialLogin($user);
	    }   
	}

	private function _doSocialLogin($user, $returning = false) {
	    if ($this->Auth->login($user)) {
	        if($returning){
	            $this->Flash->success(__('Bienvenue, '. $this->Auth->user('email')));
	        } else {
	            $this->Flash->success(__('Bienvenue chez Sport Manager, '. $this->Auth->user('email')));
	        }
	        $this->redirect($this->Auth->loginRedirect);
	         
	    } else {
	        $this->Flash->error(__('Erreur inconnue, impossible de vérifier : '. $this->Auth->user('email')));
	    }
	}

	public function social_endpoint() {
	    $this->Hybridauth->processEndpoint();
	}

}


?>