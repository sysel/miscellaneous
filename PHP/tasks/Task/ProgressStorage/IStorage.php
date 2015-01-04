<?php
namespace Task\ProgressStorage;

/**
 * Interface for progress storage
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
	 */
	function setState($state);

	/**
	 * Clear storage
	 */
	function clear();
}
