<?php

namespace Source\Models\report;

use Source\Models\MainModel;

/**
 * Report Object
 * @var 
 */

class AssessmentModel extends MainModel
{
  protected $id_Assessment;
  protected $state;

  /**
   * Init Habitat model on table Habitat
   */
  public function __construct()
  {
    $this->table = 'Assessment';
  }

  /**
   * Find one report by id_Animal
   */
  public function findOneByState(int $state)
  {
    $assessmentData = $this->request("SELECT * FROM {$this->table} WHERE state = ?", [$state])->fetch();

    if ($assessmentData === false) {
      return null;
    }

    return $this;
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


  public function getAllNameState()
  {
    $states = $this->getAll();

    $stateList = [];

    foreach ($states as $state) {
      $stateList[$state->getId()] = $state->getState();
    }
    return $stateList;
  }

  /////////////////// GETTER and SETTER /////////////////////

 

  /**
   * Get the value of id
   */ 
  public function getIdAssessment()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */ 
  public function setIdAssessment($id_Assessment)
  {
    $this->id = $id_Assessment;

    return $this;
  }

  /**
   * Get the value of state
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
}
