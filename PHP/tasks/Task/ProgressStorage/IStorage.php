<?php
namespace Task\ProgressStorage;

/**
 * Interface for progress storage
 *
 * @author Vojtech Sysel
 */
interface IStorage
{
	/**
	 * Get current state from storage
	 * @return mixed
	 */
	function getState();

	/**
	 * Set current state to storage
	 * @param array Current state
	 * @return void
	 */
	function setState($state);

	/**
	 * Clear storage
	 * @return void
	 */
	function clear();
}
