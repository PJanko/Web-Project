<?php

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 */
 
class LogsController extends AppController
{
	var $uses = array('Log', 'Workout');
	
	public function logtest(){
    	die('test log');
    }

	public function addlog($id){
		$workout = $this->Workout->findById($id);
		//pr($workout);die();
		if($workout) {
			$this->set('Workout', $workout);
		}
		
		//if($log['member_id'] == $this->Auth->user('id')) {
			if ($this->request->is('post')){
				$this->request->data['Log']['member_id'] = $this->Auth->user('id');
				$this->Log->create();
		        if ($this->Log->save($this->request->data)) {
		            $this->Flash->success(__("Nouveau log ajouté à votre séance"));  
            	}
			}
			
			$logs = $this->Log->find('all', array('conditions' => array('Log.member_id' => $this->Auth->user('id'))));
			$this->set('Logs', $logs);
			$workouts = $this->Workout->find('all', array('conditions' => array('Workout.member_id' => $this->Auth->user('id'))));
			//pr($workouts);die();
		//}
		
		
	}
}
?>
