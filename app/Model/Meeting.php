<?php
App::uses('AppModel', 'Model');
/**
 * Meeting Model
 *
 * @property MeetingAgenda $MeetingAgenda
 * @property MeetingAttachment $MeetingAttachment
 * @property MeetingItem $MeetingItem
 * @property MeetingMinute $MeetingMinute
 */
class Meeting extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'MeetingAgenda' => array(
			'className' => 'MeetingAgenda',
			'foreignKey' => 'meeting_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MeetingAttachment' => array(
			'className' => 'MeetingAttachment',
			'foreignKey' => 'meeting_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MeetingItem' => array(
			'className' => 'MeetingItem',
			'foreignKey' => 'meeting_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MeetingMinute' => array(
			'className' => 'MeetingMinute',
			'foreignKey' => 'meeting_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
}
