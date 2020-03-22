<?php
App::uses('AppModel', 'Model');
/**
 * Preovertime Model
 *
 * @property User $User
 * @property OvertimeRequester $OvertimeRequester
 */
class Preovertime extends AppModel {


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
		'OvertimeRequester' => array(
			'className' => 'OvertimeRequester',
			'foreignKey' => 'overtime_requester_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
