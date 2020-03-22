<?php
/**
 * DocumentsTracker Fixture
 */
class DocumentsTrackerFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'document_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'status_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'level_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'updated_by' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'brought_by' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'date_brought' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'date_updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'document_id' => 1,
			'status_id' => 1,
			'level_id' => 1,
			'updated_by' => 1,
			'brought_by' => 1,
			'date_brought' => '2016-02-12 08:38:06',
			'date_updated' => '2016-02-12 08:38:06'
		),
	);

}
