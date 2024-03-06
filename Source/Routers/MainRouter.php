<?php

namespace Source\Routers;

/**
 * Router principal
 * 
 */
class MainRouter
{
    public function start()
    {
        $params = [];
        if (!empty($_GET['p'])) {
            $params = explode('/', $_GET['p']);
        }

        $uri = $_SERVER['REQUEST_URI'];
        if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: ' . $uri);
            exit;
        }

        $controllerName = (isset($params[0])) ? ucfirst(array_shift($params)) . 'Controller' : 'MainController';
        $action = (isset($params[0])) ? array_shift($params) : 'index';

        $controllerClass = '\\Source\\controllers\\' . $controllerName;

        $controller = new $controllerClass();

        if (method_exists($controller, $action)) {
            (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
        } else {
            http_response_code(404);
            echo "La page recherchée n'existe pas";
        }
    }
}
