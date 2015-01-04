<?php
namespace Task\ProgressStorage;

/**
 * File storage for current state of TaskRunner
 */
class File implements IStorage
{
	/** @var string $file File path */
	private $file;

	/**
	 * @param string File path
	 */
	public function __construct($file) {
		$this->file = $file;
		$this->clear();
	}

	/**
	 * Get current state from storage
	 * @return mixed
	 */
	public function getState() {
		return unserialize(file_get_contents($this->file));
	}

	/**
	 * Set current state to storage
	 * @param array Current state
	 */
	public function setState($state) {
		$content = serialize($state);
		file_put_contents($this->file, $content);
	}

	/**
	 * Clear storage
	 */
	public function clear() {
		if (file_exists($this->file)) {
			unlink($this->file);
		}
	}
}
