<?php

namespace Source\Routers;

use Source\Controllers\MainController;
use Throwable;

/**
 * Router principal
 */
class MainRouter
{
    public function start()
    {
        session_start();
        $uri = $_SERVER['REQUEST_URI'];

        // Normalisation de l'URI
        if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: ' . $uri);
            exit;
        }

        $params = [];

        if (!empty($_GET['p'])) {
            $params = explode('/', filter_var($_GET['p'], FILTER_SANITIZE_URL));
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest($params);
        } else {
            $this->handleGetRequest($params);
        }
    }

    private function handleRequest($params)
    {
        try {
            if (!empty($params)) {
                $controllerName = ucfirst(array_shift($params)) . 'Controller';
                $controllerClass = '\\Source\\Controllers\\' . $controllerName;

                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass;
                    $action = isset($params[0]) ? array_shift($params) : 'index';

                    if (method_exists($controller, $action)) {
                        call_user_func_array([$controller, $action], $params);
                        return;
                    }
                }
                $this->handle404();
            } else {
                $controller = new MainController;
                $controller->index();
            }
        } catch (Throwable $th) {
            error_log($th->getMessage());
            $this->handle404();
        }
    }

    private function handlePostRequest($params)
    {
        $this->handleRequest($params);
    }

    private function handleGetRequest($params)
    {
        $this->handleRequest($params);
    }

    private function handle404()
    {
        http_response_code(404);
        $controller = '\\Source\\Controllers\\Page404Controller';

        if (class_exists($controller)) {
            $controller = new $controller;
            $controller->index();
        } else {
            echo "404 - Page Not Found";
        }
    }
}
