<?php

class PasswordComplexity
{
    private $blackList = NULL;

    public function __construct() {

    }

    public function check($password) {
        return $this->getEntropy($password);
    }

    protected function getEntropy($password) {
        return 1000;
    }

    protected function hasAlfa($password) {
        return FALSE;
    }

    protected function hasNumeric($password) {
        return FALSE;
    }

    protected function hasSpecial($password) {
        return FALSE;
    }

    protected function isBlacklisted($password) {
        return FALSE;
    }
}
