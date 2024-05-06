<?php

namespace Source\Controllers;

class VetAnimalController extends VetController
{

  public function index()
  {
    $animals = $this->getAllAnimals();
    $this->render('animal/vetAnimal', ['animals' => $animals]);
  }

  public function getAllAnimals() 
  {
    $animal = new AdminAnimalController;
    $allAnimals = $animal->getAllAnimals();

    return $allAnimals;
  }

}