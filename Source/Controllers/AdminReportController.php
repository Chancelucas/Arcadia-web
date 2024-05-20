<?php

namespace Source\Controllers;

use Source\Models\report\AnimalReportModel;
use Source\Models\report\HabitatReportModel;

class AdminReportController extends AdminController
{

  /**
   * Displays WelcomPage
   * 
   */
  public function index()
  {
    $animalsReport = $this->getAllAnimalReport();
    $reportsHabitat = $this->getAllHabitatReport(); 
    $this->render('report/adminReport', ['animalsReport' => $animalsReport, 'reportsHabitat' => $reportsHabitat ]);
  }

  public function getAllAnimalReport()
  {
    $model = new AnimalReportModel;
    $animalsReport = $model->getAllAnimalsReports();

    return $animalsReport;
  }

  public function getAllHabitatReport()
  {
    $model = new HabitatReportModel;
    $habitatReport = $model->getAllHabitatReport();

    return $habitatReport;
  }


}
