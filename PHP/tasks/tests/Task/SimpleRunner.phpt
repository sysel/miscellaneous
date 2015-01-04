<?php
namespace Tests\Task;

use Task,
	Tester,
	Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * @testcase
 */
class SimpleRunnerTest extends Tester\TestCase
{
	public function testInit() {
		// arrange
		$storage = new Task\ProgressStorage\Session('simplerunner.init');

		// act
		$runner = new Task\SimpleRunner($storage);

		// assert
		Assert::truthy($runner);
	}

	public function testIsFinished() {
		// arrange
		$storage = new Task\ProgressStorage\Session('simplerunner.isFinished');
		$runner = new Task\SimpleRunner($storage);

		// act
		$target = $runner->isFinished();

		// assert
		Assert::true($target);
	}

	public function testIsFinished2() {
		// arrange
		$storage = new Task\ProgressStorage\Session('simplerunner.isFinished2');
		$runner = new Task\SimpleRunner($storage);
		$runner->addTask(new TestTask('Task 1'));
		$runner->addTask(new TestTask('Task 2'));

		// act
		$target = $runner->isFinished();

		// assert
		Assert::false($target);
	}

	public function testRun() {
		// arrange
		$storage = new Task\ProgressStorage\Session('simplerunner.run');
		$runner = new Task\SimpleRunner($storage);
		$task = new TestTask('Task 1');
		$runner->addTask($task);
		$runner->addTask(new TestTask('Task 2'));

		// act
		$runner->run();

		// assert
		Assert::true($task->executeCalled);
	}

	public function testRun2() {
		// arrange
		$storage = new Task\ProgressStorage\Session('simplerunner.run2');
		$runner = new Task\SimpleRunner($storage);
		$task = new TestTask('Task 1');
		$runner->addTask($task);
		$task2 = new TestTask('Task 2');
		$runner->addTask($task2);

		// act
		$runner->run();
		$runner->run();

		// assert
		Assert::true($task2->executeCalled);
	}

	public function testGetProgress() {
		// arrange
		$storage = new Task\ProgressStorage\Session('simplerunner.getProgress');
		$runner = new Task\SimpleRunner($storage);
		$runner->addTask(new TestTask('Task 1'));
		$runner->addTask(new TestTask('Task 2'));

		// act
		$runner->run();
		$target = $runner->getProgress();

		// assert
		$expected = array(
			'count' => 2,
			'done' => 1,
			'remain' => 1,
		);
		Assert::same($expected, $target);
		Assert::false($runner->isFinished());
	}

	public function testGetProgress2() {
		// arrange
		$storage = new Task\ProgressStorage\Session('simplerunner.getProgress2');
		$runner = new Task\SimpleRunner($storage);
		$runner->addTask(new TestTask('Task 1'));
		$runner->addTask(new TestTask('Task 2'));

		// act
		$runner->run();
		$runner->run();
		$target = $runner->getProgress();

		// assert
		$expected = array(
			'count' => 2,
			'done' => 2,
			'remain' => 0,
		);
		Assert::same($expected, $target);
		Assert::true($runner->isFinished());
	}
}

/**
 * Test task
 */
class TestTask implements Task\ITask
{
	public $getNameCalled = false;
	public $executeCalled = false;

	private $name;

	public function __construct($name) {
		$this->name = $name;
	}

	/**
	 * Task name
	 * @return string
	 */
	public function getName() {
		$this->getNameCalled = true;
		return $this->name;
	}

	/**
	 * Execute selected task
	 */
	public function execute() {
		$this->executeCalled = true;
	}
}

$testCase = new SimpleRunnerTest;
$testCase->run();
