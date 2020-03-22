<?php
App::uses('AppModel', 'Model');
/**
 * OvertimeRequester Model
 *
 * @property User $User
 * @property Department $Department
 */
class OvertimeRequester extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed
public $actsAs = array('Containable');
public $hasMany = ['Preovertime', 'Overtime'];

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
		'Department' => array(
			'className' => 'Department',
			'foreignKey' => 'department_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
