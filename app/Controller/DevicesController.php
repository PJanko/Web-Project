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

class DevicesController extends AppController {

	var $uses = array('Device', 'Member');

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny();
    }

	public function beforeRender() {
	    parent::beforeRender();
	}

	// Redirect to login
	public function index() {
		
		// Get the list of devices that match the owner ID
		$trusted = $this->Device->find('all', array('conditions' => array('Device.member_id' => $this->Auth->user('id'), 'Device.trusted' => 1)));
		$untrusted = $this->Device->find('all', array('conditions' => array('Device.member_id' => $this->Auth->user('id'), 'Device.trusted' => 0)));

		$this->set('trusted', $trusted);
		$this->set('untrusted', $untrusted);
	}

	public function allow($id) {

		$device = $this->Device->findById($id);
		
		if(!empty($device)) $device = $device['Device'];

		if($device['member_id'] == $this->Auth->user('id')) {
			$this->Device->id = $id;
			$this->Device->saveField('trusted', 1);
			$this->Flash->success(__("L'objet \"".$device['description']."\" peut désormais accéder à votre compte."));
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Flash->error(__('Erreur, vous ne possédez pas cet objet !'));
			return $this->redirect(array('action' => 'index'));
		}
	}

	public function delete($id) {

		$device = $this->Device->findById($id)['Device'];

		if($device['member_id'] == $this->Auth->user('id')) {
			$this->Device->delete($id);
			$this->Flash->success(__("L'objet \"".$device['description']."\" a été correctement supprimé de votre liste !"));
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Flash->error(__('Erreur, vous ne possédez pas cet objet !'));
			return $this->redirect(array('action' => 'index'));
		}
	}
	
	public function deny($id) {

		$device = $this->Device->findById($id);

		if(!empty($device)) $device = $device['Device'];

		if($device['member_id'] == $this->Auth->user('id')) {
			$this->Device->id = $id;
			$this->Device->saveField('trusted', 0);
			$this->Flash->success(__("L'objet \"".$device['description']."\" ne peut plus accéder à votre compte."));
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->Flash->error(__('Erreur, vous ne possédez pas cet objet !'));
			return $this->redirect(array('action' => 'index'));
		}
	}

}

?>