<?php
/**
 * Exceptions definitions
 * @author Vojtech Sysel
 */

namespace Mock;

abstract class Exception extends \Exception
{
}

class UnknownMethodException extends Exception
{
}

class UnknownPropertyException extends Exception
{
}

class CodeGeneratorException extends Exception
{
}
