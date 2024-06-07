<?php

namespace Source\Models\report;

use Source\Models\MainModel;
use Source\Models\habitat\HabitatModel;
use Source\Models\report\AssessmentModel;

/**
 * Report Object
 * @var 
 */

class HabitatReportModel extends MainModel
{
  protected $opinion;
  protected $state;
  protected $improvement;
  protected $date;
  protected $id_habitat;

  /**
   * Init Habitat model on table Habitat
   */
  public function __construct()
  {
    $this->table = 'HabitatReport';
  }

  /**
   * Get all report on table report
   */
  public function getAll()
  {
    $query = $this->request("SELECT * FROM {$this->table}");
    $allData = $query->fetchAll();

    $models = [];
    foreach ($allData as $data) {
      $self = new self();
      $self->hydrate($data);
      array_push($models, $self);
    }
    return $models;
  }

  /**
   * Find one habitat by name
   */
  public function findOneByDate(string $date)
  {
    $habitatData = $this->request("SELECT * FROM {$this->table} WHERE date = ?", [$date])->fetch();

    if ($habitatData === false) {
      return null;
    }

    return $this;
  }

  /**
   * Find one habitat by name
   */
  public function findOneByIdHabitat(string $id_habitat)
  {
    $habitatData = $this->request("SELECT * FROM {$this->table} WHERE id_habitat = ?", [$id_habitat])->fetch();

    if ($habitatData === false) {
      return null;
    }

    return $this;
  }


  /**
   * Function for create one report
   */
  public function createReport()
  {
    return $this->create();
  }

  /**
   * Update one habitat on table habitat
   */
  public function update()
  {
    $sql = "UPDATE {$this->table} SET opinion = :opinion, state = :state, improvement = :improvement, date = :date, id_habitat = :id_habitat WHERE id = :id_report";
    $values = [
      ':opinion' => $this->opinion,
      ':state' => $this->state,
      ':improvement' => $this->improvement,
      ':date' => $this->date,
      ':id_habitat' => $this->id_habitat,
      ':id_report' => $this->id,
    ];

    return $this->request($sql, $values);
  }

  /**
   * Get all user with role(label) on database
   */
  public function getAllHabitatReport()
  {
    $habitatsReportModel = $this->getAll();

    $allHabitatReport = [];

    foreach ($habitatsReportModel as $habitatReportModel) {
      $habitatReport = new \stdClass();
      $habitatReport->id_HabitatReport = $habitatReportModel->getId();
      $habitatReport->opinion = $habitatReportModel->getAssessmentOpinon();
      $habitatReport->state = $habitatReportModel->getAssessmentState();
      $habitatReport->improvement = $habitatReportModel->getImprovement();
      $habitatReport->date = $habitatReportModel->getDate();
      $habitatReport->id_habitat = $habitatReportModel->getIdHabitat();
      $habitatReport->name_habitat = $habitatReportModel->getNameOfHabitat();

      $allHabitatReport[] = $habitatReport;
    }

    return $allHabitatReport;
  }


  /////////////////// GETTER and SETTER /////////////////////

  /**
   * Get the value of id_Report
   */
  public function getIdHabitatReport()
  {
    return $this->id;
  }

  /**
   * Set the value of id_Report
   *
   * @return  self
   */
  public function setIdHabitatReport($id_HabitatReport)
  {
    $this->id = $id_HabitatReport;

    return $this;
  }

  /**
   * Set the value of opinion
   *
   * @return  self
   */
  public function getOpinion()
  {
    return $this->opinion;
  }

  /**
   * Set the value of opinion
   *
   * @return  self
   */
  public function setOpinion($opinion)
  {
    $this->opinion = $opinion;

    return $this;
  }

  /**
   * Set the value of state
   *
   * @return  self
   */
  public function getState()
  {
    return $this->state;
  }

  /**
   * Set the value of state
   *
   * @return  self
   */
  public function setState($state)
  {
    $this->state = $state;

    return $this;
  }

  /**
   * Set the value of improvement
   *
   * @return  self
   */
  public function getImprovement()
  {
    return $this->improvement;
  }

  /**
   * Set the value of improvement
   *
   * @return  self
   */
  public function setImprovement($improvement)
  {
    $this->improvement = $improvement;

    return $this;
  }

  /**
   * Set the value of id_habitat
   *
   * @return  self
   */
  public function getDate()
  {
    return $this->date;
  }

  /**
   * Set the value of id_habitat
   *
   * @return  self
   */
  public function setDate($date)
  {
    $this->date = $date;

    return $this;
  }

  /**
   * Set the value of id_habitat
   *
   * @return  self
   */
  public function getIdHabitat()
  {
    return $this->id_habitat;
  }

  /**
   * Set the value of id_habitat
   *
   * @return  self
   */
  public function setIdHabitat($id_habitat)
  {
    $this->id_habitat = $id_habitat;

    return $this;
  }

  /**
   * Get the value of habitat
   */
  public function getAssessmentStateId()
  {
    return $this->state;
  }

  public function getAssessmentState()
  {
    return (new AssessmentModel())->findOneById($this->state)->getState();
  }

  /**
   * Get the value of habitat
   */
  public function setAssessmentState($state)
  {
    return (new AssessmentModel())->findOneById($this->state)->setState($state);
  }

  /**
   * Get the value of habitat
   */
  public function getAssessmentOpinonId()
  {
    return $this->opinion;
  }

  public function getAssessmentOpinon()
  {
    return (new AssessmentModel())->findOneById($this->opinion)->getState();
  }

  /**
   * Get the value of habitat
   */
  public function setAssessmentOpinion($state)
  {
    return (new AssessmentModel())->findOneById($this->opinion)->setState($state);
  }

  /**
   * Get the value of habitat
   */
  public function getNameOfHabitat()
  {

    return (new HabitatModel())->findOneById($this->id_habitat)->getName();
  }

  /**
   * Get the value of habitat
   */
  public function setNameOfHabitat($name)
  {
    return (new HabitatModel())->findOneById($this->id_habitat)->setName($name);
  }
}
