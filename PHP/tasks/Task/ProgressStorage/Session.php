<?php
namespace Task\ProgressStorage;

/**
 * Session storage for current state of TaskRunner
 */
class Session implements IStorage
{
	/** @var string $name Runner name */
	private $name;

	/**
	 * @param string Runner name
	 */
	public function __construct($name = '') {
		$this->name = empty($name) ? 'SessionRunner' : $name;

		// start session
		if (!$this->isSessionStarted()) {
			session_start();
		}
	}

	/**
	 * Returns true if session is started
	 * @return bool
	 */
	protected function isSessionStarted() {
		if (php_sapi_name() !== 'cli') {
			if (version_compare(phpversion(), '5.4.0', '>=')) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * Get current state from storage
	 * @return mixed
	 */
	public function getState() {
		if (array_key_exists($this->name, $_SESSION)) {
			return $_SESSION[$this->name];
		} else {
			return NULL;
		}
	}

	/**
	 * Set current state to storage
	 * @param array Current state
	 */
	public function setState($state) {
		$_SESSION[$this->name] = $state;
	}
	
	/**
	 * Clear storage
	 */
	public function clear() {
		unset($_SESSION[$this->name]);
	}
}
