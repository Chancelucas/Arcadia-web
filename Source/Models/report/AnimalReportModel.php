<?php

namespace Source\Models\report;

use Source\Models\MainModel;
use Source\Models\animal\AnimalModel;

/**
 * Report Object
 * @var 
 */

class AnimalReportModel extends MainModel
{
  protected $id_AnimalReport;
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
  public function findOneByIdAnimal(string $id_animal)
  {
    $idAnimalData = $this->request("SELECT * FROM {$this->table} WHERE id_animal = :id_animal", [':id_animal' => $id_animal])->fetch();

    if ($idAnimalData === false) {
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

  /**
   * Get all Animals 
   * 
   */
  public function getAllAnimalsReports()
  {
    $animalsReportModel = $this->getAll();

    $allAnimalsReports = [];
    foreach ($animalsReportModel as $animalReportModel) {
      $animalReport = new \stdClass();
      $animalReport->id_AnimalReport = $animalReportModel->getId();
      $animalReport->animalBreed = $animalReportModel->getAnimalBreed();
      $animalReport->state = $animalReportModel->getAssessmentState();
      $animalReport->proposed_food = $animalReportModel->getProposedFood();
      $animalReport->food_amount = $animalReportModel->getFoodAmount();
      $animalReport->passage_date = $animalReportModel->getPassageDate();
      $animalReport->state_detail = $animalReportModel->getStateDetail();
      $animalReport->id_animal = $animalReportModel->getIdAnimal();

      $allAnimalsReports[] = $animalReport;
    }

    return $allAnimalsReports;
  }

  public function getReportsByAnimalId($animalId)
  {
    return $this->request("SELECT * FROM AnimalReport WHERE id_animal = ?", [$animalId])->fetchAll();
  }


  /////////////////// GETTER and SETTER /////////////////////



  /**
   * Get the value of id_Report
   */
  public function getIdAnimalReport()
  {
    return $this->id;
  }

  /**
   * Set the value of id_Report
   *
   * @return  self
   */
  public function setIdAnimalReport($id_AnimalReport)
  {
    $this->id = $id_AnimalReport;

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
  public function getProposedFood()
  {
    return $this->proposed_food;
  }

  /**
   * Set the value of proposed_food
   *
   * @return  self
   */
  public function setProposedFood($proposed_food)
  {
    $this->proposed_food = $proposed_food;

    return $this;
  }

  /**
   * Get the value of food_amount
   */
  public function getFoodAmount()
  {
    return $this->food_amount;
  }

  /**
   * Set the value of food_amount
   *
   * @return  self
   */
  public function setFoodAmount($food_amount)
  {
    $this->food_amount = $food_amount;

    return $this;
  }

  /**
   * Get the value of passage_date
   */
  public function getPassageDate()
  {
    return $this->passage_date;
  }

  /**
   * Set the value of passage_date
   *
   * @return  self
   */
  public function setPassageDate($passage_date)
  {
    $this->passage_date = $passage_date;

    return $this;
  }

  /**
   * Get the value of state_detail
   */
  public function getStateDetail()
  {
    return $this->state_detail;
  }

  /**
   * Set the value of state_detail
   *
   * @return  self
   */
  public function setStateDetail($state_detail)
  {
    $this->state_detail = $state_detail;

    return $this;
  }

  /**
   * Get the value of id_animal
   */
  public function getIdAnimal()
  {
    return $this->id_animal;
  }

  /**
   * Set the value of id_animal
   *
   * @return  self
   */
  public function setIdAnimal($id_animal)
  {
    $this->id_animal = $id_animal;

    return $this;
  }

  /**
   * Get the value of habitat
   */
  public function getAnimalBreed()
  {
    return (new AnimalModel())->findOneById($this->id_animal)->getBreed();
  }

  /**
   * Get the value of habitat
   */
  public function setAnimalBreed($breed)
  {
    return (new AnimalModel())->findOneById($this->id_animal)->setBreed($breed);
  }

  /**
   * Get the value of habitat
   */
  public function getAssessmentState()
  {
    return (new AssessmentModel())->findOneById($this->state)->getState();
  }

  /**
   * Get the value of habitat
   */
  // ??????
  // public function setAssessmentState($state)
  // {
  //   return (new AssessmentModel())->findOneById($this->id)->setState($state);
  // }
}
