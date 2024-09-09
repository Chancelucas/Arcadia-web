<?php

namespace Source\Models\hour;

use Source\Models\MainModel;

class HourModel extends MainModel
{
  protected $id_Hour;
  protected $day;
  protected $opening_time;
  protected $closing_time;

  /**
   * Init Hour model on table Hour
   */
  public function __construct()
  {
    $this->table = 'Hours';
  }

  /**
   * Find one hour with day
   */
  public function findOneByDay(string $day)
  {
    $serviceData = $this->request("SELECT * FROM {$this->table} WHERE day = :day", [':day' => $day])->fetch();

    if ($serviceData === false) {
      return null;
    }

    return $this;
  }

  /**
   * Function for create one hour
   */
  public function createHour()
  {
    return $this->create();
  }

  /**
   * Get all hour on table hour
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
   * Update one hour on table hour
   */
  public function update()
  {
    $sql = "UPDATE {$this->table} SET day = :day, opening_time = :opening_time, closing_time = :closing_time WHERE id = :id_hour";
    $values = [
      ':day' => $this->day,
      ':opening_time' => $this->opening_time,
      ':closing_time' => $this->closing_time,
      ':id_hour' => $this->id,
    ];

    return $this->request($sql, $values);
  }

   /**
   * Get all hour  
   */
  public function getAllHours()
  {
    $hoursModel = $this->getAll();

    $allHours = [];
    foreach ($hoursModel as $hourModel) {
      $hour = new \stdClass();
      $hour->id_Hour = $hourModel->getId();
      $hour->day = $hourModel->getDay();
      $hour->opening_time = $hourModel->getOpeningTime();
      $hour->closing_time = $hourModel->getClosingTime();

      $allHours[] = $hour;
    }

    return $allHours;
  }


  /////////////////// GETTER and SETTER /////////////////////

  public function getIdHour()
  {
  return $this->id;
  }

  public function setIdHour($id_hour)
  {
   $this->id = $id_hour;

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
   * Get the value of opening_time
   */ 
  public function getOpeningTime()
  {
    return $this->opening_time;
  }

  /**
   * Set the value of opening_time
   *
   * @return  self
   */ 
  public function setOpeningTime($opening_time)
  {
    $this->opening_time = $opening_time;

    return $this;
  }

  /**
   * Get the value of closing_time
   */ 
  public function getClosingTime()
  {
    return $this->closing_time;
  }

  /**
   * Set the value of closing_time
   *
   * @return  self
   */ 
  public function setClosingTime($closing_time)
  {
    $this->closing_time = $closing_time;

    return $this;
  }
}
