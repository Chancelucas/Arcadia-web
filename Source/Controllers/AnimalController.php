<?php

namespace Source\Controllers;

use Source\Controllers\Controller;
use Source\Models\animal\AnimalModel;

class AnimalController extends Controller
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $animal = $this->getAllAnimal();

    $this->render('animal/animal', [
      'allHabitats' => $animal,
    
    ]);
  }

  private function getAllAnimal()
  {
    $model = new AnimalModel;
    $allAnimals = $model->getAllAnimals();
  
    return $allAnimals;
  }

  public function page(int $idAnimal)
  {
    $model = (new AnimalModel)->findBy(['id' => $idAnimal])[0];

    $this->render('animal/page', [
      'animal' => $model
    ]);
  }
}
