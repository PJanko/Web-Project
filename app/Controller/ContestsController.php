<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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


class ContestsController extends AppController {

    var $uses = array('Workout', 'Member', 'Contest');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny(); // Allow all (unlock the project)
    }

    public function beforeRender() {
        parent::beforeRender();
    }

    // Créer un nouveau match
    public function index() {
        // Add a new contest
        /*if ($this->request->is('post')) {
            $this->Contest->create();
            if ($this->Contest->save($this->request->data)) {
                $this->Flash->success(__("Le Match est bien enregistré !"));
            } else {
                $this->Flash->error(__("Le match n'a pas pu être enregistré, veuillez réessayer !"));
            }
        }*/
        // List all contests to register to
        $matchs = $this->Contest->find('all');
        foreach ($matchs as $key => $match) {
            if($this->Workout->find('count', array('conditions' => array('Workout.contest_id' => $match['Contest']['id']))) >= 2 ) {
                unset($matchs[$key]);
            } else if($this->Workout->find('count', 
                array('conditions' => array(
                    'Workout.contest_id' => $match['Contest']['id'],
                    'Workout.member_id' => $this->Auth->user('id')))) == 1) {
                unset($matchs[$key]);
            } else {
                $workout = $this->Workout->find('first', array('conditions' => array('Workout.contest_id' => $match['Contest']['id'])));
                $matchs[$key]['Contest']['location'] = $workout['Workout']['location_name'];
                $matchs[$key]['Contest']['date'] = $workout['Workout']['date'];
            }
        }

        // Create the list of contest where I participate
        $my = $this->Contest->find('all');
        foreach($my as $key => $m) {
            $count =  $this->Workout->find('all', array('conditions' => array(
                'Workout.member_id' => $this->Auth->user('id'),
                'Workout.contest_id' => $m['Contest']['id'] )));
            if( count($count) != 1 ) {
                unset($my[$key]);
            } else {
                if( $this->Workout->find('count', array('conditions' => array('Workout.contest_id' => $m['Contest']['id'] ))) == 2 ) {
                   $my[$key]['Contest']['full'] = true;
                }
                $my[$key]['Contest']['location'] = $count[0]['Workout']['location_name'];
                $my[$key]['Contest']['date'] = $count[0]['Workout']['date'];
            }
        }
        $this->set('matchs', $matchs);
        $this->set('my', $my);
    }

    // Lister les matchs d'une compétition
    public function show($id) {
        // Get the corresponding contest
        $contest = $this->Contest->find('first', array('conditions' => array('id' => $id)));

        if(empty($contest)) {
            $this->Flash->error(__("Erreur interne"));
            return $this->redirect(array('action' => 'index'));
        }

        // Get the associated workouts
        $workouts = $this->Workout->find('all', array('conditions' => array('contest_id' => $id)));
        if(empty($workouts)) {
            $this->Flash->error(__("Erreur interne"));
            return $this->redirect(array('action' => 'index'));
        }

        $member1 = $this->Member->find('first', array('conditions' => array('id' => $workouts[0]['Workout']['member_id'] )));
        if(isset($workouts[1])) {
            $member2 = $this->Member->find('first', array('conditions' => array('id' => $workouts[1]['Workout']['member_id'] )));
            $this->set('member2', $member2); 
        }

        $this->set('contest', $contest);
        $this->set('workouts', $workouts);
        $this->set('member1', $member1);  
    }

    // Fin d'un match
    public function end($id) {

    }


    // S'enregistrer à un match 
    public function register($id) {
        // lister les workout
        if($this->Workout->find('count', array('conditions' => array('Workout.contest_id' => $id)) ) == 1 ) {
            $workout = $this->Workout->find('first',array('conditions' => array('Workout.contest_id' => $id)));

            unset($workout['Workout']['id']);
            $workout['Workout']['member_id'] = $this->Auth->user('id');

            // Enregistre automatiquement un nouveau workout pour l'utilisateur
            if($this->Workout->save($workout) ) {
                $this->Flash->success(__("Vous participez à ce match, bonne chance !"));
            } else {
                $this->Flash->error(__("Vous n'avez pas pu vous enregister au match, veuillez réessayer !"));
            }
        } else {
            $this->Flash->error("Vous ne pouvez plus vous enregister sur ce match !");
        }
        return $this->redirect(array('action' => 'index'));
    }

}

