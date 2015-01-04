<?php
namespace Task;

/**
 * Interface for simple task
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
	 */
	function execute();
}
