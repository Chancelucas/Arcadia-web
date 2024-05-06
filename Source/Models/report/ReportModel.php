<?php

namespace Source\Models\report;

use Source\Models\MainModel;

/**
 * Report Object
 * @var 
 */

class ReportModel extends MainModel
{
  protected $id_Report;
  protected $state;
  protected $proposed_food;
  protected $food_amount;
  protected $passage_date;
  protected $state_detail;
  protected $id_animal;

  /**
   * Init Habitat model on table Habitat
   */
  public function __construct()
  {
    $this->table = 'AnimalReport';
  }

  /**
   * Find one report by id_Animal
   */
  public function findOneByIdAnimal(int $id_Animal)
  {
    $habitatData = $this->request("SELECT * FROM {$this->table} WHERE name = ?", [$id_Animal])->fetch();

    if ($habitatData === false) {
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
    $sql = "UPDATE {$this->table} SET state = :state, proposed_food = :proposed_food, food_amount = :food_amount, passage_date = :passage_date, state_detail = :state_detail, id_animal = :id_animal  WHERE id = :id_report";
    $values = [
      ':state' => $this->state,
      ':proposed_food' => $this->proposed_food,
      ':food_amount' => $this->food_amount,
      ':passage_date' => $this->passage_date, 
      ':state_detail' => $this->state_detail,
      ':id_animal' => $this->id_animal, 
      ':id_report' => $this->id,
    ];

    return $this->request($sql, $values);
  }


  /////////////////// GETTER and SETTER /////////////////////

 

  /**
   * Get the value of id_Report
   */ 
  public function getId_Report()
  {
    return $this->id_Report;
  }

  /**
   * Set the value of id_Report
   *
   * @return  self
   */ 
  public function setId_Report($id_Report)
  {
    $this->id_Report = $id_Report;

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

  /**
   * Get the value of proposed_food
   */ 
  public function getProposed_food()
  {
    return $this->proposed_food;
  }

  /**
   * Set the value of proposed_food
   *
   * @return  self
   */ 
  public function setProposed_food($proposed_food)
  {
    $this->proposed_food = $proposed_food;

    return $this;
  }

  /**
   * Get the value of food_amount
   */ 
  public function getFood_amount()
  {
    return $this->food_amount;
  }

  /**
   * Set the value of food_amount
   *
   * @return  self
   */ 
  public function setFood_amount($food_amount)
  {
    $this->food_amount = $food_amount;

    return $this;
  }

  /**
   * Get the value of passage_date
   */ 
  public function getPassage_date()
  {
    return $this->passage_date;
  }

  /**
   * Set the value of passage_date
   *
   * @return  self
   */ 
  public function setPassage_date($passage_date)
  {
    $this->passage_date = $passage_date;

    return $this;
  }

  /**
   * Get the value of state_detail
   */ 
  public function getState_detail()
  {
    return $this->state_detail;
  }

  /**
   * Set the value of state_detail
   *
   * @return  self
   */ 
  public function setState_detail($state_detail)
  {
    $this->state_detail = $state_detail;

    return $this;
  }

  /**
   * Get the value of id_animal
   */ 
  public function getId_animal()
  {
    return $this->id_animal;
  }

  /**
   * Set the value of id_animal
   *
   * @return  self
   */ 
  public function setId_animal($id_animal)
  {
    $this->id_animal = $id_animal;

    return $this;
  }
}
