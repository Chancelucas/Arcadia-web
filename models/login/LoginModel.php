<?php 

define("BASE_URL", '/arcadia_web');

require_once '../../models/router/Router.php';
require_once '../../models/router/UserRouter.php'; 
require_once '../../controllers/LoginController.php';
require_once '../../controllers/ProfileController.php';
require_once '../../controllers/LogoutController.php';

$router = new Router();

$router->addRoute('GET', BASE_URL.'/', 'LoginController', 'login');
$router->addRoute('POST', BASE_URL. '/', 'ProfileController', 'show');
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$handler = $route->getHandler($method, $uri);

if ($handler == null) {
    header('HTTP/1.1 404 not found');
    exit();
}

$controller = new $handler['controller']();
$action = $handler['action'];

$controller->$action();


?>

