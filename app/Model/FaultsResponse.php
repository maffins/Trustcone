<?php
App::uses('AppModel', 'Model');
/**
 * FaultsResponse Model
 *
 * @property Fault $Fault
 * @property User $User
 */
class FaultsResponse extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'faults_response';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'action_taken';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Fault' => array(
			'className' => 'Fault',
			'foreignKey' => 'fault_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
