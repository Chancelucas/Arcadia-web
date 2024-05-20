<?php

namespace Source\Models\service;

use Source\Models\MainModel;

class ServiceModel extends MainModel
{
  protected $id_Service;
  protected $name;
  protected $description;
  protected $picture_url;

  /**
   * Init Service model on table service
   */
  public function __construct()
  {
    $this->table = 'Service';
  }

  /**
   * Find one service by name
   */
  public function findOneByName(string $name)
  {
    $serviceData = $this->request("SELECT * FROM {$this->table} WHERE name = ?", [$name])->fetch();

    if ($serviceData === false) {
      return null;
    }
    
    return $this;
  }

  /**
   * Function for create one service
   */
  public function createService()
  {
    return $this->create();
  }

  /**
   * Get all service on table service
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
   * Update one service on table service
   */
  public function update()
  {
    $sql = "UPDATE {$this->table} SET name = :name, description = :description, picture_url = :picture_url WHERE id = :id_service";
    $values = [
      ':name' => $this->name,
      ':description' => $this->description,
      ':picture_url' => $this->picture_url,
      ':id_service' => $this->id,
    ];

    return $this->request($sql, $values);
  }

  public function getAllServices()
  {
    $services = $this->getAll();

    $allServices = [];
    foreach ($services as $serviceModel) {
      $service = new \stdClass();
      $service->id_Service = $serviceModel->getId();
      $service->name = $serviceModel->getName();
      $service->description = $serviceModel->getDescription();
      $service->picture = $serviceModel->getPictureUrl();

      $allServices[] = $service;
    }

    return $allServices;
  }


  /////////////////// GETTER and SETTER /////////////////////

  /**
   * Get the value of id_service
   */
  public function getIdService()
  {
    return $this->id;
  }

  /**
   * Set the value of id_service
   *
   * @return  self
   */
  public function setIdService($id_service)
  {
    $this->id = $id_service;

    return $this;
  }
  /**
   * Get the value of picture
   */
  public function getPictureUrl()
  {
    return $this->picture_url;
  }

  /**
   * Set the value of picture
   *
   * @return  self
   */
  public function setPictureUrl($picture)
  {
    $this->picture_url = $picture;

    return $this;
  }

  /**
   * Get the value of decription
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of decription
   *
   * @return  self
   */
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of name
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Set the value of name
   *
   * @return  self
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }
}
