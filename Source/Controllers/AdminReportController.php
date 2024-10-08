<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\filter\FilterModel;
use Source\Controllers\AdminController;
use Source\Models\report\AnimalReportModel;
use Source\Models\report\HabitatReportModel;

class AdminReportController extends AdminController
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $filterAnimalReportVet = (new FilterModel())->filterReportAnimalVet();
    $filterFormReportAnimal = $this->createFilterFormReportAnimal();

    $filterHabitatReportVet = (new FilterModel())->filterReportHabitatVet();
    $filterFormReportHabitat = $this->createFilterFormReportHabitat();


    $this->render('report/adminReport', [
      'animalsReport' => $filterAnimalReportVet,
      'filterFormReportAnimal' => $filterFormReportAnimal,

      'reportsHabitat' => $filterHabitatReportVet,
      'filterFormReportHabitat' => $filterFormReportHabitat,

    ]);
  }

  public function getAllAnimalReport()
  {
    $model = new AnimalReportModel;
    $animalsReport = $model->getAllAnimalsReports();

    return $animalsReport;
  }

  public function getAllHabitatReport()
  {
    $model = new HabitatReportModel;
    $habitatReport = $model->getAllHabitatReport();

    return $habitatReport;
  }

  private function createFilterFormReportAnimal()
  {
    $form = new Form();

    $form->startForm('POST', '' ,['class' => 'form_report_admin'])

      ->startDiv(['class' => 'div_form_report_admin'])
      ->addLabelFor('animal_date', 'Date du rapport')
      ->addSelect('animal_date', $this->getAllDatesAnimalReport(), ['value' => $_POST['date'] ?? null, 'class' => 'input_report_admin'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_report_admin'])
      ->addLabelFor('animal', 'Animal')
      ->addSelect('animal', $this->getAllAnimalBreeds(), ['value' => $_POST['animal'] ?? null, 'class' => 'input_report_admin'])
      ->endDiv()

      ->startDiv(['class' => 'div_btn_form_report_admin'])
      ->addBouton('Rechercher', ['type' => 'submit', 'value' => 'search', 'name' => 'createGivenFood', 'class' => 'btn btn_search_report_admin'])
      ->endDiv()

      ->endForm();

    return $form->create();
  }

  private function createFilterFormReportHabitat()
  {
    $form = new Form();

    $form->startForm('POST', '' ,['class' => 'form_report_admin'])

    ->startDiv(['class' => 'div_form_report_admin'])
      ->addLabelFor('habitat_date', 'Date du rapport')
      ->addSelect('habitat_date', $this->getAllDatesHabitatReport(), ['value' => $_POST['date'] ?? null, 'class' => 'input_report_admin'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_report_admin'])
      ->addLabelFor('habitat', 'Habitat')
      ->addSelect('habitat', $this->getAllNameHabitat(), ['value' => $_POST['habitat'] ?? null, 'class' => 'input_report_admin'])
      ->endDiv()

      ->startDiv(['class' => 'div_btn_form_report_admin'])
      ->addBouton('Rechercher', ['type' => 'submit', 'value' => 'search', 'name' => 'createGivenFood', 'class' => 'btn btn_search_report_admin'])
      ->endDiv()

      ->endForm();

    return $form->create();
  }

  private function getAllDatesAnimalReport()
  {
    return (new FilterModel([]))->getAllReportAnimalDate();
  }

  private function getAllDatesHabitatReport()
  {
    return (new FilterModel([]))->getAllReportHabitatDate();
  }

  private function getAllAnimalBreeds()
  {
    return (new FilterModel([]))->getAllAnimalBreeds();
  }

  private function getAllNameHabitat()
  {
    return (new FilterModel([]))->getAllNameHabitat();
  }
}
