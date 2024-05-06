<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\AdminController;
use Source\Models\hour\HourModel;

class AdminUpdateHourController extends AdminController
{
  public function index(int $id)
  {
    $hourModel = new HourModel;
    $hour = $hourModel->findOneById($id);

    $day = $hour->getDay();
    $openingTime = $hour->getOpeningTime();
    $closingTime = $hour->getClosingTime();

    $hourForm = $this->createForm($id, $day, $openingTime, $closingTime);

    $this->render('hour/adminUpdateHour', ['hourForm' => $hourForm]);
  }

  /**
   * Generate update hour form
   */
  public function createForm($hourId, $day, $openingTime, $closingTime)
  {

    $form = new Form;

    $form->startForm('POST', "/adminUpdateHour/updateHour/{$hourId}", ['id' => 'form_update_hour'])

      ->startDiv(['class' => 'div_form_update_hour'])
      ->addLabelFor('day', 'Jour :')
      ->addInput('text', 'day', ['id' => 'day', 'class' => 'input_form_update_hour', 'value' => $day, 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_form_update_hour'])
      ->addLabelFor('opening_time', 'Heure d\'ouvertrure :')
      ->addInput('time', 'opening_time', ['id' => 'opening_time', 'class' => 'input_form_update_hour', 'value' => $openingTime, 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_form_update_hour'])
      ->addLabelFor('closing_time', 'Heure de fermeture :')
      ->addInput('time', 'closing_time', ['id' => 'closing_time', 'class' => 'input_form_update_hour', 'value' => $closingTime, 'required' => true])
      ->endDiv()

      ->startDiv(['id' => 'div_id_update_hour', 'class' => 'div_class_update_hour'])
      ->addBouton('Enregistrer', ['type' => 'submit', 'name' => 'save_changes', 'id' => 'btn_update_hour'])
      ->endDiv()

      ->endForm();

    return $form->create();
  }

  /**
   * update One Day
   */
  public function updateHour(int $hourId)
  {
    if (isset($_POST['save_changes'])) {
      $day = $_POST['day'];
      $openingTime = $_POST['opening_time'];
      $closingTime = $_POST['closing_time'];

      $hourModel = new HourModel;
      $hourModel->findOneById($hourId);

      $hourModel->setDay($day)
        ->setOpeningTime($openingTime)
        ->setClosingTime($closingTime);

      $updateResult = $hourModel->update($hourId);

      if ($updateResult) {
        header("Location: /adminHour");
        exit;
      } else {
        $_SESSION['error'] = "Une erreur s'est produite lors de la modification des jours d'ouverture.";
      }
    }

    Header("Location: /adminUpdateHour");
    exit;
  }
}
