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
	public function getState();

	/**
	 * Set current state to storage
	 * @param array Current state
	 * @return void
	 */
	public function setState($state);

	/**
	 * Clear storage
	 * @return void
	 */
	public function clear();
}
