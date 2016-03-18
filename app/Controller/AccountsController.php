<?php

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 */
class AccountsController extends AppController
{

    public function index()
    {
		die('test');
    }
    
    public function halloffame()
	{
		$this->set('raw',$this->Member->find());
	}
	
    public function myprofile()
    {
		$this->set('raw',$this->Member->findById(1));
    }

}
?>
