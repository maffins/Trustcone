<?php
App::uses('DocumentsTracker', 'Model');

/**
 * DocumentsTracker Test Case
 */
class DocumentsTrackerTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.documents_tracker',
		'app.document',
		'app.user',
		'app.department',
		'app.status',
		'app.level'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DocumentsTracker = ClassRegistry::init('DocumentsTracker');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DocumentsTracker);

		parent::tearDown();
	}

}
