<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\user\UserModel;
use Source\Models\animal\AnimalModel;
use Source\Models\animal\FoodGivenModel;

class EmployeeFoodGivenController extends EmployeeController
{
  /**
   * Affiche la page d'accueil
   */
  public function index()
  {
    $allFoodGiven = $this->filterFoodGiven();
    $filterForm = $this->createFilterForm();

    $this->render('feed/employeeFoodGiven', [
      'allFoodGiven' => $allFoodGiven,
      'filterForm' => $filterForm
    ]);
  }

  /**
   * Crée le formulaire de filtre
   */
  private function createFilterForm()
  {
    $form = new Form();

    $form->startForm('POST')
      ->addLabelFor('employee', 'Employé')
      ->addSelect('employee', $this->getAllUsername(), ['value' => $_POST['employee'] ?? null])
      ->addLabelFor('date', 'Date du repas')
      ->addSelect('date', $this->getAllDates(), ['value' => $_POST['date'] ?? null])
      ->addLabelFor('animal', 'Animal nourri')
      ->addSelect('animal', $this->getAllAnimalBreeds(), ['value' => $_POST['animal'] ?? null])
      ->addBouton('Rechercher', ['type' => 'submit', 'value' => 'search', 'name' => 'createGivenFood'])
      ->endForm();

    return $form->create();
  }

  /**
   * Filtre les nourritures données en fonction des critères sélectionnés
   */
  private function filterFoodGiven()
  {
    $foodGiven = (new FoodGivenModel())->getAllFoodGiven();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $selectedEmployee = $_POST['employee'] ?? null;
      $selectedDate = $_POST['date'] ?? null;
      $selectedAnimal = $_POST['animal'] ?? null;

      return array_filter($foodGiven, function ($entry) use ($selectedEmployee, $selectedDate, $selectedAnimal) {
        return $this->matchesCriteria($entry, $selectedEmployee, $selectedDate, $selectedAnimal);
      });
    }

    return $foodGiven;
  }

  /**
   * Vérifie si une entrée correspond aux critères de filtre
   */
  private function matchesCriteria($entry, $selectedEmployee, $selectedDate, $selectedAnimal)
  {
    $employeeMatch = !$selectedEmployee || $entry->user->getId() == $selectedEmployee;
    $dateMatch = !$selectedDate || $entry->day === $selectedDate;
    $animalMatch = !$selectedAnimal || (string)$entry->animal->getId() === (string)$selectedAnimal;

    return $employeeMatch && $dateMatch && $animalMatch;
  }

  /**
   * Récupère tous les noms d'utilisateur avec le rôle d'employé
   */
  private function getAllUsername()
  {
    return [null => 'Tous'] + (new UserModel())->getAllUsernameEmployee();
  }

  /**
   * Récupère toutes les races d'animaux
   */
  private function getAllAnimalBreeds()
  {
    return [null => 'Tous'] + (new AnimalModel())->getAllBreedAnimals();
  }

  /**
   * Récupère toutes les dates de nourriture donnée
   */
  private function getAllDates()
  {
    $dates = [null => 'Toutes les dates'];
    $foodGiven = (new FoodGivenModel())->getAllFoodGiven();

    foreach ($foodGiven as $entry) {
      $dates[$entry->day] = $entry->day;
    }

    return $dates;
  }
}
