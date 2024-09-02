<?php

namespace Source\Routers;

use Source\Controllers\MainController;

/**
 * Router principal
 */
class MainRouter
{


  /**
   * Initialise la session et gère les requêtes HTTP.
   *
   * Cette méthode initialise une session, normalise les URI avec une barre oblique finale,
   * et dirige les requêtes GET et POST vers les méthodes appropriées.
   *
   * @return void
   */
  public function start()
  {
    // Démarre une nouvelle session ou reprend une session existante
    session_start();

    // Récupère l'URI de la requête actuelle
    $uri = $_SERVER['REQUEST_URI'];

    // Vérifie si l'URI n'est pas vide, n'est pas la racine et se termine par une barre oblique
    if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
      // Supprime la barre oblique finale de l'URI
      $uri = substr($uri, 0, -1);
      // Définit le code de réponse HTTP à 301 (Redirection permanente)
      http_response_code(301);
      // Redirige vers l'URI modifiée
      header('Location: ' . $uri);
      exit;
    }

    // Initialise un tableau pour les paramètres
    $params = [];

    // Vérifie si un paramètre 'p' est présent dans l'URL
    if (!empty($_GET['p'])) {
      // Divise le paramètre 'p' en un tableau en utilisant '/' comme délimiteur
      $params = explode('/', $_GET['p']);
    }

    // Vérifie le type de requête HTTP
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Gère la requête POST avec les paramètres
      $this->handlePostRequest($params);
    } else {
      // Gère la requête GET avec les paramètres
      $this->handleGetRequest($params);
    }
  }



  /**
   * Gère les requêtes HTTP POST en appelant le contrôleur et l'action appropriés.
   *
   * Cette méthode privée analyse les paramètres pour déterminer quel contrôleur et quelle action
   * doivent être exécutés. Si le contrôleur ou l'action n'existent pas, elle renvoie une réponse 404.
   *
   * @param array $params Les paramètres de la requête, où le premier paramètre est le contrôleur et le second est l'action.
   * @return void
   */
  private function handlePostRequest($params)
  {
    try {
      if (!empty($params)) {
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
          $this->handle404();
        }
      } else {
        // Utilise le contrôleur par défaut 'MainController' si aucun paramètre n'est fourni
        $controller = new MainController;
        // Appelle l'action 'index' du contrôleur par défaut
        $controller->index();
      }
    } catch (\Throwable $th) {
      $this->handle404();
    }
  }


  /**
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
    try {
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
          $this->handle404();
        }
      } else {
        // Utilise le contrôleur par défaut 'MainController' si aucun paramètre n'est fourni
        $controller = new MainController;
        // Appelle l'action 'index' du contrôleur par défaut
        $controller->index();
      }
    } catch (\Throwable $th) {
      $this->handle404();
    }
  }

  private function handle404()
  {
    http_response_code(404);
    // Construit le nom du contrôleur basé sur le premier paramètre
    $controller = '\\Source\\Controllers\\Page404Controller';
    // Instancie le contrôleur
    $controller = new $controller;
    // Détermine l'action à appeler, par défaut 'index' si non spécifiée
    $action = 'index';

    $controller->$action();
  }
}
