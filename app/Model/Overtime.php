<?php
App::uses('AppModel', 'Model');
/**
 * Overtime Model
 *
 * @property User $User
 */
class Overtime extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed
 public $hasMany = ['OvertimeReason'];
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
		),
		'Preovertime' => array(
			'className' => 'Preovertime',
			'foreignKey' => 'preovertime_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	// public function beforeSave($options = array()) {
	// 	$tots = (strtotime($this->data['Overtime']['end_time']) - strtotime($this->data['Overtime']['start_time'])) / 3600;
	// 	$this->data['Overtime']['total_hours'] = $tots;
  //   return true;
	// }
}
