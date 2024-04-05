<?php

namespace Source\Routers;

use Source\Controllers\MainController;

/**
 * Router principal
 */
class MainRouter
{
    /**
     * Start router, start session
     */
    public function start()
    {
        session_start();

        $uri = $_SERVER['REQUEST_URI'];

        if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: ' . $uri);
            exit;
        }

        $params = [];

        if (!empty($_GET['p'])) {
            $params = explode('/', $_GET['p']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest($params);
        } else {
            $this->handleGetRequest($params);
        }
    }

    /**
     * 
     */
    private function handlePostRequest($params)
    {
        if (!empty($params)) {
            $controller = '\\Source\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';
            $controller = new $controller;
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)) {
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                echo "La page recherchée n'existe pas";
            }
        } else {
            $controller = new MainController;
            $controller->index();
        }
    }

    /**
     * 
     */
    private function handleGetRequest($params)
    {
        if (!empty($params[0])) {
            $controller = '\\Source\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';
            $controller = new $controller;
            $action = (isset($params[0])) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)) {
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                http_response_code(404);
                echo "La page recherchée n'existe pas";
            }
        } else {
            $controller = new MainController;
            $controller->index();
        }
    }
}