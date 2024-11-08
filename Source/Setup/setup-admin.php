<?php

namespace Source\Setup;

use Source\Autoloader;
use Lib\config\Database;

define('ROOT', dirname(__DIR__));

require_once ROOT . '/Autoloader.php';

Autoloader::register();

if (Database::firstLogin()) {
  // Database::fixtureAdmin();
}
