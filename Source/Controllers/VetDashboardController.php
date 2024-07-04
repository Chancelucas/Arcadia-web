<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Helpers\FilterHelper;
use Source\Controllers\VetController;
use Source\Models\filter\FilterModel;
use Source\Models\animal\FoodGivenModel;

class VetDashboardController extends VetController
{

  /**
   * Index function on Admin Dashboard Controller
   */
  public function index()
  {

    $filterFoodGiven = $this->filterFoodGiven();
    $filterForm = $this->createFilterForm();

    $this->render('dashboard/vetDashboard', [
      'allFoodGiven' => $filterFoodGiven,
      'filterForm' => $filterForm
    ]);

  }

  /**
   * Function logout [session = 'user']
   */
  public function logout()
  {
    session_destroy();
    header("Location: /login");
    exit;
  }

  /**
   * Form for logout session
   */
  private function generateLogoutForm()
  {
    $form = new Form;

    $form->startForm('POST', 'vetDashboard/logout')

      ->addBouton('Déconnexion', ['type' => 'submit'])

      ->endForm();
    
      return $form->create();

  }

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

  private function filterFoodGiven()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $selectedEmployee = $_POST['employee'] ?? null;
      $selectedDate = $_POST['date'] ?? null;
      $selectedAnimal = $_POST['animal'] ?? null;

      return FilterHelper::filterFoodGiven($selectedEmployee,  $selectedDate, $selectedAnimal);
    }
  }

  private function getAllUsername()
  {
    return (new FilterModel([]))->getAllEmployeeUsername();
  }

  private function getAllAnimalBreeds()
  {
    return (new FilterModel([]))->getAllAnimalBreeds();
    
  }

  private function getAllDates()
  {
    return (new FilterModel([]))->getAllDatesFoodGiven();
   
  }


  private function allFoodGivenReport()
  {
   $allFoodeGiven = (new FoodGivenModel())->getAllFoodGiven();
   return $allFoodeGiven;
  }
}


