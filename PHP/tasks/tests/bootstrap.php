<?php
/**
 * Tests bootstrap using Nette Tester (http://tester.nette.org/)
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Task files
require_once __DIR__ . '/../Task/ITask.php';
require_once __DIR__ . '/../Task/ITaskRunner.php';
require_once __DIR__ . '/../Task/ProgressStorage/IStorage.php';
require_once __DIR__ . '/../Task/SimpleRunner.php';
require_once __DIR__ . '/../Task/ProgressStorage/File.php';
require_once __DIR__ . '/../Task/ProgressStorage/Session.php';
