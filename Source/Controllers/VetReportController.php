<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\VetController;

class VetReportController extends VetController
{

  public function index()
  {
    $createReportAnimalForm = $this->generateCreateReportAnimalForm();
    $this->render('report/report', ['createReportAnimalForm' => $createReportAnimalForm]);
  }

  /**
   * Function with form for create Animal
   */
  private function generateCreateReportAnimalForm()
  {
    $form = new Form;

    // J'EN SUIS ICI, modification de l'id dans le startForm

    $form->startForm('POST', 'vetReport/createAnimalReport', ['id' => 'form_animal', 'enctype' => 'multipart/form-data'])

      ->addInput('text', 'name', ['class' => 'animal_form_input', 'id' => 'animal_name', 'placeholder' => 'Ajouter un nom', 'required'])

      ->addInput('text', 'breed', ['class' => 'animal_form_input', 'id' => 'animal_breed', 'name' => 'animal_breed', 'placeholder' => 'Ajouter une race animal', 'required'])

      ->startDiv(['id' => 'div_add_doc_animal'])
      ->addInput('file', 'picture', ['id' => 'animal_add_picture', 'class' => 'animal_form_input', 'multiple' => true])
      ->endDiv()

      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'id' => 'animal_btn_save', 'name' => 'createAnimal', 'class' => 'animal_form_input'])

      ->endForm();

    return $form->create();
  }

  private function createAnimalReport()
  {
  
  }
}


//Faire une fonction pour faire un rapport sur les animaux et une autre function pour faire des raports sur les habitats. 