<?php

namespace Source\Controllers;

use Lib\config\Form;
use Source\Helpers\InputType;
use Lib\config\PhpMailerConfig;
use Source\Helpers\FlashMessage;
use Source\Controllers\Controller;
use Source\Helpers\SecurityHelper;
use Source\Models\reviews\ReviewsModel;


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

      ->addError('pseudo', $this->error)
      ->addError('review', $this->error)

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
      $pseudo = SecurityHelper::sanitize(InputType::String, 'pseudo');
      $comment = SecurityHelper::sanitize(InputType::String, 'review');

      $status = false;

      if (!$pseudo) {
        $this->error["pseudo"] = "Champ nom non remplie";
      }
      if (!$comment) {
        $this->error["review"] = "Commentaire non valide";
      }

      $existingReviews = (new ReviewsModel)->findOneByPseudo($pseudo);

      if (!is_null($existingReviews)) {
        FlashMessage::addMessage("Un avis a déjà était poser avec ce nom", 'error');
        $this->index();
        exit;
      } else {
        try {
          $reviewModel = new ReviewsModel;

          $reviewModel->setPseudo($pseudo)
            ->setReview($comment)
            ->setStatus($status);

          $reviewModel->createReviews();
          FlashMessage::addMessage("Votre avis à été créé avec succès.", 'success');
        } catch (\Exception $e) {
          FlashMessage::addMessage("Une erreur s'est produite lors de la création de votre avis.", 'error');
        }
      }
    } else {
      FlashMessage::addMessage("Aucun avis n'a été renseigné.", 'warning');
    }

    $this->index();
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

    $form->startForm('POST', 'reviews/sendMessage', ['class' => 'form_reviews_page'])

      ->addError('email', $this->error)
      ->addError('title', $this->error)
      ->addError('comment', $this->error)

      ->startDiv(['class' => 'div_form_reviews_page'])
      ->addInput('email', 'email', ['id' => 'pseudo', 'placeholder' => 'Email', 'required' => true, 'class' => 'input_form_reviews_page'])
      ->endDiv()

      ->startDiv(['class' => 'div_form_reviews_page'])
      ->addInput('text', 'subject', ['placeholder' => 'Sujet du message', 'required' => true, 'class' => 'input_form_reviews_page'])
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

  public function sendMessage()
  {
    $email =  SecurityHelper::sanitize(InputType::String, 'email') ?? null;
    $subject = SecurityHelper::sanitize(InputType::String, 'subject') ?? null;
    $message = SecurityHelper::sanitize(InputType::String, 'comment') ?? null;

    if (!$email || !$subject || !$message) {
      FlashMessage::addMessage("Tous les champs doivent être remplis.", 'error');
      $this->index();
      exit;
    }

    $body = "
        <h3>Nouvelle demande de contact</h3>
        <p><strong>Email de l'expéditeur :</strong> {$email}</p>
        <p><strong>Sujet :</strong> {$subject}</p>
        <p><strong>Message :</strong></p>
        <p>{$message}</p>
    ";

    // Utilisation de la configuration PHPMailer pour envoyer l'email
    $mailer = new PhpMailerConfig();
    $mailSent = $mailer->sendMail(
      'zooarcadia5@gmail.com',
      $email,
      $subject,
      $body
    );

    // Vérification si l'email a été envoyé avec succès
    if ($mailSent === true) {
      FlashMessage::addMessage("Votre demande a bien été envoyée", 'success');
    } else {
      FlashMessage::addMessage("Une erreur est survenue lors de l'envoi de l'email : " . $mailSent, 'error');
    }

    // Rediriger vers la page d'accueil ou une autre page
    header("Location: /reviews");
    exit;
  }
}
