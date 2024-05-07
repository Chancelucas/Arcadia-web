<?php

namespace Source\Models\report;

use Source\Models\MainModel;

/**
 * Report Object
 * @var 
 */

class HabitatReportModel extends MainModel
{
  protected $id_Report;
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
    $sql = "UPDATE {$this->table} SET opinion = :opinion, state = :state, improvement = :improvement, id_habitat = :id_habitat WHERE id = :id_report";
    $values = [
      ':opinion' => $this->opinion,
      ':state' => $this->state,
      ':improvement' => $this->improvement,
      ':id_habitat' => $this->id_habitat, 
      ':id_report' => $this->id,
    ];

    return $this->request($sql, $values);
  }


  /////////////////// GETTER and SETTER /////////////////////

  /**
   * Get the value of id_Report
   */ 
  public function getIdReport()
  {
    return $this->id_Report;
  }

  /**
   * Set the value of id_Report
   *
   * @return  self
   */ 
  public function setIdReport($id_Report)
  {
    $this->id_Report = $id_Report;

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

}
