<?php
namespace Mock\Tests;

use Mock,
	Nette,
	Tester,
	Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @testcase
 */
class BaseObjectTest extends Tester\TestCase
{
	public function testInit() {
		// arrange, act
		$object = new Mock\BaseObject();
		// assert
		Assert::truthy($object);
	}

	public function testInstanceOf() {
		// arrange
		$object = new Mock\BaseObject();
		// act
		$target = $object;
		// assert
		Assert::false($target instanceof IDummyType);
	}

	public function testPhpGenerator() {
		// arrange
		$class = new Nette\PhpGenerator\ClassType('DummyType');
		// $class->setType('class');
		$class->addImplement('Mock\\Tests\\IDummyType');
		$class->addMethod('__construct');
		$class->addMethod('getName')
			->setBody('echo "Hello world!\n";');

		// act
		eval((string)$class);
		$classReflection = Nette\Reflection\ClassType::from('DummyType');
		$classInstance = $classReflection->newInstance();

		// assert
		Assert::true($classInstance instanceof IDummyType);
	}
}

interface IDummyType
{
	public function getName();
}

$testCase = new BaseObjectTest;
$testCase->run();
