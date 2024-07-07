<?php

namespace Source\Controllers;

/**
 * Controller princial for web site
 * 
 */

abstract class Controller
{
  /**
   * Rendu d'une vue avec un template.
   *
   * Cette méthode affiche une vue en injectant les données fournies, puis en l'entourant d'un template.
   *
   * @param string $file Le nom du fichier de vue à afficher (sans extension .php).
   * @param array $data Les données à extraire et à rendre disponibles dans la vue.
   * @param string $template Le nom du template à utiliser (sans extension .php). Par défaut, 'defaultPublicPage'.
   * @return void
   */
  public function render(string $file, array $data = [], string $template = 'defaultPublicPage')
  {
    // Extrait les variables du tableau $data pour les rendre disponibles dans la vue
    extract($data);

    // Démarre la capture du contenu de la vue
    ob_start();

    // Inclut le fichier de vue
    require_once ROOT . '/Source/Views/Public/' . $file . '.php';

    // Récupère le contenu capturé
    $containe = ob_get_clean();

    // Inclut le fichier de template
    require_once ROOT . '/Source/Views/Public/' . $template . '.php';
  }
}
