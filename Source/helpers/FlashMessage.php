<?php

namespace Source\Helpers;

class FlashMessage
{
  // Ajoute un message flash temporaire
  public static function addMessage(string $message, string $type = 'success')
  {
    // Validation du type de message : success, error ou warning uniquement
    $allowedTypes = ['success', 'error', 'warning'];
    if (!in_array($type, $allowedTypes)) {
      $type = 'success';  // Par défaut, success si le type n'est pas reconnu
    }

    // Stockage du message et du type dans la session
    $_SESSION['flash_message'] = [
      'message' => $message,
      'type' => $type
    ];
  }

  // Méthode pour afficher les messages
  public static function displayFlashMessage()
  {
    if (!empty($_SESSION['flash_message'])) {
      $flash = $_SESSION['flash_message'];

      // Récupération du message et du type
      $message = $flash['message'];
      $type = $flash['type'];

      // Affichage du message
      $output = "<div class='flash-message {$type}' id='flash-message'>{$message}</div>";

      // Supprimer le message après affichage pour éviter qu'il persiste
      unset($_SESSION['flash_message']);

      return $output;
    }
  }
}
