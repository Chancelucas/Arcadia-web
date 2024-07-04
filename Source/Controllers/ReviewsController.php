<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\Controller;
use Source\Models\reviews\ReviewsModel;

class ReviewsController extends Controller
{

  /**
   * Displays WelcomPage
   */
  public function index()
  {
    $formReviews = $this->generateFormReviews();

    $this->render('reviews/reviews', [
      'formReviews' => $formReviews,

    ]);
  }


  private function generateFormReviews()
  {

    $form = new Form;

    $form->startForm('POST', 'reviews/createReviews')

      ->startDiv(['class' => 'div_create_user'])
      ->addInput('text', 'pseudo', ['id' => 'pseudo', 'placeholder' => 'Nom', 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'div_create_user'])
      ->addInput('text', 'review', ['placeholder' => 'Commentaire', 'required' => true])
      ->endDiv()

      ->startDiv(['class' => 'input_btn_login input_login div_create_user'])
      ->addBouton('Envoyer', ['type' => 'submit', 'value' => 'submit', 'name' => 'createReviews'])
      ->endDiv()

      ->endForm();


    return $form->create();
  }

  public function createReviews()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createReviews'])) {
      $pseudo = $_POST['pseudo'];
      $comment = $_POST['review'];
      $status = 0;

      $existingReviews = (new ReviewsModel)->findOneByPseudo($pseudo);

      if (!is_null($existingReviews)) {
        echo "Un avis a déjà était poser avec ce pseudo.";
        return;
      } else {

        try {
          $reviewModel = new ReviewsModel;

          $reviewModel->setPseudo($pseudo)
            ->setReview($comment)
            ->setStatus($status);

          $reviewModel->createReviews();

          $_SESSION['message'] = "Votre avis à été créé avec succès.";
        } catch (\Exception $e) {

          $_SESSION['error'] = "Une erreur s'est produite lors de la création de votre avis : " . $e->getMessage();
        }
      }
    } else {
      $_SESSION['error'] = "Aucun avis n'a été renseigné";
    }

    header("Location: /reviews");
    exit;
  }
}
