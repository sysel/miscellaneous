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
	function getName();

	/**
	 * Execute selected task
	 * @return void
	 */
	function execute();
}
