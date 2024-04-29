<?php

namespace Source\Models\role;

use Source\Models\MainModel;
use Source\Models\user\UserModel;

class RoleModel extends MainModel
{
  protected $id_Role;
  protected $role;


  /**
   * Init role model on table Role
   */
  public function __construct()
  {
    $this->table = 'Role';
  }

  /**
   * Find one entity by role
   */
  public function findOneByRole(string $role)
  {
    $roleData = $this->request("SELECT * FROM {$this->table} WHERE role = ?", [$role])->fetch();
    $this->hydrate($roleData);

    return $this;
  }

  /**
   * Get all role on table Role
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
   * Create one role on table Role
   */
  public function createRole()
  {
    return $this->create();
  }

  /////////////////// GETTER and SETTER /////////////////////


  /**
   * Get the value of role
   */
  public function getRole()
  {
    return $this->role;
  }

  /**
   * Set the value of role
   *
   * @return  self
   */
  public function setRole($role)
  {
    $this->role = $role;

    return $this;
  }
}
