<?php
namespace Mock\Tests;

use Mock,
	Nette,
	Tester,
	Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @testCase
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

	public function testMethodInvoke() {
		// arrange
		$classReflection = Nette\Reflection\ClassType::from('Mock\\Tests\\TestMethodClass');
		$helloMethod = $classReflection->getMethod('sayHello');
		// act
		$helloMethod->setAccessible(TRUE);
		$target = $helloMethod->invoke(new TestMethodClass(), 'people');
		$helloMethod->setAccessible(FALSE);
		// assert
		Assert::same('Hello people', $target);
	}
}

interface IDummyType
{
	public function getName();
}

class TestMethodClass
{
	private function sayHello($name = 'world') {
		return "Hello {$name}";
	}
}

$testCase = new BaseObjectTest;
$testCase->run();
