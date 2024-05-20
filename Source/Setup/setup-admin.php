<?php

use Source\Autoloader;
use Lib\config\Database;

define('ROOT', dirname(__DIR__));

require_once ROOT . '/Autoloader.php';

Autoloader::register();

// Exécuter la méthode fixtureAdmin
Database::fixtureAdmin();
