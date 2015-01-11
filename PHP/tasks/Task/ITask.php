<?php
namespace Task;

/**
 * Interface for simple task
 *
 * @author Vojtech Sysel
 */
interface ITask
{
	/**
	 * Task name
	 * @return string
	 */
	public function getName();

	/**
	 * Execute selected task
	 * @return void
	 */
	public function execute();
}
