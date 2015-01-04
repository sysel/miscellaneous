<?php
namespace Task;

/**
 * Runner for tasks
 */
interface ITaskRunner
{
	const TASK_READY = 0,
			TASK_FINISHED = 1;

	/**
	 * Add task to runner
	 * @param \Task\ITask Task
	 */
	function addTask(ITask $task);

	/**
	 * Run all tasks
	 */
	function run();

	/**
	 * Returns true if all tasks are finished
	 * @return bool
	 */
	function isFinished();

	/**
	 * Get progress information about tasks
	 */
	function getProgress();
}
