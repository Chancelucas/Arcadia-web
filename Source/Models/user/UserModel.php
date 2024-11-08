<?php

namespace Source\Models\user;

use Source\Models\MainModel;
use Source\Models\role\RoleModel;

class UserModel extends MainModel
{
  protected $username;
  protected $email;
  protected $password;
  protected $id_role;
  protected $active;

  /**
   * Init user model on table User
   */
  public function __construct()
  {
    $this->table = 'User';
  }

  /**
   * Find one entity by email
   */
  public function findOneByEmail(string $email)
  {
    $userData = $this->request("SELECT * FROM {$this->table} WHERE email = :email", [':email' => $email])->fetch();

    if ($userData === false) {
      return null;
    }

    $this->hydrate($userData);
    return $this;
  }


  /**
   * config session
   */
  public function setSession()
  {
    // $_SESSION = array();

    $_SESSION['user'] = [
      'id_user' => $this->id,
      'email' => $this->email,
      'username' => $this->username,
      'roleId' => $this->id_role,
      'role' => $this->getRole(),
      'active' => $this->getActive(),
    ];

    $_SESSION['error'] = "";
    $_SESSION['message'] = "";
  }

  public function fromSession()
  {
    if (isset($_SESSION['user'])) {
      $user = $_SESSION['user'];
      $this->setIdUser($user['id_user']);
      $this->setUsername($user['username']);
      $this->setEmail($user['email']);
      $this->setIdRole($user['roleId']);
      return $this;
    }
    return;
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
   * Create one user on table User
   */
  public function createUser()
  {
    return $this->create();
  }

  /**
   * Update one user on table User
   */
  public function update()
  {
    $sql = "UPDATE {$this->table} SET username = :username, email = :email, password = :password, id_role = :id_role, active = :active WHERE id = :id_user";
    $values = [
      ':username' => $this->username,
      ':email' => $this->email,
      ':password' => $this->password,
      ':id_role' => $this->id_role,
      ':id_user' => $this->id,
      ':active' => $this->active,

    ];

    return $this->request($sql, $values);
  }

  /**
   * Get all user with role(label) on database
   */
  public function getAllUsers()
  {
    $model = new UserModel;
    $usersModel = $model->getAll();

    $allUsers = [];
    foreach ($usersModel as $userModel) {
      $user = new \stdClass();
      $user->id_User = $userModel->getId();
      $user->username = $userModel->getUsername();
      $user->email = $userModel->getEmail();
      $user->password = $userModel->getPassword();
      $user->id_Role = $userModel->getIdRole();
      $user->role = $userModel->getRole();
      $user->active = $userModel->getActive();

      $allUsers[] = $user;
    }

    return $allUsers;
  }

  public function getAllByRole($roleId)
  {
    $sql = "SELECT * FROM {$this->table} WHERE id_role = :id_role";
    $values = [
      ':id_role' => $roleId
    ];

    $query = $this->request($sql, $values);
    $allData = $query->fetchAll();

    $models = [];
    foreach ($allData as $data) {
      $self = new self();
      $self->hydrate($data);
      array_push($models, $self);
    }
    return $models;
  }

  public function getAllUsername()
  {
    $users = $this->getAll();

    $usernameList = [];

    foreach ($users as $user) {
      $usernameList[$user->getId()] = $user->getUsername();
    }
    return $usernameList;
  }


  /////////////////// GETTER and SETTER /////////////////////

  /**
   * Get the value of id_user
   */
  public function getIdUser()
  {
    return $this->id;
  }

  /**
   * Set the value of id_user
   *
   * @return  self
   */
  public function setIdUser($id_user)
  {
    $this->id = $id_user;

    return $this;
  }

  /**
   * Get the value of username
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * Set the value of username
   *
   * @return  self
   */
  public function setUsername($username)
  {
    $this->username = $username;

    return $this;
  }

  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @return  self
   */
  public function setEmail($email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of password
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @return  self
   */
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }

  public function getIdRole()
  {
    return $this->id_role;
  }

  public function setIdRole($id_Role)
  {
    $this->id_role = $id_Role;

    return $this;
  }

  /**
   * Get the value of active
   */
  public function getActive()
  {
    return $this->active;
  }

  /**
   * Set the value of active
   *
   * @return  self
   */
  public function setActive($active)
  {
    $this->active = $active;

    return $this;
  }


  /**
   * Get the value of role
   */
  public function getRole()
  {
    return (new RoleModel())->findOneById($this->id_role)->getRole();
  }
}
