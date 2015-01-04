<?php
namespace Tests\Task\ProgressStorage;

use Task,
	Tester,
	Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * @testcase
 */
class FileTest extends Tester\TestCase
{
	public function testInit() {
		// arrange

		// act
		$storage = new Task\ProgressStorage\File(__DIR__ . '/temp/init.cache');

		// assert
		Assert::truthy($storage);
	}

	public function testState() {
		// arrange
		$storage = new Task\ProgressStorage\File(__DIR__ . '/temp/testState.cache');
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
		$file = __DIR__ . '/temp/testClear.cache';
		$storage = new Task\ProgressStorage\File($file);

		// act
		$storage->setState(array());
		$storage->clear();

		// assert
		Assert::false(file_exists($file));
	}
}

$testCase = new FileTest;
$testCase->run();