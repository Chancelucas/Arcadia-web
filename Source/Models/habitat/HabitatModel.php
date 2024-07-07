<?php

namespace Source\Models\habitat;

use Source\Models\MainModel;

/**
 * Habitat Object
 * @var 
 */

class HabitatModel extends MainModel
{
  protected $id_Habitat;
  protected $name;
  protected $description;
  protected $picture_url;

  /**
   * Init Habitat model on table Habitat
   */
  public function __construct()
  {
    $this->table = 'Habitat';
  }

  /**
   * Find one habitat by name
   */
  public function findOneByName(string $name)
  {
    $habitatData = $this->request("SELECT * FROM {$this->table} WHERE name = :name", [':name' => $name])->fetch();

    if ($habitatData === false) {
      return null;
    }

    return $this;
  }

  /**
   * Get all habitat on table habitat
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

  public function getAllWithAnimals() 
  {
    $query = $this->request("
      SELECT
        h.id AS habitat_id,
        h.name as habitat_name,
        h.description as habitat_description,
        h.picture_url as habitat_picture_url,
        a.id as animal_id,
        a.name as animal_name,
        a.breed as animal_breed,
        a.picture_url as animal_picture_url
      FROM `Habitat` h
        LEFT JOIN `Animal` a ON a.id_habitat = h.id;
    ");
    $allData = $query->fetchAll();

    $habitats = [];
    foreach ($allData as $data) {
      $habitatId = $data->habitat_id;


      // Check if habitat already exists in $habitats
      if (!isset($habitats[$habitatId])) {
        $h = new \stdClass();
        $h->id = $data->habitat_id;
        $h->name = $data->habitat_name;
        $h->description = $data->habitat_description;
        $h->picture_url = $data->habitat_picture_url;
        $h->animals = [];

        $habitats[$habitatId] = $h;
      }

      // Create animal object
      $a = new \stdClass();
      $a->id = $data->animal_id;
      $a->name = $data->animal_name;
      $a->breed = $data->animal_breed;
      $a->picture_url = $data->animal_picture_url;

      // Add animal to habitat's animals array
      $habitats[$habitatId]->animals[] = $a;
    }

    // Convert the associative array to a regular array
    $habitats = array_values($habitats);

    return $habitats;
  }

  /**
   * Function for create one habitat
   */
  public function createHabitat()
  {
    return $this->create();
  }

  /**
   * Update one habitat on table habitat
   */
  public function update()
  {
    $sql = "UPDATE {$this->table} SET name = :name, description = :description, picture_url = :picture_url  WHERE id = :id_habitat";
    $values = [
      ':name' => $this->name,
      ':description' => $this->description,
      ':picture_url' => $this->picture_url, 
      ':id_habitat' => $this->id,
    ];

    return $this->request($sql, $values);
  }

  public function getAllNameHabitat()
  {
    $habitats = $this->getAll();

    $habitatList = [];

    foreach ($habitats as $habitat) {
      $habitatList[$habitat->getId()] = $habitat->getName();
    }
    return $habitatList;
  }



  /////////////////// GETTER and SETTER /////////////////////

  /**
   * Get the value of id_Habitat
   */
  public function getIdHabitat()
  {
    return $this->id;
  }

  /**
   * Set the value of id_Habitat
   *
   * @return  self
   */
  public function setIdHabitat($id_Habitat)
  {
    $this->id = $id_Habitat;

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
}
