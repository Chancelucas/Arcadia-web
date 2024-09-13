<?php

namespace Source\Controllers;

use Source\Controllers\Controller;
use Source\Models\habitat\HabitatModel;
use Source\Models\reviews\ReviewsModel;
use Source\Models\service\ServiceModel;
use function Source\Helpers\securityHTML;

class HomeController extends Controller
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $habitat = $this->getAllHabitat();
    $services = $this->getAllServices();
    $reviews = $this->getAllValableReview();

    $this->render('home/home', [
      'allHabitats' => $habitat,
      'allServices' => $services,
      'allReviews' => $reviews,
    ]);
  }

  private function getAllHabitat()
  {
    $model = new HabitatModel;
    $allHabitats = $model->getAllWithAnimals();

    return $allHabitats;
  }

  private function getAllServices()
  {
    $model = new ServiceModel;
    $allServices = $model->getAllServices();

    return $allServices;
  }

  private function getAllValableReview()
  {
    $enableReviews = (new ReviewsModel)->findBy(['status' => true]);
    return $enableReviews;
  }
}
