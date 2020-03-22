<?php
App::uses('AppModel', 'Model');
/**
 * TemporaryCommittee Model
 *
 * @property User $User
 */
class TemporaryCommittee extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'temporary_committee';


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
		)
	);
}
