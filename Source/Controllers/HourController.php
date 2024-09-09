<?php

namespace Source\Controllers;

use Source\Models\hour\HourModel;
use Source\Controllers\Controller;


class HourController extends Controller
{
  public function index()
  {

    $hours = $this->getAllHours();

    $this->render('hour/hour', [
      'hours' => $hours
    ]);
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
}
