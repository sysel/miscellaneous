<?php

namespace App\Presenters;

use Nette,
	Task;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

	public function createComponentTaskProgress() {
		$storage = new Task\ProgressStorage\Session('demo');
		$runner = new Task\SimpleRunner($storage);
		for ($i = 0; $i < 20; $i++) {
			$runner->addTask(new DummyTask("Task {$i}"));
		}

		$component = new Task\Nette\Component($runner);
		$component->onFinishEvent[] = function() use ($storage) {
			$storage->clear();
		};
		return $component;
	}
}

class DummyTask implements Task\ITask
{
	/** @var string $name Task name */
	private $name;

	/** @param string Task name */
	public function __construct($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function execute() {
		sleep(1);
	}
}
