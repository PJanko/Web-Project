<?php

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 */
class ClassementsController extends AppController
{
	var $uses = array("Log", "Workout", "Member");

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    /**
     * index method : first page
     *
     * @return void
     */
    public function index($sport = null) {
    	if($sport != null) {
    		$this->set('sport', $sport);
    	}
    	$sports = $this->Workout->find('all', array('fields' => 'DISTINCT Workout.sport'));
    	$this->set('sports', $sports);
        // Find all distinct logs types
        $types = $this->Log->find('all', array('fields' => 'DISTINCT Log.log_type'));
        $this->set('types', $types);
		// Get all members
		$members = $this->Member->find('all');
		foreach ($members as $key => &$member) {
			$members[$key]['Log'] = array(); 
			foreach ($types as $type) {
				$value = 0;
				$count = 0;
				$logs = $this->Log->find('all', array(
					'conditions' => array('Log.member_id' => $member['Member']['id'], 'Log.log_type' => $type['Log']['log_type'])));
				foreach ($logs as $l) {
					if($sport != null) { // si le sport est choisi on filtre
						$f = $this->Workout->find('first', array('conditions' => 
										array('Workout.id' => $l['Log']['workout_id'], 'Workout.sport' => $sport)));
						if($f) {
							$value = $value + $l['Log']['log_value'];
							$count ++;
						}
					} else {	// sinon on prend tous les logs
						$value = $value + $l['Log']['log_value'];
						$count ++;
					}
				}
				$members[$key]['Log'][$type['Log']['log_type']] = $value/(count($logs) == 0 ? 1 : count($logs));
			}
		}
		$this->set('members', $members);
    }
}
?>
