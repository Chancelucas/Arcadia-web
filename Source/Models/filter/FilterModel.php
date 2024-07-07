<?php

namespace Source\Models\filter;

use Source\Models\MainModel;
use Source\Models\role\RoleModel;
use Source\Models\user\UserModel;
use Source\Models\animal\AnimalModel;
use Source\Models\habitat\HabitatModel;
use Source\Models\animal\FoodGivenModel;
use Source\Models\report\AnimalReportModel;
use Source\Models\report\HabitatReportModel;

class FilterModel extends MainModel
{

  ///////////////////  Filtre for employee food given ////////////////////


  public function filterFoodGiven()
  {
    $foodGiven = (new FoodGivenModel())->getAllFoodGiven();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $selectedEmployee = $_POST['employee'] ?? null;
      $selectedDate = $_POST['date'] ?? null;
      $selectedAnimal = $_POST['animal'] ?? null;

      return array_filter($foodGiven, function ($entry) use ($selectedEmployee, $selectedDate, $selectedAnimal) {
        return $this->matchesCriteriaFoodGiven($entry, $selectedEmployee, $selectedDate, $selectedAnimal);
      });
    }

    return $foodGiven;
  }


  private function matchesCriteriaFoodGiven($entry, $selectedEmployee, $selectedDate, $selectedAnimal)
  {
    $employeeMatch = !$selectedEmployee || $entry->user->getId() == $selectedEmployee;
    $dateMatch = !$selectedDate || $entry->day === $selectedDate;
    $animalMatch = !$selectedAnimal || (string)$entry->animal->getId() === (string)$selectedAnimal;

    return $employeeMatch && $dateMatch && $animalMatch;
  }

  public function getAllEmployeeUsername()
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

  public function getAllAnimalBreeds()
  {
    return [null => 'Tous'] + (new AnimalModel())->getAllBreedAnimals();
  }

  public function getAllDatesFoodGiven()
  {
    $dates = [null => 'Toutes les dates'];
    $foodGiven = (new FoodGivenModel())->getAllFoodGiven();

    foreach ($foodGiven as $entry) {
      $dates[$entry->day] = $entry->day;
    }

    return $dates;
  }

  ///////////////////  Filtre for vet report Animal ////////////////////

  public function filterReportAnimalVet()
  {
    $report = (new AnimalReportModel())->getAllAnimalsReports();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $selectedDate = $_POST['animal_date'] ?? null;
      $selectedAnimal = $_POST['animal'] ?? null;


      return array_filter($report, function ($entry) use ($selectedDate, $selectedAnimal) {
        return $this->matchesCriteriaReportAnimalVet($entry, $selectedDate, $selectedAnimal);
      });
    }


    return $report;
  }

  private function matchesCriteriaReportAnimalVet($entry, $selectedDate, $selectedAnimal)
  {
    $dateMatch = !$selectedDate || $entry->passage_date === $selectedDate;
    $animalMatch = !$selectedAnimal || (string)$entry->id_animal === (string)$selectedAnimal;

    return $dateMatch && $animalMatch;
  }


  public function getAllReportAnimalDate()
  {
    $dates = [null => 'Toutes les dates'];
    $foodGiven = (new AnimalReportModel())->getAllAnimalsReports();

    foreach ($foodGiven as $entry) {
      $dates[$entry->passage_date] = $entry->passage_date;
    }

    return $dates;
  }

  ///////////////////  Filtre for vet report Habitat ////////////////////


  public function filterReportHabitatVet()
  {
    $report = (new HabitatReportModel())->getAllHabitatReport();

    //Il faut recupré aussi les rapport des habitat grace a son model

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $selectedDate = $_POST['habitat_date'] ?? null;
      $selectedHabitat = $_POST['habitat'] ?? null;


      return array_filter($report, function ($entry) use ($selectedDate, $selectedHabitat) {
        return $this->matchesCriteriaReportHabitatVet($entry, $selectedDate, $selectedHabitat);
      });
    }

    return $report;
  }

  private function matchesCriteriaReportHabitatVet($entry, $selectedDate, $selectedHabitat)
  {
    $dateMatch = !$selectedDate || $entry->date === $selectedDate;
    $habitatMatch = !$selectedHabitat || $entry->id_habitat === $selectedHabitat;

    return $dateMatch && $habitatMatch;
  }

  public function getAllNameHabitat()
  {
    return [null => 'Tous'] + (new HabitatModel())->getAllNameHabitat();
  }

  public function getAllReportHabitatDate()
  {
    $dates = [null => 'Toutes les dates'];
    $foodGiven = (new HabitatReportModel())->getAllHabitatReport();

    foreach ($foodGiven as $entry) {
      $dates[$entry->date] = $entry->date;
    }

    return $dates;
  }

  /////////////////// Filtre for user role ////////////////////


  public function filterAllUserOfRole($selectedRole)
  {
    $users = (new UserModel())->getAllUsers();

    if ($selectedRole === 'Tous' || is_null($selectedRole)) {
      return $users;
    }

    return array_filter($users, function ($user) use ($selectedRole) {
      return $user->role === $selectedRole;
    });
  }
}
