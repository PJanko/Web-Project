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

class ApiController extends AppController {

	public $components = array('RequestHandler');
	public $uses = array('Device', 'Member', 'Workout', 'Log');

	public function beforeFilter() {
        parent::beforeFilter();
    }

	public function beforeRender() {
	    parent::beforeRender();
	    $this->RequestHandler->renderAs($this, 'json');
	}

	/** Register the object to connect to a user profile
	 * @param $s The serial number of the object
	 * @param $i The ID of the member to register to
	 * @param $d The description of the object
	 */
	public function registerobject($i=null, $s=null, $d=null) {
		
		if(isset($s) && isset($i) && isset($d)) {
			// Les variables sont toutes envoyées
			if(!ctype_space($d)) {
				// La description n'est pas vide
				// Check la base de donnée pour éviter les doublons
				$device = $this->Device->find('first', array('conditions' => array('Device.member_id' => $i, 'Device.serial' => $s)));
				if($device) {	// Device already exist
					$this->response->statusCode(409);	//Conflict
					return $this->set('_serialize', array()); // Nothing to serialize
				}
				$this->Device->create();
				$this->Device->save(array('member_id' => $i, 'serial' => $s, 'description' => $d, 'trusted' => 0));
				$this->response->statusCode(201); // Created
        		return $this->set('_serialize', array()); // Nothing to serialize
			} else {
				// Description vide on ne peut pas enregistrer l'objet
				$this->response->statusCode(417); 	// Expectation failed (malformed data)
        		return $this->set('_serialize', array()); // Nothing to serialize
			}
		} else {
			// Des informations sont manquantes
			$this->response->statusCode(400); 	// Bad request - missing arguments
        	return $this->set('_serialize', array()); // Nothing to serialize
		}
	}

	/**
	 * récupère les scores de la session $w en se déclarant comme l’objet $s
	 */
	public function sessionparameters($s=null, $w=null) {
		if(isset($s) && isset($w)) {

			$workout = $this->Workout->findById($w);
			$device = $this->Device->findBySerial($s);
			if($workout) $workout = $workout['Workout'];
			if($device) $device = $device['Device'];

			if($workout['member_id'] == $device['member_id']) {

				$log = $this->Log->find('first', array('conditions' => array('Log.workout_id' => $workout['id'], 'Log.device_id' => $device['id'])));
				if($log) $log = $log['Log'];

				if($log) {
					$this->response->statusCode(200);
					$this->set('type', $log['log_type']);
					$this->set('value', $log['log_value']);
					return $this->set('_serialize', array('type', 'value'));
				} else {
					$this->response->statusCode(404); // Not Found
        			return $this->set('_serialize', array()); // Nothing to serialize
				}
			} else {
				$this->response->statusCode(401); // Unauthorized
        		return $this->set('_serialize', array()); // Nothing to serialize
			}
		} else {
			// Des informations sont manquantes
			$this->response->statusCode(400); 	// Bad request - missing arguments
        	return $this->set('_serialize', array()); // Nothing to serialize
		}
	}

	public function getsummary() {

	}

	public function addlog() {

	}

}

?>