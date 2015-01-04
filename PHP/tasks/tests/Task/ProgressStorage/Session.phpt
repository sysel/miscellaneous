<?php
namespace Tests\Task\ProgressStorage;

use Task,
	Tester,
	Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * @testcase
 */
class SessionTest extends Tester\TestCase
{
	public function testInit() {
		// arrange

		// act
		$storage = new Task\ProgressStorage\Session('init.test');

		// assert
		Assert::truthy($storage);
	}

	public function testState() {
		// arrange
		$storage = new Task\ProgressStorage\Session('/temp/state.test');
		$expected = array(
			1 => array('foo', 'bar'),
		);

		// act
		$storage->setState($expected);
		$target = $storage->getState();

		// assert
		Assert::same($expected, $target);
	}

	public function testClear() {
		// arrange
		$key = 'clear.test';
		$storage = new Task\ProgressStorage\Session($key);

		// act
		$storage->setState(array());
		$storage->clear();

		// assert
		Assert::false(array_key_exists($key, $_SESSION));
	}
}

$testCase = new SessionTest;
$testCase->run();