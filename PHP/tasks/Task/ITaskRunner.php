<?php
namespace Task;

/**
 * Runner for tasks
 *
 * @author Vojtech Sysel
 */
interface ITaskRunner
{
	const TASK_READY = 0,
			TASK_FINISHED = 1;

	/**
	 * Add task to runner
	 * @param Task\ITask Task
	 * @return void
	 */
	public function addTask(ITask $task);

	/**
	 * Run all tasks
	 * @return void
	 */
	public function run();

	/**
	 * Returns true if all tasks are finished
	 * @return bool
	 */
	public function isFinished();

	/**
	 * Get progress information about tasks
	 * @return array
	 */
	public function getProgress();
}
