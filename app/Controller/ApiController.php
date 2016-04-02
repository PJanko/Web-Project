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
        $this->Auth->allow();
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

			if($workout['member_id'] == $device['member_id'] && $device['trusted'] == 1) {

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

	/**
	 *	Récupérer les dernières notes de séance (3 dernières)
	 */
	public function getsummary($s=null) {
		$qLast = "SELECT * FROM workouts WHERE date < NOW() ORDER BY date DESC LIMIT 3";
		$qNext = "SELECT * FROM workouts WHERE date > NOW() ORDER BY date ASC LIMIT 1";

		if(isset($s)) {
			$last = $this->Workout->query($qLast);
			$next = $this->Workout->query($qNext);

			if($last) {
				// Format the ouput
				$obj = array('past' => array(), 'coming' => array());
				foreach($last as $workout) {
					$desc = array(
						"location" => $workout['workouts']['location_name'], 
						"description" => $workout['workouts']['description'],
						"sport" => $workout['workouts']['sport'],
						"date" => $workout['workouts']['date']);
					array_push($obj['past'], $desc);
				}
				if($next) {
					foreach($next as $workout) {
						$desc = array(
							"location" => $workout['workouts']['location_name'], 
							"description" => $workout['workouts']['description'],
							"sport" => $workout['workouts']['sport'],
							"date" => $workout['workouts']['date']);
						array_push($obj['coming'], $desc);
					}
				}
				$this->response->statusCode(200);
				$this->set('past', $obj['past']);
				$this->set('coming', $obj['coming']);
				return $this->set('_serialize', array('past', 'coming'));
			} else {
				$this->response->statusCode(404); // Not Found
	        	return $this->set('_serialize', array()); // Nothing to serialize
			}	
		} else {
			// Des informations sont manquantes
			$this->response->statusCode(400); 	// Bad request - missing arguments
        	return $this->set('_serialize', array()); // Nothing to serialize
		}
	}

	/**
	 *	/api/addlog/b6789/110/2 (ajoute 2 points au membre 23 sur le match 110 en se déclarant comme l’objet b6789)
	 */
	public function addlog($s, $w, $p) {
		if(isset($s) && isset($w) && isset($p)) {

			$workout = $this->Workout->findById($w);
			$device = $this->Device->findBySerial($s);

			if($workout) $workout = $workout['Workout'];
			if($device) $device = $device['Device'];

			if($workout['member_id'] == $device['member_id'] && $device['trusted'] == 1) {

				$this->Log->create();
				$this->Log->save(array(
					'member_id' => $workout['member_id'],
					'workout_id' => $workout['id'],
					'device_id' => $device['id'],
					'date' => date("Y-m-d H:i:s"),
					'log_value' => $p
					));
				$this->response->statusCode(201);
				return $this->set('_serialize', array());
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


	/**
	 *		Register a new object as trusted automatically
	 */
	public function register($username, $password, $uuid, $d) {

		$login=false;

		$user = $this->Member->findByEmail($username);

		if($user) {
			$storedHash = $user['Member']['password'];
			$newHash = Security::hash($password, 'blowfish', $storedHash);
		} else {
			$this->response->statusCode(401); // Unauthorized
			$this->set('login', $login);
        	return $this->set('_serialize', array("login")); // return login false
		}
		

		if($storedHash == $newHash) {	// username and password matches

			$device = $this->Device->find('first', array('conditions' => array('Device.member_id' => $user['Member']['id'], 'Device.serial' => $uuid)));
			
			if($device) {	// Device already exist
				if(!$device['Device']['trusted']) {	// if not already trusted
					$this->Device->id = $device['Device']['id'];
					$this->Device->saveField('trusted', 1);	// trust it
				}
				$this->response->statusCode(200);	//Conflict
				$this->set('id', $device['Device']['id']);
				$login = true;
			} else {
				$this->Device->create();
				$this->Device->save(array('member_id' => $user['Member']['id'], 'serial' => $uuid, 'description' => $d, 'trusted' => 1));
				$this->set('id', $this->Device->getLastInsertId());
				$this->response->statusCode(201); // Created
        		$login = true;
			}

		} else {
			$this->response->statusCode(401); // Unauthorized
		}
		$this->set('login', $login);
		return $this->set('_serialize', array("login", "id")); // return login state
	}


	/**
	 *
	 */
	public function workout_add($date, $end, $location, $d, $sport, $id) {
		$device = $this->Device->find('first', array('conditions' => array('Device.id' => $id, 'Device.trusted' => 1)));

		$date = date("Y-m-d H:i:s", (int)$date);
		$end = date("Y-m-d H:i:s", (int)$end);

		if($device) { // Add the workout to the member
			$device = $device['Device'];
			$this->Workout->create();
			$workout = array('Workout' => array( "member_id" => $device['member_id'],
												 "date" => $date,
												 "end_date" => $end,
												 "location_name" => $location,
												 "description" => $d,
												 "sport" => $sport));
			$Done = $this->Workout->save($workout) ? true : false;
			$this->response->statusCode(401);
			$this->set('Done', $Done);
			$this->set("_serialize", array('Done'));
		} else {
			$this->response->statusCode(401);
			$this->set('Done', false);
			$this->set("_serialize", array('Done'));
		}
	}

	/**
	 *
	 */
	public function log_add($wkt, $date, $lat, $long, $type, $value, $id) {
		$device = $this->Device->find('first', array('conditions' => array('Device.id' => $id, 'Device.trusted' => 1)));
		$workout = $this->Workout->findById($wkt);

		$date = date("Y-m-d H:i:s", (int)$date);	// MySQL Date format

		if($device && $workout && $workout['Workout']['member_id'] == $device['Device']['member_id']) { // Add the log to the workout
			$device = $device['Device'];
			$this->Log->create();
			$log = array('Log' => array( "member_id" => $device['member_id'],
										 "date" => $date,
										 "workout_id" => $workout['Workout']['id'],
										 "device_id" => $device['id'],
										 "location_latitude" => $lat,
										 "location_logitude" => $long,
										 "log_type" => $type,
										 "log_value" => $value));
			$Done = $this->Log->save($log) ? true : false;
			$this->response->statusCode(401);
			$this->set('Done', $Done);
			$this->set("_serialize", array('Done'));
		} else {
			$this->response->statusCode(401);
			$this->set('Done', false);
			$this->set("_serialize", array('Done'));
		}
	}


	/**
	 *
	 */
	public function workout($id, $did = null) {
		// No second argument, wants the list of the availables workouts
		if($did == null) {
			$device = $this->Device->find('first', array('conditions' => array('Device.id' => $id, 'Device.trusted' => 1)));
			if($device) {
				$workouts = $this->Workout->find('all', array('conditions' => array('member_id' => $device['Device']['member_id'])));
				$list = array();
				foreach ($workouts as $workout) {
					array_push($list, $workout['Workout']);
				}
				$this->set('list', $list);
				$this->set('_serialize', array('list'));
			} else {
				$this->response->statusCode(404);	// nothing found
				$this->set("_serialize", array());
			}
		} else { // Wants only one workout
			$device = $this->Device->find('first', array('conditions' => array('Device.id' => $did, 'Device.trusted' => 1)));
			$workout = $this->Workout->findById($id);
			if($device && $workout && $device['Device']['member_id'] == $workout['Workout']['member_id']) {
				$this->set('workout', $workout['Workout']);
				$this->set('_serialize', array('workout'));
			} else {
				$this->response->statusCode(404);	// nothing found
				$this->set("_serialize", array());
			}
		}
	}


	/**
	 *
	 */
	public function logs($wid, $did) {
		
		$device = $this->Device->find('first', array('conditions' => array('Device.id' => $did, 'Device.trusted' => 1)));
		$workout = $this->Workout->findById($wid);
		if($device && $workout && $device['Device']['member_id'] == $workout['Workout']['member_id']) {
			$logs = $this->Log->find('all', array('conditions' => array('Log.workout_id' => $wid, 'Log.device_id' => $did)));
			if($logs) {
				$list = array();
				foreach ($logs as $log) {
					array_push($list, $log['Log']);
				}
				$this->set('list', $list);
				$this->set('_serialize', array('list'));
			} else {
				$this->response->statusCode(404);	// nothing found
				$this->set("_serialize", array());
			}
		} else {
			$this->response->statusCode(401);	// Unauthorized
			$this->set("_serialize", array());
		}
	}

}

?>