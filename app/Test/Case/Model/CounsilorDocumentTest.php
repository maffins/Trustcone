<?php
App::uses('CounsilorDocument', 'Model');

/**
 * CounsilorDocument Test Case
 */
class CounsilorDocumentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.counsilor_document',
		'app.user',
		'app.department',
		'app.document',
		'app.user_type',
		'app.communication_log'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CounsilorDocument = ClassRegistry::init('CounsilorDocument');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CounsilorDocument);

		parent::tearDown();
	}

}
