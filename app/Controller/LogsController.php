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
	

	public function addlog($id){
		$workout = $this->Workout->findById($id);
		$this->set('id', $id);
		if($workout) {
			$workout['Workout']['running'] = $this->running($workout['Workout']['date'], $workout['Workout']['end_date']);
			$this->set('Workout', $workout);
		}
			if ($this->request->is('post')){
				$this->request->data['Log']['member_id'] = $this->Auth->user('id');
				$this->request->data['Log']['workout_id'] = $id;
				$this->Log->create();
		        if ($this->Log->save($this->request->data)) {
		            $this->Flash->success(__("Nouveau log ajouté à votre séance"));  
            	} else {
            		$this->Flash->error(__($this->Log->validationErrors['log_value'][0]));
            	}
			}
			
			
			$logs = $this->Log->find('all', array('conditions' => array(
				'Log.member_id' => $this->Auth->user('id'),
				'Log.workout_id' => $id)));
			$this->set('Logs', $logs);
			$workouts = $this->Workout->find('all', array('conditions' => array('Workout.member_id' => $this->Auth->user('id'))));
		
		
	}
	
	public function delete($id){
		$logs = $this->Log->findById($id)['Log'];
		$this->set('id', $id);
		//pr($logs); die();
		
		if($logs['member_id'] == $this->Auth->user('id')) {
			$this->Log->delete($id);
			$this->Flash->success(__("Le log a été correctement supprimé de votre liste"));
			return $this->redirect(array('action' => 'addlog'));
		} else {
			$this->Flash->error(__('Une erreur est survenue lors de la suppression, veuillez réessayer'));
			return $this->redirect(array('action' => 'addlog'));
		}
		
	}

	 private function running($date, $end) {
        if(strtotime($date) <= time() && strtotime($end) >= time()) return true;
        else return false;
    }
}
?>
