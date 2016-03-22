<?php

App::uses('AuthComponent', 'Controller/Component');

class SocialProfile extends AppModel {

	public $belongsTo = 'Member';

	public $hasMany = array(
	    'SocialProfile' => array(
	        'className' => 'SocialProfile',
	    )
	);

}
