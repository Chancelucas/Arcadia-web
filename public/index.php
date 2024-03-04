<?php

use Source\Autoloader;
use Source\Routers\MainRouter;


define('ROOT', dirname(__DIR__));

require_once ROOT.'/Source/Autoloader.php';

Autoloader::register();

$app = new MainRouter;

$app->start();






