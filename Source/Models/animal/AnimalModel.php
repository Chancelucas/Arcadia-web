<?php

namespace Source\Models\animal;

use Source\Models\habitat\HabitatModel;
use Source\Models\MainModel;

/**
 * Habitat Object
 * @var 
 */

class AnimalModel extends MainModel
{
  protected $id_Animal;
  protected $name;
  protected $breed;
  protected $picture_url;
  protected $id_Habitat;


  /**
   * Init Animal model on table Animal
   */
  public function __construct()
  {
    $this->table = 'Animal';
  }

  public function findOneByName(string $name)
  {
    $animalData = $this->request("SELECT * FROM {$this->table} WHERE name = ?", [$name])->fetch();
    $this->hydrate($animalData);

    return $this;
  }

  public function findOneByBreed(string $breed)
  {
    $breedData = $this->request("SELECT * FROM {$this->table} WHERE breed = ?", [$breed])->fetch();

    if ($breedData === false) {
      return null;
    }

    $this->hydrate($breedData);
    return $this;
  }


  /**
   * Get all animal on table animal
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
   * Create one Animal on table Animal
   */
  public function createAnimal()
  {
    return $this->create();
  }

  /**
   * Update one animal on table animal
   */
  public function update()
  {
    $sql = "UPDATE {$this->table} SET name = :name, breed = :breed, picture_url = :picture, id_habitat = :id_habitat WHERE id = :id_animal";
    $values = [
      ':name' => $this->name,
      ':breed' => $this->breed,
      ':picture' => $this->picture_url,
      ':id_habitat' => $this->id_Habitat,
      ':id_animal' => $this->id,
    ];

    return $this->request($sql, $values);
  }

  /**
   * Get all Animals 
   * 
   */
  public function getAllAnimals()
  {
    $model = new AnimalModel;
    $animalsModel = $model->getAll();

    $allAnimals = [];
    foreach ($animalsModel as $animalModel) {
      $animal = new \stdClass();
      $animal->id_Animal = $animalModel->getId();
      $animal->name = $animalModel->getName();
      $animal->breed = $animalModel->getBreed();
      $animal->picture = $animalModel->getPictureUrl();
      $animal->id_Habitat = $animalModel->getIdHabitat();
      $animal->habitat = $animalModel->getHabitat();

      $allAnimals[] = $animal;
    }

    return $allAnimals;
  }

  /**
   * function get one animal from database
   */
  public function getAllBreedAnimals()
  {
    $model = new AnimalModel;
    $animals = $model->getAll();

    $animalsList = [];

    foreach ($animals as $animal) {
      $animalsList[$animal->getId()] = $animal->getBreed();
    }
    return $animalsList;
  }



  /////////////////// GETTER and SETTER /////////////////////

  /**
   * Get the value of id_animal
   */
  public function getIdAnimal()
  {
    return $this->id;
  }

  /**
   * Set the value of id_animal
   *
   * @return  self
   */
  public function setIdAnimal($id_animal)
  {
    $this->id = $id_animal;

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
   * Get the value of breed
   */
  public function getBreed()
  {
    return $this->breed;
  }

  /**
   * Set the value of breed
   *
   * @return  self
   */
  public function setBreed($breed)
  {
    $this->breed = $breed;

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
   * Get the value of id_Habitat
   */
  public function getIdHabitat()
  {
    return $this->id_Habitat;
  }

  /**
   * Set the value of id_Habitat
   *
   * @return  self
   */
  public function setIdHabitat($id_Habitat)
  {
    $this->id_Habitat = $id_Habitat;

    return $this;
  }

  /**
   * Get the value of habitat
   */
  public function getHabitat()
  {
    return (new HabitatModel())->findOneById($this->id_Habitat)->getName();
  }
}
