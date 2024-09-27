<?php

namespace Source\Controllers;

use Source\Controllers\Controller;
use Source\Models\animal\AnimalModel;
use Source\Models\habitat\HabitatModel;
use Source\Helpers\FlashMessage;


class HabitatController extends Controller
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $habitat = $this->getAllHabitat();

    $this->render('habitat/habitat', [
      'allHabitats' => $habitat,
    ]);
  }

  public function page(int $idHabitat)
  {
    $habitat = $this->getIdHabitat($idHabitat);
    $animalsInHabitat = $this->showHabitatWithAnimals($idHabitat);


    $this->render('habitat/page', [
      'habitat' => $habitat,
      'animalsInHabitat' => $animalsInHabitat
    ]);
  }

  private function getAllHabitat()
  {
    $model = new HabitatModel;
    $allHabitats = $model->getAllWithAnimals();

    return $allHabitats;
  }

  private function getIdHabitat(int $idHabitat)
  {
    $model = (new HabitatModel)->findBy(['id' => $idHabitat])[0];

    return $model;
  }

  private function showHabitatWithAnimals($idHabitat)
  {
    $habitatModel = new HabitatModel();
    $habitat = $habitatModel->findOneById($idHabitat);

    if (!$habitat) {
      FlashMessage::addMessage("Aucun habitat n'a était trouvé.", 'warning');
    }

    $animalModel = new AnimalModel();
    $allAnimals = $animalModel->getAllAnimals();

    $animalsInHabitat = [];
    foreach ($allAnimals as $animal) {
      if ($animal->id_Habitat == $idHabitat) {
        $animalsInHabitat[] = $animal;
      }
    }
    return $animalsInHabitat;
  }
}
