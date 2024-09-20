<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Controllers\Controller;
use Source\Models\reviews\ReviewsModel;
use Source\Helpers\securityHTML;

class ReviewsController extends Controller
{

  /**
   * Displays WelcomPage
   */
  public function index()
  {
    $formReviews = $this->generateFormReviews();
    $reviews = $this->getAllValableReview();
    $formContact = $this->generateFormContact();


    $this->render('reviews/reviews', [
      'formReviews' => $formReviews,
      'allReviews' => $reviews,
      'formContact' => $formContact,

    ]);
  }


  private function generateFormReviews()
  {

    $form = new Form;

    $form->startForm('POST', 'reviews/createReviews', ['class' => 'form_reviews_page'])

      ->startDiv(['class' => 'div_form_reviews_page'])
      ->addInput('text', 'pseudo', ['id' => 'pseudo', 'placeholder' => 'Nom', 'required' => true, 'class' => 'input_form_reviews_page'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_reviews_page'])
      ->addInput('text', 'review', ['placeholder' => 'Commentaire', 'required' => true, 'class' => 'input_form_reviews_page reviews_input'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_reviews_page'])
      ->addBouton('Envoyer', ['type' => 'submit', 'value' => 'submit', 'name' => 'createReviews', 'class' => 'btn'])
      ->endDiv()

      ->endForm();


    return $form->create();
  }

  public function createReviews()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['createReviews'])) {
      $pseudo = $_POST['pseudo'];
      $comment = $_POST['review'];
      $status = false;

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

  private function getAllValableReview()
  {
    $enableReviews = (new ReviewsModel)->findBy(['status' => true]);
    return $enableReviews;
  }

  private function generateFormContact()
  {
    $form = new Form;

    $form->startForm('POST', 'reviews/createReviews', ['class' => 'form_reviews_page'])

      ->startDiv(['class' => 'div_form_reviews_page'])
      ->addInput('email', 'email', ['id' => 'pseudo', 'placeholder' => 'Email', 'required' => true, 'class' => 'input_form_reviews_page'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_reviews_page'])
      ->addInput('text', 'title', ['placeholder' => 'Titre du message', 'required' => true, 'class' => 'input_form_reviews_page'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_reviews_page'])
      ->addInput('text', 'comment', ['placeholder' => 'Votre message', 'required' => true, 'class' => 'input_form_reviews_page reviews_input'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_reviews_page'])
      ->addBouton('Envoyer', ['type' => 'submit', 'value' => 'submit', 'name' => 'createReviews', 'class' => 'btn'])
      ->endDiv()

      ->endForm();


    return $form->create();
  }
}
