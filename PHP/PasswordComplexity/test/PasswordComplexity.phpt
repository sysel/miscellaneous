<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/PasswordComplexity.php';

use Tester\Assert;

/**
 * @testCase
 */
class PasswordComplexityTest extends Tester\TestCase
{
    private $passwordComplexity;

    public function setUp() {
        $this->passwordComplexity = new PasswordComplexityMock;
    }

    public function testCheck() {
        Assert::equal(1000, $this->passwordComplexity->check('foo'));
    }
}

class PasswordComplexityMock extends PasswordComplexity
{
    public function mockProtectedGetEntropy($password) {
        return $this->getEntropy($password);
    }
}

# Run test case
$testCase = new PasswordComplexityTest;
$testCase->run();
