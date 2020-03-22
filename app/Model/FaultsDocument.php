<?php
App::uses('AppModel', 'Model');
/**
 * FaultsDocument Model
 *
 * @property Fault $Fault
 */
class FaultsDocument extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'document_name';


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
		)
	);
}
