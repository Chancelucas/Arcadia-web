<?php

namespace Source\Models\animal;

use Source\Models\MainModel;
use Source\Models\user\UserModel;
use Source\Models\animal\AnimalModel;

/**
 * Report Object
 * @var 
 */

class FoodGivenModel extends MainModel
{
  protected $id;
  protected $day;
  protected $hour;
  protected $food;
  protected $quantity;
  protected $id_user;
  protected $id_animal;


  /**
   * Init Habitat model on table Habitat
   */
  public function __construct()
  {
    $this->table = 'FoodGiven';
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
  public function findOneByIdUser(string $id_user)
  {
    $idUserData = $this->request("SELECT * FROM {$this->table} WHERE id_user = ?", [$id_user])->fetch();

    if ($idUserData === false) {
      return null;
    }

    return $this;
  }

  /**
   * Find one habitat by name
   */
  public function findOneByDate(string $date)
  {
    $dateData = $this->request("SELECT * FROM {$this->table} WHERE day = ?", [$date])->fetch();

    if ($dateData === false) {
      return null;
    }

    return $this;
  }



  /**
   * Function for create one report
   */
  public function createFoodGiven()
  {
    return $this->create();
  }

  /**
   * Update one habitat on table habitat
   */
  public function update()
  {
    $sql = "UPDATE {$this->table} SET day = :day, hour = :hour, food = :food, quantity = :quantity, id_user = :id_user, id_animal = :id_animal WHERE id = :id";
    $values = [
      ':day' => $this->day,
      ':hour' => $this->hour,
      ':food' => $this->food,
      ':quantity' => $this->quantity,
      ':id_user' => $this->id_user,
      ':id_animal' => $this->id_animal,
    ];

    return $this->request($sql, $values);
  }

  /**
   * Get all Animals 
   * 
   */
  public function getAllFoodGiven()
  {
    $foodsGivenModel = $this->getAll();

    $allFoodGiven = [];

    foreach ($foodsGivenModel as $foodGivenModel) {
      $foodGiven = new \stdClass();
      $foodGiven->id = $foodGivenModel->getId();
      $foodGiven->day = $foodGivenModel->getDay();
      $foodGiven->hour = $foodGivenModel->getHour();
      $foodGiven->food = $foodGivenModel->getFood();
      $foodGiven->quantity = $foodGivenModel->getQuantity();
      $foodGiven->user = $foodGivenModel->getUser();
      $foodGiven->animal = $foodGivenModel->getAnimal();

      $allFoodGiven[] = $foodGiven;
    }

    return $allFoodGiven;
  }


  /////////////////// GETTER and SETTER /////////////////////



  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of day
   */
  public function getDay()
  {
    return $this->day;
  }

  /**
   * Set the value of day
   *
   * @return  self
   */
  public function setDay($day)
  {
    $this->day = $day;

    return $this;
  }

  /**
   * Get the value of hour
   */
  public function getHour()
  {
    return $this->hour;
  }

  /**
   * Set the value of hour
   *
   * @return  self
   */
  public function setHour($hour)
  {
    $this->hour = $hour;

    return $this;
  }

  /**
   * Get the value of food
   */
  public function getFood()
  {
    return $this->food;
  }

  /**
   * Set the value of food
   *
   * @return  self
   */
  public function setFood($food)
  {
    $this->food = $food;

    return $this;
  }

  /**
   * Get the value of quantity
   */
  public function getQuantity()
  {
    return $this->quantity;
  }

  /**
   * Set the value of quantity
   *
   * @return  self
   */
  public function setQuantity($quantity)
  {
    $this->quantity = $quantity;

    return $this;
  }

  /**
   * Get the value of id_user
   */
  public function getIdUser()
  {
    return $this->id_user;
  }

  /**
   * Set the value of id_user
   *
   * @return  self
   */
  public function setIdUser($id_user)
  {
    $this->id_user = $id_user;

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
  public function getAnimal()
  {
    return (new AnimalModel())->findOneById($this->id_animal);
  }

  public function getUser()
  {
    return (new UserModel())->findOneById($this->id_user);
  }
}
