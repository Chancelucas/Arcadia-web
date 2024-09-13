<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\AdminController;
use Source\Models\hour\HourModel;
use function Source\Helpers\securityHTML;

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
      ->endDiv();

    return $form->create();
  }

  public function createHour()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createHour'])) {
      $day = $_POST['day'];
      $opening_time = $_POST['opening_time'];
      $closing_time = $_POST['closing_time'];

      $existingHour = (new HourModel)->findOneByDay($day);

      if (!is_null($existingHour)) {
        echo "Le jour d'ouverture à déjà utilisé.";
        return;
      } else {

        try {
          $hour = new HourModel;

          $hour->setDay($day)
            ->setOpeningTime($opening_time)
            ->setClosingTime($closing_time);

          $hour->createHour();

          $_SESSION['message'] = "Le jour d'ouverture du zoo a été créé avec succès.";
        } catch (\Exception $e) {

          $_SESSION['error'] = "Une erreur s'est produite lors de la création du jour d'ouverture du zoo : " . $e->getMessage();
        }
      }
    } else {
      $_SESSION['error'] = "Aucun jour d'ouverture n'a été renseigné";
    }

    Header("Location: /adminHour");
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

      $hourModel->setId($hourId);
      $deleteHour = $hourModel->delete();

      if ($deleteHour) {
        $_SESSION['message'] = "✅ Le jour d'ouverture à bien été supprimé avec succès.";
      } else {
        $_SESSION['error'] = "❌ Une erreur s'est produite lors de la suppression du jour d'ouverture.";
      }
    }

    Header("Location: /adminHour");
    exit;
  }
}
