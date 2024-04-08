<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Models\user\UserModel;
use Source\Controllers\AdminController;
use Source\Models\templates\AnimalModel;

class AdminHabitatController extends AdminController
{

    public function index()
    {
        $createHabitatForm = $this->generateCreateHabitatForm();
        $this->render('habitat/adminHabitat', ['createHabitatForm' => $createHabitatForm], 'defaultSessionPage');
    }

    public function generateCreateHabitatForm()
    {
        $animals = $this->getAnimalsFromDatabas();
        $form = new Form;

        $form->startForm('POST', '')
            ->addInput('text', 'habitat_name', ['class' => 'habitat_form_input', 'id' => 'habitat_name', 'placeholder' => 'Ajouter un nom', 'required'])
            ->addTextarea('habitat_description', '', ['class' => 'habitat_form_input', 'id' => 'habitat_description', 'name' => 'habitat_description', 'placeholder' => 'Ajouter une description', 'required'] )
            ->addSelect('animals', $animals, ['id' => 'habitat_add_animals', 'class' => 'habitat_form_input'])
            ->startDiv(['id' => 'div_add_doc_habitat'])
            ->addInput('file', 'habitat_photo', ['id' => 'habitat_add_picture', 'class' => 'habitat_form_input', 'multiple'])
            ->addLabelFor('habitat_add_picture', 'Choisir des photos')
            ->endDiv()
            ->addBouton('Enregistrer', ['type' => 'submit', 'name' => 'enregistrer', 'id' => 'habitat_btn_save', 'class' => 'habitat_form_input'])
            ->endForm();

        return $form->create();


    }

    public function getAnimalsFromDatabas()
    {
        $animalModel = new UserModel;
        $animals = $animalModel->getAll();

        $animalsList = [];

        foreach ($animals as $animal){
            $animalsList[$animal->getId()] = $animal->animal;
        }
        return $animalsList;
    }
}