<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Helpers\InputType;
use Source\Helpers\FlashMessage;
use Source\Models\hour\HourModel;
use Source\Helpers\SecurityHelper;
use Source\Controllers\AdminController;

class AdminHourController extends AdminController
{
  public function index()
  {
    $createHourForm = $this->generateHourForm();
    $hours = $this->getAllHours();
    $this->render('hour/adminHour', [
      'createHourForm' => $createHourForm,
      'hours' => $hours
    ]);
  }


  public function generateHourForm()
  {
    $form = new Form;

    $form->startForm('POST', 'adminHour/createHour', ['class' => 'form_create_hour_admin'])

      ->startDiv(['class' => 'div_form_hour_admin'])
      ->addInput('text', 'day', ['placeholder' => 'Jour', 'required' => true, 'class' => 'input_create_hour_admin'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_hour_admin'])
      ->addLabelFor('opening_time', 'Heure d\'ouverture :')
      ->addInput('time', 'opening_time', ['placeholder' => 'Heure d\'ouverture', 'required' => true, 'class' => 'input_create_hour_admin'])
      ->endDiv()


      ->startDiv(['class' => 'div_form_hour_admin'])
      ->addLabelFor('closing_time', 'Heure de fermeture :')
      ->addInput('time', 'closing_time', ['placeholder' => 'Heure de fermeture', 'required' => true, 'class' => 'input_create_hour_admin'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_hour_admin'])
      ->addBouton('Créer', ['type' => 'submit', 'value' => 'submit', 'class' => 'btn btn_add_hour_admin', 'name' => 'createHour'])
      ->endDiv()
      
      ->endForm();

    return $form->create();
  }

  public function createHour()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createHour'])) {

      $day = SecurityHelper::sanitize(InputType::String, 'day');
      $opening_time = SecurityHelper::sanitize(InputType::String, 'opening_time');
      $closing_time = SecurityHelper::sanitize(InputType::String, 'closing_time');

      $existingHour = (new HourModel)->findOneByDay($day);

      if (!is_null($existingHour)) {
        FlashMessage::addMessage("Le jour d'ouverture à déjà était crée utilisé.", 'error');
        return;
      } else {

        try {
          $hour = new HourModel;

          $hour->setDay($day)
            ->setOpeningTime($opening_time)
            ->setClosingTime($closing_time);

          $hour->createHour();
          FlashMessage::addMessage("Le jour d'ouverture du zoo a été créé avec succès.", 'success');
        } catch (\Exception $e) {
          FlashMessage::addMessage("Une erreur s'est produite lors de la création du jour d'ouverture du zoo.", 'error');
        }
      }
    } else {
      FlashMessage::addMessage("Aucun jour d'ouverture n'a été renseigné.", 'error');
    }
    header("Location: /adminHour");
    exit;
  }

  /**
   * Get all hour  
   */
  private function getAllHours()
  {
    $model = new HourModel;
    $allHours = $model->getAllHours();

    return $allHours;
  }

  /**
   * Delete One Day
   */
  public function deleteHour(int $hourId)
  {
    if (isset($_POST['deleteHour'])) {
      $hourModel = new HourModel;
      $hourModel->setIdHour($hourId);
      $deleteHour = $hourModel->delete();
      

      if ($deleteHour) {
        FlashMessage::addMessage("Une erreur s'est produite lors de la suppression du jour d'ouverture.", 'error');
      } else {
        FlashMessage::addMessage("Le jour d'ouverture a bien été supprimé avec succès.", 'success');
      }
    }
    header("Location: /adminHour");
    exit;
  }
}
