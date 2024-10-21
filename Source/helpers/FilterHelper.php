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


  private static function matchesCriteriaFoodGiven(object $entry, string $selectedEmployee, string $selectedDate, string $selectedAnimal)
  {
    $employeeMatch = !$selectedEmployee || $entry->user->id == $selectedEmployee;
    $dateMatch = !$selectedDate || $entry->day === $selectedDate;
    $animalMatch = !$selectedAnimal || (string)$entry->animal->id === (string)$selectedAnimal;

    return $employeeMatch && $dateMatch && $animalMatch;
  }


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
