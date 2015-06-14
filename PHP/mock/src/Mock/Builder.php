<?php
namespace Mock;

use Nette\PhpGenerator,
	Nette\Reflection;

/**
 * Builder for mocked objects
 * @author Vojtech Sysel
 */
class Builder
{
	/** @const string Default class namespace */
	const DEFAULT_NAMESPACE = 'Mock\\Gerenerated';

	/** @var Nette\PhpGenerator\ClassType Mock object */
	protected $class;

	/** @var string Namespace */
	protected $namespace;

	/**
	 * Build mocked object from existing object or interface
	 * @param string Name of class or interface
	 * @return self
	 */
	public static function from($className) {
		$mock = new self($className);

		// add wrapped methods from object
		$class = Reflection\ClassType::from($className);
		if (!$class->isInterface()) {
			throw new CodeGeneratorException('Only interfaces are supported');
		}

		if ($class->isInterface()) {
			$mock->addImplements($className);
		}

		return $mock;
	}

	/**
	 * Build new mocked class
	 * @param string Class name
	 * @param string Class namespace
	 */
	public function __construct($className, $namespace = NULL) {
		$this->class = new PhpGenerator\ClassType($className);
		$this->namespace = $namespace;

		// add properties
		$propCalledMethods = $this->class->addProperty('__calledMethods', array());
		$propCalledMethods->setVisibility('private');
		$propUsedProperties = $this->class->addProperty('__usedProperties', array());
		$propUsedProperties->setVisibility('private');
		$propMethodCallbacks = $this->class->addProperty('__methodCallbacks', array());
		$propMethodCallbacks->setVisibility('private');

		// add wasMethodCalled
		$wasMethodCalled = PhpGenerator\Method::from('Mock\\IMockedObject::wasMethodCalled');
		$wasMethodCalled->addBody('return array_key_exists($methodName, $this->__calledMethods);');

		// add methodCallsCount
		$methodCallsCount = PhpGenerator\Method::from('Mock\\IMockedObject::methodCallsCount');
		$methodCallsCount->addBody('if (array_key_exists($methodName, $this->__calledMethods)) {');
		$methodCallsCount->addBody('	return $this->__calledMethods[$methodName];');
		$methodCallsCount->addBody('} else {');
		$methodCallsCount->addBody('	return 0;');
		$methodCallsCount->addBody('}');

		// add wasPropertyUsed
		$wasPropertyUsed = PhpGenerator\Method::from('Mock\\IMockedObject::wasPropertyUsed');
		$wasPropertyUsed->addBody('return array_key_exists($propertyName, $this->__usedProperties);');

		// add propertyUseCount
		$propertyUseCount = PhpGenerator\Method::from('Mock\\IMockedObject::propertyUseCount');
		$propertyUseCount->addBody('if (array_key_exists($propertyName, $this->__usedProperties)) {');
		$propertyUseCount->addBody('	return $this->__usedProperties[$propertyName];');
		$propertyUseCount->addBody('} else {');
		$propertyUseCount->addBody('	return 0;');
		$propertyUseCount->addBody('}');

		// add setCallbacks
		$setCallbacks = new PhpGenerator\Method;
		$setCallbacks->setName('setCallbacks')
			->setVisibility('private')
			->setParameters(array(
				(new PhpGenerator\Parameter())->setName('callbacks')->setTypeHint('array'),
			));
		$setCallbacks->addBody('$this->__methodCallbacks = $callbacks;');

		// set all methods
		$this->class->setMethods(array(
			'wasMethodCalled' => $wasMethodCalled,
			'methodCallsCount' => $methodCallsCount,
			'wasPropertyUsed' => $wasPropertyUsed,
			'propertyUseCount' => $propertyUseCount,
			'setCallbacks' => $setCallbacks,
		));
	}

	/**
	 * Get generated class namespace
	 * @return string
	 */
	public function getNamespace() {
		return $this->namespace;
	}

	/**
	 * Set generaed class namespace
	 * @param string Namespace
	 * @return self
	 */
	public function setNamespace($namespace) {
		$this->namespace = $namespace;
		return $this;
	}

	/**
	 * Add interface to implement
	 * @param string Interface name
	 * @return self
	 */
	public function addImplements($interfaceName) {
		$this->class->addImplement($interfaceName);

		$interface = Reflection\ClassType::from($interfaceName);

		// constants
		$constants = $this->class->getConsts();
		foreach ($interface->getConstants() as $name => $value) {
			if (isset($constants[$name])) {
				continue;
			}
			$constants[$name] = $value;
		}
		$this->class->setConsts($constants);

		// methods
		$methods = $this->class->getMethods();
		foreach ($interface->getMethods() as $name => $method) {
			if (isset($methods[$name])) {
				continue;
			}
			$mockMethod = PhpGenerator\Method::from($interfaceName.'::'.$method->getName());
			$methods[$name] = $mockMethod;
		}
		$this->class->setMethods($methods);

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
	 * @return Mock\IMockedObject
	 */
	public function getInstance() {
		eval($this->generateCode());
		$classReflection = Nette\Reflection\ClassType::from($this->class->getName());
		return $classReflection->newInstance();
	}

	/**
	 * Return mocked class PHP code
	 * @return string
	 */
	public function __toString() {
		return $this->generateCode();
	}

	/**
	 * Generate mocked class code
	 * @return string
	 */
	protected function generateCode() {
		$namespace = $this->namespace === NULL ? self::DEFAULT_NAMESPACE : $this->namespace;

		$code = '';
		if (!empty($namespace)) {
			$code .= "namespace {$namespace} {\n";
		}

		$code .= (string)$this->class;

		if (!empty($namespace)) {
			$code .= "}\n";
		}
		return $code;
	}
}
