<?php
namespace Task;

/**
 * Simple runner for Tasks
 */
class SimpleRunner implements ITaskRunner
{
	/** @var \Task\ProgressStorage\IStorage $progressStorage Progress storage */
	private $progressStorage;

	/** @var \Task\ITask[] $tasks Tasks in runner */
	private $tasks = array();

	/**
	 * @param \Task\ProgressStorage\IStorage Storage for task progress
	 */
	public function __construct(ProgressStorage\IStorage $storage) {
		$this->progressStorage = $storage;
	}

	/**
	 * Add task to runner
	 * @param \Task\ITask Task
	 * @return SimpleRunner
	 */
	public function addTask(ITask $task) {
		$this->tasks[] = $task;
		return $this;
	}

	/**
	 * Run all tasks
	 */
	public function run() {
		// load current state
		$state = $this->getState();
		$currentTaskKey = NULL;

		// process next task
		foreach ($this->tasks as $key => $task) {
			if ($state[$key] === self::TASK_READY) {
				$task->execute();
				$currentTaskKey = $key;
				break;
			}
		}

		// save state
		if ($currentTaskKey !== NULL) {
			$this->setState($state, $currentTaskKey);
		}
	}

	/**
	 * Get current runner state
	 */
	protected function getState() {
		$savedState = $this->progressStorage->getState();
		if (!is_array($savedState)) {
			$savedState = array();
		}

		$state = array();
		foreach ($this->tasks as $key => $task) {
			$id = "{$key}_{$task->getName()}";
			$taskState = self::TASK_READY;
			if (array_key_exists($id, $savedState) && $savedState[$id] === self::TASK_FINISHED) {
				$taskState = self::TASK_FINISHED;
			}
			$state[$key] = $taskState;
		}

		return $state;
	}

	/**
	 * Set current runner state
	 */
	protected function setState($state, $taskKey) {
		$state[$taskKey] = self::TASK_FINISHED;

		$runnerState = array();
		foreach ($this->tasks as $key => $task) {
			$id = "{$key}_{$task->getName()}";
			$taskState = self::TASK_READY;
			if (array_key_exists($key, $state) && $state[$key] === self::TASK_FINISHED) {
				$taskState = self::TASK_FINISHED;
			}
			$runnerState[$id] = $taskState;
		}

		$this->progressStorage->setState($runnerState);
	}

	/**
	 * Returns true if all tasks are finished
	 * @return bool
	 */
	public function isFinished() {
		$progress = $this->getProgress();
		return $progress['remain'] === 0;
	}

	/**
	 * Get progress information about tasks
	 */
	public function getProgress() {
		$progress = array(
			'count' => count($this->tasks),
			'done' => 0,
			'remain' => 0,
		);

		foreach ($this->getState() as $taskStatus) {
			if ($taskStatus === self::TASK_READY) {
				$progress['remain']++;
			} elseif ($taskStatus === self::TASK_FINISHED) {
				$progress['done']++;
			}
		}

		return $progress;
	}
}
