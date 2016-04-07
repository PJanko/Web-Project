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
        $this->Auth->deny(); // Deny all (lock the project)
    }

    public function beforeRender() {
        parent::beforeRender();
    }


    public function index() {
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
                $matchs[$key]['Contest']['date'] = $this->createDate($workout['Workout']['date']);
                $matchs[$key]['Contest']['running'] = $this->running($workout['Workout']['date'], $workout['Workout']['end_date']);
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
                $workout = $this->Workout->find('first', array('conditions' => array('Workout.contest_id' => $m['Contest']['id'])));
                $my[$key]['Contest']['location'] = $count[0]['Workout']['location_name'];
                $my[$key]['Contest']['date'] = $this->createDate($count[0]['Workout']['date']);
                $my[$key]['Contest']['running'] = $this->running($workout['Workout']['date'], $workout['Workout']['end_date']);
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

        $contest = $contest['Contest'];

        // Get the associated workouts
        $workouts = $this->Workout->find('all', array('conditions' => array('contest_id' => $id)));
        if(empty($workouts)) {
            $this->Flash->error(__("Erreur interne"));
            return $this->redirect(array('action' => 'index'));
        }

        $member1 = $this->Member->find('first', array('conditions' => array('id' => $workouts[0]['Workout']['member_id'] )));
        if(isset($workouts[1])) {
            $member2 = $this->Member->find('first', array('conditions' => array('id' => $workouts[1]['Workout']['member_id'] )));
            $contest['Member2'] = array('email' => $member2['Member']['email'], 
                                        'id' => $member2['Member']['id'],
                                        'workout_id' => $workouts[1]['Workout']['id'],
                                        'image' => $this->Member->createImagePath($member2['Member']['id']));
        }
        $contest['Member1'] = array('email' => $member1['Member']['email'],
                                    'id' => $member1['Member']['id'],
                                    'workout_id' => $workouts[0]['Workout']['id'], 
                                    'image' => $this->Member->createImagePath($member1['Member']['id']));
        $contest['Workout'] = array('date' => $this->createDate($workouts[0]['Workout']['date']), 
                                    'location' => $workouts[0]['Workout']['location_name'],
                                    'description' => $workouts[0]['Workout']['description'],
                                    'running' => $this->running($workouts[0]['Workout']['date'], $workouts[0]['Workout']['end_date']),
                                    'sport' => $workouts[0]['Workout']['sport']);

        $this->set('contest', $contest);
    }

    // Fin d'un match
    public function end($id) {
        $this->Flash->error("Nous n'avons pas compris comment terminer un match ?");
        return $this->redirect(array('action' => 'show', $id));
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

    private function createDate($date) {
        $phpdate = strtotime( $date );
        return date( 'l d F Y H:i', $phpdate );
    }

    private function running($date, $end) {
        if(strtotime($date) <= time() && strtotime($end) >= time()) return true;
        else return false;
    }

}

