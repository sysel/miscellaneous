<?php
/**
 * Tests bootstrap using Nette Tester (http://tester.nette.org/)
 */

ini_set('html_errors', '0');

require_once __DIR__ . '/../vendor/autoload.php';

// Mock files
require_once __DIR__ . '/../src/Mock/loader.php';
require_once __DIR__ . '/../src/Mock/BaseObject.php';
require_once __DIR__ . '/../src/Mock/MockedObject.php';
