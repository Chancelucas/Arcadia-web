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

        $this->handleRequest($params);
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
            var_dump($th);
        }
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



  /**
   * 
   * Gère les requêtes HTTP GET en appelant le contrôleur et l'action appropriés.
   *
   * Cette méthode privée analyse les paramètres pour déterminer quel contrôleur et quelle action
   * doivent être exécutés. Si le contrôleur ou l'action n'existent pas, elle renvoie une réponse 404.
   *
   * @param array $params Les paramètres de la requête, où le premier paramètre est le contrôleur et le second est l'action.
   * @return void
   */
  private function handleGetRequest($params)
  {
    if (!empty($params[0])) {
      // Construit le nom du contrôleur basé sur le premier paramètre
      $controller = '\\Source\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';
      // Instancie le contrôleur
      $controller = new $controller;
      // Détermine l'action à appeler, par défaut 'index' si non spécifiée
      $action = (isset($params[0])) ? array_shift($params) : 'index';

      // Vérifie si l'action existe dans le contrôleur
      if (method_exists($controller, $action)) {
        // Appelle l'action avec les paramètres s'ils existent
        (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
      } else {
        // Renvoie une réponse 404 si l'action n'existe pas
        http_response_code(404);
        echo "La page recherchée n'existe pas";
      }
    } else {
      // Utilise le contrôleur par défaut 'MainController' si aucun paramètre n'est fourni
      $controller = new MainController;
      // Appelle l'action 'index' du contrôleur par défaut
      $controller->index();
    }
  }
}
