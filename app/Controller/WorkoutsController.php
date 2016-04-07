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

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class WorkoutsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Contest', 'Workout');


	// Workout
	public function index() {
		
		if ($this->request->is('post')) {
			if(isset($this->request->data['Contest'])) {
            	$this->Contest->create();
            	if($this->Contest->save($this->request->data))
                   	$this->request->data['Workout']['contest_id'] = $this->Contest->id;
            }
			$this->request->data['Workout']['member_id'] = $this->Auth->user('id');
			$this->Workout->create();
            if ($this->Workout->save($this->request->data)) {
            	if(isset($this->Contest->id)) {
            		$this->Flash->success(__("L'utilisateur a correctement enregistré sa compétition !"));
            		return $this->redirect(array('controller' => 'Contests', 'action' => 'show', $this->Contest->id));
            	} else 
                	$this->Flash->success(__("L'utilisateur a correctement enregistré son activité !"));
            }
		}
		if (isset($this->params['url']['contest'])){
			$this->set('contest', true);
		}
		$workouts = $this->Workout->find('all', array(
			'limit' => 5,
			'order' => array('Workout.date DESC'),
			'conditions' => array('Workout.member_id' => $this->Auth->user('id'))));
		$this->set('workouts', $workouts);
	}

	public function delete($id) {

		$workouts = $this->Workout->findById($id)['Workout'];

		if($workout['member_id'] == $this->Auth->user('id')) {
			$this->Workout->delete($id);
			//$this->Flash->success(__("L'objet \"".$device['description']."\" a été correctement supprimé de votre liste !"));
			return $this->redirect(array('action' => 'index'));
		} else {
			//$this->Flash->error(__('Erreur, vous ne possédez pas cet objet !'));
			return $this->redirect(array('action' => 'index'));
		}
	}

}
