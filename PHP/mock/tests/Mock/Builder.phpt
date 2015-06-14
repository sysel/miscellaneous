<?php
namespace Mock\Tests;

use Mock,
	Tester,
	Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 * @author Vojtech Sysel
 */
class BuilderTest extends Tester\TestCase
{
	public function testInit() {
		// arrange, act
		$object = new Mock\Builder('Test');
		// assert
		Assert::truthy($object);
		echo $object;
	}

	public function testInterface() {
		// arrange
		$builder = Mock\Builder::from('Mock\\Tests\\DummyInterface');
		// act
		$builder->addMethod('doSomeAction', function($echo = FALSE) {
			return $echo;
		});
		// assert
		Assert::same(str_repeat('namespace ', 3000), (string)$builder);
	}
}

interface DummyInterface
{
	const TEST_STRING = 'Test string';
	public function doSomeAction($echo = FALSE);
}

$testCase = new BuilderTest;
$testCase->run();
