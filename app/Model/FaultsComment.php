<?php
App::uses('AppModel', 'Model');
/**
 * FaultsComment Model
 *
 * @property User $User
 * @property Fault $Fault
 */
class FaultsComment extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'comment';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Fault' => array(
			'className' => 'Fault',
			'foreignKey' => 'fault_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
