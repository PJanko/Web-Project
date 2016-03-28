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
	public $uses = array();


	// Workout
	public function workout() {


		if ($this->request->is('post')) {
			if(($this->request->data['Workout']['date'] == $this->request->data['Workout']['end_date']) {
				$this->Flash->error(__('Les dates ne correspondent pas'));
				//return $this->redirect(array('action' => 'workout'));
			}
			$this->Workout->create();
            if ($this->Workout->save($this->request->data)) {
                $this->Flash->success(__("L'utilisateur a été correctement enregistré son activité !"));
                //return $this->redirect(array('action' => 'workout'));
            }
            $this->Flash->error(__("L'utilisateur n'a pas pu être enregistré, veuillez réessayer !"));
            return $this->redirect(array('action' => 'workout'));
        }

		}

	}
}
