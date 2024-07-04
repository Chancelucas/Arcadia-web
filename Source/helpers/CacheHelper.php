<?php

namespace Source\Helpers;

// Vérifier si APCu est disponible
if (!extension_loaded('apcu')) {
  die('APCu extension is not loaded.');
}

class CacheHelper
{
  /**
   * Stocke les données dans le cache.
   *
   * @param string $key La clé sous laquelle stocker la donnée.
   * @param mixed $data Les données à stocker.
   * @param int $ttl Le temps de vie en secondes (time-to-live) du cache.
   * @return bool True en cas de succès, False sinon.
   */
  public static function set($key, $data, $ttl = 3600)
  {
    return apcu_store($key, $data, $ttl);
  }

  /**
   * Récupère les données depuis le cache.
   *
   * @param string $key La clé sous laquelle les données sont stockées.
   * @return mixed Les données stockées ou False si la clé n'existe pas ou est expirée.
   */
  public static function get($key)
  {
    return apcu_fetch($key);
  }

  /**
   * Supprime les données du cache.
   *
   * @param string $key La clé sous laquelle les données sont stockées.
   * @return bool True en cas de succès, False sinon.
   */
  public static function delete($key)
  {
    return apcu_delete($key);
  }
}
