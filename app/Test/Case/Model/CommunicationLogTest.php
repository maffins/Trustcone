<?php
App::uses('CommunicationLog', 'Model');

/**
 * CommunicationLog Test Case
 */
class CommunicationLogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.communication_log',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CommunicationLog = ClassRegistry::init('CommunicationLog');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CommunicationLog);

		parent::tearDown();
	}

}
