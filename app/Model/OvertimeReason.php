<?php
App::uses('AppModel', 'Model');
/**
 * OvertimeReason Model
 *
 * @property Overtime $Overtime
 * @property User $User
 */
class OvertimeReason extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Overtime' => array(
			'className' => 'Overtime',
			'foreignKey' => 'overtime_id',
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
