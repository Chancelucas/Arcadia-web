<?php

function createSlug($name)
{
  // Convertir la chaîne de caractères en minuscules
  $slug = strtolower($name);

  // Remplacer les caractères spéciaux et les accents
  $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
  $slug = preg_replace("/[^\w\s-]/", '', $slug);

  // Remplacer les espaces et autres caractères non désirés par des tirets
  $slug = preg_replace('/[\s_]+/', '-', $slug);

  // Supprimer les tirets en début et fin de chaîne
  $slug = trim($slug, '-');

  return $slug;
}
