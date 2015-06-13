<?php
namespace Mock;

/**
 * Builder for mocked objects
 */
class Builder
{
	/**
	 * Build mocked object from existing object or interface
	 * @param string Name of class or interface
	 * @return self
	 */
	public static function from($className) {
		return new self($className);
	}

	/**
	 * Build new mocked class
	 */
	public function __construct($className) {
		//
	}

	/**
	 * Add interface to implement
	 * @param string Interface name
	 * @return self
	 */
	public function addImplements($interfaceName) {
		return $this;
	}

	/**
	 * Add public property
	 * @param string Property name
	 * @param mixed Default value
	 * @return self
	 */
	public function addProperty($name, $defaultValue = NULL) {
		return $this;
	}

	/**
	 * Add method implementation
	 * @param string Property name
	 * @param callable Callback to method body
	 * @return self
	 */
	public function addMethod($name, $callback = NULL) {
		return $this;
	}

	/**
	 * Create instance of mocked object
	 * @return TODO
	 */
	public function getInstance() {
		//
	}
}
