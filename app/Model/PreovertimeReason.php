<?php
App::uses('AppModel', 'Model');
/**
 * PreovertimeReason Model
 *
 * @property Level $Level
 * @property Preovertime $Preovertime
 * @property User $User
 */
class PreovertimeReason extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Level' => array(
			'className' => 'Level',
			'foreignKey' => 'level_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Preovertime' => array(
			'className' => 'Preovertime',
			'foreignKey' => 'preovertime_id',
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
