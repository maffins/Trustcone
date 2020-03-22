<?php
/**
 * User Fixture
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'department_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'user_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'fname' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sname' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'email' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cellnumber' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'telephone' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 60, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'physical_address' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'postal_address' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
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
			'department_id' => 1,
			'user_type_id' => 1,
			'fname' => 'Lorem ipsum dolor sit amet',
			'sname' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'cellnumber' => 'Lorem ipsum dolor sit amet',
			'telephone' => 'Lorem ipsum dolor sit amet',
			'physical_address' => 'Lorem ipsum dolor sit amet',
			'postal_address' => 'Lorem ipsum dolor sit amet',
			'created' => '2016-02-12 08:40:27',
			'modified' => '2016-02-12 08:40:27'
		),
	);

}
