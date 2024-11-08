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
      'filterForm' => $filterForm,
      'user' => $this->user
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

    $form->startForm('POST', '' , ['class' => 'form_foodgiven_vet'])

      ->startDiv(['class' => 'div_form_foodgiven_vet'])
      ->addLabelFor('employee', 'Employé')
      ->addSelect('employee', $this->getAllUsername(), ['value' => $_POST['employee'] ?? null, 'class' => 'input_foodgiven_vet'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_foodgiven_vet'])
      ->addLabelFor('date', 'Date du repas')
      ->addSelect('date', $this->getAllDates(), ['value' => $_POST['date'] ?? null, 'class' => 'input_foodgiven_vet'])
      ->endDiv()
      
      ->startDiv(['class' => 'div_form_foodgiven_vet'])
      ->addLabelFor('animal', 'Animal nourri')
      ->addSelect('animal', $this->getAllAnimalBreeds(), ['value' => $_POST['animal'] ?? null, 'class' => 'input_foodgiven_vet'])
      ->endDiv()
      
      ->startDiv(['class' => 'div_btn_form_foodgiven_vet '])
      ->addBouton('Rechercher', ['type' => 'submit', 'value' => 'search', 'name' => 'createGivenFood', 'class' => 'btn btn_search_foodgiven_vet'])
      ->endDiv()

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
