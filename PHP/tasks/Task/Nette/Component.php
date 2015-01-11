<?php
namespace Task\Nette;

use Task,
	Nette;

/**
 * Task component for Nette
 *
 * @author Vojtech Sysel
 */
class Component extends Nette\Application\UI\Control
{
	/** @var callback[] $onStepEvent Callback for each step */
	public $onStepEvent = array();

	/** @var callback[] $onFinishEvent Callback after finish */
	public $onFinishEvent = array();

	/** @var Task\ITaskRunner $runner Task runner */
	protected $runner;

	/**
	 * @param Task\ITaskRunner Task runner
	 * @param Nette\ComponentModel\IContainer Parent component
	 * @param string Component name
	 */
	public function __construct(Task\ITaskRunner $runner, Nette\ComponentModel\IContainer $parent = NULL,
			$name = NULL) {
		parent::__construct($parent, $name);

		$this->runner = $runner;
	}

	/**
	 * Handlers
	 */

	/**
	 * Step handler
	 */
	public function handleStep() {
		if (!$this->runner->isFinished()) {
			$this->runner->run();
		}

		if ($this->getPresenter()->isAjax()) {
			$this->invalidateControl('taskComponent');
		}
	}

	/**
	 * Component render
	 */

	/**
	 * Render component
	 */
	public function render() {
		$template = $this->template;
		$template->setFile(__DIR__ . '/taskComponent.latte');

		$progress = $this->runner->getProgress();
		$percentage = round(($progress['done'] / ($progress['count'] == 0 ? 1 : $progress['count'])) * 100);

		$template->inProgress = $progress['remain'] !== 0;
		$template->progressPercentage = $percentage;
		$template->componentName = $this->getName();

		$template->render();

		// finish event
		if ($progress['remain'] === 0) {
			foreach ($this->onFinishEvent as $handler) {
				Nette\Utils\Callback::invoke($handler);
			}
		}
	}

	/**
	 * Return component to string
	 * @return string Rendered component
	 */
	public function __toString() {
		ob_start();
		$this->render();
		return ob_get_clean();
	}
}
