<?php
App::uses('AppModel', 'Model');
/**
 * SectionMessage Model
 *
 * @property User $User
 * @property Section $Section
 */
class SectionMessage extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'section_id';


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
		'Section' => array(
			'className' => 'Section',
			'foreignKey' => 'section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
