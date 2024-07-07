<?php

namespace Source\Models;

use PDO;
use Lib\config\Database;

/**
 * CRUD
 * 
 * findAll() -
 * findBy() - 
 * find() - 
 * create() - 
 * 
 *  
 * */
abstract class MainModel
{
  protected $table;
  private $database;
  protected $id;

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
    return $this;
  }

  /**
   * Main function find by
   */
  public function findBy(array $criteria)
  {
    $fields = [];
    $values = [];

    foreach ($criteria as $field => $value) {
      $fields[] = "$field = :$field";
      $values[":$field"] = $value;
    }

    $fieldsString = implode(' AND ', $fields);
    return $this->request("SELECT * FROM {$this->table} WHERE $fieldsString", $values)->fetchAll();
  }

  /**
   * Main function find one by Id 
   */
  public function findOneById(int $id)
  {
    $data = $this->request("SELECT * FROM {$this->table} WHERE id = :id", [':id' => $id])->fetch();
    $this->hydrate($data);

    return $this;
  }

  /**
   * Main function create in MainModel
   */
  public function create()
  {
    $fields = [];
    $in = [];
    $values = [];

    foreach ($this as $field => $value) {

      if ($value !== null && $field != 'database' && $field != 'table') {
        $fields[] = $field;
        $in[] = "?";
        $values[] = $value;
      }
    }

    $fieldsString = implode(', ', $fields);
    $inString = implode(', ', $in);


    return $this->request("INSERT INTO {$this->table} ($fieldsString) VALUES ($inString)", $values);
  }

  /**
   * Main function Delete by Id 
   */
  public function delete()
  {
    return $this->request("DELETE FROM {$this->table} WHERE id = :id", [':id' => $this->id])->fetch();
  }

  /**
   * Main function request
   */
  public function request(string $sql, array $attributes = null)
  {
    $this->database = Database::getInstance();

    if ($attributes !== null) {
      $query = $this->database->prepare($sql);

      foreach ($attributes as $key => &$value) {
        $type = PDO::PARAM_STR;
        if (is_int($value)) {
          $type = PDO::PARAM_INT;
        } elseif (is_bool($value)) {
          $type = PDO::PARAM_BOOL;
        } elseif (is_null($value)) {
          $type = PDO::PARAM_NULL;
        }

        $query->bindParam($key, $value, $type);
      }

      $query->execute();
      return $query;
    } else {
      return $this->database->query($sql);
    }
  }

  /**
   * Main function Hydrate
   */
  public function hydrate($data)
  {
    foreach ($data as $key => $value) {
      $setter = $this->convertBddKeyToSetterMethod($key);

      if (method_exists($this, $setter)) {
        $this->$setter($value);
      }
    }
    return $this;
  }


  /** 
   * Main function Convert method for hydrate function
   */
  private function convertBddKeyToSetterMethod($bddKey)
  {
    return 'set' . str_replace(" ", "", ucwords(str_replace("_", " ", $bddKey)));
  }
}
