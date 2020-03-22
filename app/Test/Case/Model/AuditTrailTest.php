<?php
App::uses('AuditTrail', 'Model');

/**
 * AuditTrail Test Case
 */
class AuditTrailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.audit_trail'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AuditTrail = ClassRegistry::init('AuditTrail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AuditTrail);

		parent::tearDown();
	}

}
