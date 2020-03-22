<?php
App::uses('AppModel', 'Model');
/**
 * MeetingItem Model
 *
 * @property Meeting $Meeting
 */
class MeetingItem extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Meeting' => array(
			'className' => 'Meeting',
			'foreignKey' => 'meeting_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
