<?php
namespace Mock;

/**
 * Interface for mocked object
 * @author Vojtech Sysel
 */
interface IMockedObject
{
	/**
	 * Returns TRUE if method was called
	 * @param string Method name
	 * @return bool
	 * @throws Mock\UnknownMethodException
	 */
	public function wasMethodCalled($methodName);

	/**
	 * Returns how many times was method called
	 * @param string Method name
	 * @return int
	 * @throws Mock\UnknownMethodException
	 */
	public function methodCallsCount($methodName);

	/**
	 * Returns TRUE if property was used
	 * @param string Property name
	 * @return bool
	 * @throws Mock\UnknownPropertyException
	 */
	public function wasPropertyUsed($propertyName);

	/**
	 * Returns how many times was property used
	 * @param string Property name
	 * @return int
	 * @throws Mock\UnknownPropertyException
	 */
	public function propertyUseCount($propertyName);
}
