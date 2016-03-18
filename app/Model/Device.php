<?php

App::uses('AppModel', 'Model');

class Device extends AppModel {

public $displayField = 'serial';
public $belongsTo = array(
'Member' => array(
'className' => 'Member',
'foreignKey' => 'member_id',
'conditions' => '',
'fields' => '',
'order' => ''
)
);

}

?>

