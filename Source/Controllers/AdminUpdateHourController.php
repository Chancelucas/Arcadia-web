<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\AdminController;
use Source\Models\hour\HourModel;
use function Source\Helpers\securityHTML;

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

    $form->startForm('POST', "/adminUpdateHour/updateHour/{$hourId}", ['class' => 'form_update_hour_admin'])

      ->startDiv(['class' => 'div_form_update_hour_admin'])
      ->addLabelFor('day', 'Jour :')
      ->addInput('text', 'day', ['class' => 'input_form_update_hour_admin', 'value' => $day, 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_form_update_hour_admin'])
      ->addLabelFor('opening_time', 'Heure d\'ouvertrure :')
      ->addInput('time', 'opening_time', ['class' => 'input_form_update_hour_admin', 'value' => $openingTime, 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_form_update_hour_admin'])
      ->addLabelFor('closing_time', 'Heure de fermeture :')
      ->addInput('time', 'closing_time', ['class' => 'input_form_update_hour_admin', 'value' => $closingTime, 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_form_update_hour_admin btn_update_hour_admin'])
      ->addBouton('Enregistrer', ['type' => 'submit', 'name' => 'save_changes', 'class' => 'btn '])
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
