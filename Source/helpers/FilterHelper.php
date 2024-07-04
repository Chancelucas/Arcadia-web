<?php

namespace Source\Helpers;

use Source\Helpers\CacheHelper;
use Source\Models\role\RoleModel;
use Source\Models\user\UserModel;
use Source\Models\animal\AnimalModel;
use Source\Models\habitat\HabitatModel;
use Source\Models\animal\FoodGivenModel;
use Source\Models\report\AnimalReportModel;
use Source\Models\report\HabitatReportModel;

class FilterHelper
{
  /////////////////// Filtre for employee food given ////////////////////

  /**
   * Filtre les entrées de nourriture donnée en fonction des critères sélectionnés.
   *
   * @param string $selectedEmployee L'ID de l'employé sélectionné, ou null pour ne pas filtrer par employé.
   * @param string $selectedDate La date sélectionnée au format 'Y-m-d', ou null pour ne pas filtrer par date.
   * @param string $selectedAnimal L'ID de l'animal sélectionné, ou null pour ne pas filtrer par animal.
   * @return array Un tableau des entrées de nourriture donnée qui correspondent aux critères.
   */
  public static function filterFoodGiven(string $selectedEmployee, string $selectedDate, string $selectedAnimal)
  {
    $foodGivenModel = new FoodGivenModel();

    // check cache
    $key = $foodGivenModel->getCacheKey();
    $foodGiven = CacheHelper::get($key);

    if ($foodGiven === false) {
      $foodGiven = $foodGivenModel->getAllFoodGiven();
      CacheHelper::set($key, $foodGiven);
    }

    return array_filter($foodGiven, function ($entry) use ($selectedEmployee, $selectedDate, $selectedAnimal) {
      return FilterHelper::matchesCriteriaFoodGiven($entry, $selectedEmployee, $selectedDate, $selectedAnimal);
    });

    return $foodGiven;
  }

  /**
   * Vérifie si une entrée de nourriture donnée correspond aux critères sélectionnés.
   *
   * @param object $entry Une entrée de nourriture donnée.
   * @param int $selectedEmployee L'ID de l'employé sélectionné, ou null pour ne pas filtrer par employé.
   * @param string $selectedDate La date sélectionnée au format 'Y-m-d', ou null pour ne pas filtrer par date.
   * @param int $selectedAnimal L'ID de l'animal sélectionné, ou null pour ne pas filtrer par animal.
   * @return bool True si l'entrée correspond aux critères, sinon false.
   */
  private static function matchesCriteriaFoodGiven(object $entry, string $selectedEmployee, string $selectedDate, string $selectedAnimal)
  {
    $employeeMatch = !$selectedEmployee || $entry->user->id == $selectedEmployee;
    $dateMatch = !$selectedDate || $entry->day === $selectedDate;
    $animalMatch = !$selectedAnimal || (string)$entry->animal->id === (string)$selectedAnimal;

    return $employeeMatch && $dateMatch && $animalMatch;
  }

  /**
   * Récupère tous les noms d'utilisateur des employés.
   *
   * Cette méthode statique obtient les noms d'utilisateur de tous les employés
   * ayant le rôle "Employer". Elle retourne un tableau où la clé est l'ID de
   * l'utilisateur et la valeur est le nom d'utilisateur. La première entrée du
   * tableau est `null` avec la valeur 'Tous'.
   *
   * @return array Un tableau associatif où les clés sont les IDs des utilisateurs
   *               et les valeurs sont les noms d'utilisateur. La première entrée
   *               est `null` avec la valeur 'Tous'.
   */
  public static function getAllEmployeeUsername()
  {
    $role = "Employer";
    $roleModel = (new RoleModel())->findOneByRole($role);
    $roleId = $roleModel->getId();

    $usersModel = (new UserModel())->getAllByRole($roleId);

    $b = [];
    foreach ($usersModel as $user) {
      $b[$user->getId()] = $user->getUsername();
    }

    return [null => 'Tous'] + $b;
  }


  public static function getAllAnimalBreeds()
  {
    return [null => 'Tous'] + (new AnimalModel())->getAllBreedAnimals();
  }

  public static function getAllDatesFoodGiven()
  {
    $dates = [null => 'Toutes les dates'];
    $foodGiven = (new FoodGivenModel())->getAllFoodGiven();

    foreach ($foodGiven as $entry) {
      $dates[$entry->day] = $entry->day;
    }

    return $dates;
  }

  ///////////////////  Filtre for vet report Animal////////////////////

  public static function filterReportAnimalVet($selectedDate, $selectedAnimal)
  {
    $report = (new AnimalReportModel())->getAllAnimalsReports();

    return array_filter($report, function ($entry) use ($selectedDate, $selectedAnimal) {
      return FilterHelper::matchesCriteriaReportAnimalVet($entry, $selectedDate, $selectedAnimal);
    });

    return $report;
  }

  private static function matchesCriteriaReportAnimalVet($entry, $selectedDate, $selectedAnimal)
  {
    $dateMatch = !$selectedDate || $entry->passage_date === $selectedDate;
    $animalMatch = !$selectedAnimal || (string)$entry->id_animal === (string)$selectedAnimal;

    return $dateMatch && $animalMatch;
  }


  public static function getAllReportAnimalDate()
  {
    $dates = [null => 'Toutes les dates'];
    $foodGiven = (new AnimalReportModel())->getAllAnimalsReports();

    foreach ($foodGiven as $entry) {
      $dates[$entry->passage_date] = $entry->passage_date;
    }

    return $dates;
  }

  ///////////////////  Filtre for vet report Habitat////////////////////


  public static function filterReportHabitatVet($selectedDate, $selectedHabitat)
  {
    $report = (new HabitatReportModel())->getAllHabitatReport();

    return array_filter($report, function ($entry) use ($selectedDate, $selectedHabitat) {
      return FilterHelper::matchesCriteriaReportHabitatVet($entry, $selectedDate, $selectedHabitat);
    });

    return $report;
  }

  private static function matchesCriteriaReportHabitatVet($entry, $selectedDate, $selectedHabitat)
  {
    $dateMatch = !$selectedDate || $entry->date === $selectedDate;
    $habitatMatch = !$selectedHabitat || $entry->id_habitat === $selectedHabitat;

    return $dateMatch && $habitatMatch;
  }

  public static function getAllNameHabitat()
  {
    return [null => 'Tous'] + (new HabitatModel())->getAllNameHabitat();
  }

  public static function getAllReportHabitatDate()
  {
    $dates = [null => 'Toutes les dates'];
    $foodGiven = (new HabitatReportModel())->getAllHabitatReport();

    foreach ($foodGiven as $entry) {
      $dates[$entry->date] = $entry->date;
    }

    return $dates;
  }
}
