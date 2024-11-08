<?php

namespace Source\Controllers;

use Source\Models\reviews\ReviewsModel;
use Source\Helpers\FlashMessage;


class EmployeeReviewController extends EmployeeController
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $allReviews = $this->getAllReviews();

    $this->render('review/employeeReview', [
      'allReviews' => $allReviews,
    ]);
  }

  private function getAllReviews()
  {
    $allReviews = (new ReviewsModel)->getAllReviews();
    return $allReviews;
  }

  public function toggleStatus(int $id)
  {
    if (isset($_POST['toggleStatusReviews'])) {
      $reviewModel = (new ReviewsModel)->findOneById($id);

      $reviewModel->setStatus(!$reviewModel->getStatus());

      $updateResult = $reviewModel->update();

      if (!$updateResult) {
        FlashMessage::addMessage("Une erreur s'est produite lors de la modification de l'avis client.", 'error');
      }
    }

    Header("Location: /employeeReview");
    exit;
  }
}
