Task Runner
===========

Simple library for running time consuming tasks using HTTP protocol.

## Use

	<?php
	
	/**
	 * Time consuming task
	 */
	class Task1 implements Task\ITask
	{
		public function getName() {
			return "Task 1";
		}
	
		public function execute() {
			sleep(30);
		}
	}
	
	// runner factory
	$storage = new Task\ProgressStorage\Session('demo');
	$runner = new Task\SimpleRunner($storage);
	$runner->addTask(new Task1);
	$runner->addTask(new Task1);
	$runner->addTask(new Task1);
	$runner->addTask(new Task1);
	
	// runner processing
	while (!$runner->isFinished()) {
		$runner->run();
		header("Location: {$_SERVER['PHP_SELF']}");
		die();
	}
	
	// done
	echo "All tasks finished\n";

## Running tests

	composer update
	vendor/bin/tester tests

## Running code checker

	vendor/bin/phpcs --standard=standards.xml --tab-width=4 Task
