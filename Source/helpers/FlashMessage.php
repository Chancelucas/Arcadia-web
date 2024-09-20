<?php

namespace Source\Helpers;

use Source\Helpers\SecurityHelper;
use Source\Helpers\InputType;

class FlashMessage
{
  private static $message = null;
  private static $type = null;

  // Ajoute un message flash temporaire
  public static function addMessage(string $message, string $type = 'success')
  {
    // Validation du type de message : success ou error uniquement
    $allowedTypes = ['success', 'error', 'warning'];
    if (!in_array($type, $allowedTypes)) {
      $type = 'success';  // Par défaut, success si le type n'est pas reconnu
    }

    // Affectation du message et du type
    self::$message = $message;
    self::$type = $type;
  }

  // Méthode pour afficher les messages (sans session)
  public static function displayFlashMessage()
  {
    if (!empty(self::$message)) {
      $message = SecurityHelper::sanitize(InputType::String, self::$message);
      $type = SecurityHelper::sanitize(InputType::String, self::$type);
      echo "<div class='flash-message {$type}' id='flash-message'>
                    {$message}
                  </div>";

      // On efface le message après l'affichage pour éviter qu'il persiste
      self::$message = null;
      self::$type = null;
    }
  }
}
