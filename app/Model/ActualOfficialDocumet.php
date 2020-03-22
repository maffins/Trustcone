<?php
App::uses('AppModel', 'Model');
/**
 * ActualOfficialDocumet Model
 *
 * @property OfficialDocument $OfficialDocument
 */
class ActualOfficialDocumet extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'OfficialDocument' => array(
			'className' => 'OfficialDocument',
			'foreignKey' => 'official_document_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
