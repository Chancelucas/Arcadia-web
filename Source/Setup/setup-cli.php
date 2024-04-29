<?php

use Source\Autoloader;
use Lib\config\Database;

function arguments($argv)
{
  define('ROOT', dirname(__DIR__));

  echo ROOT;

  require_once ROOT . '/Source/Autoloader.php';

  Database::createAdminUser();
}
