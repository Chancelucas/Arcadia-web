<?php

namespace Source\Models\user;

use Source\Models\MainModel;

class UserModel extends MainModel
{
    protected $id_user;
    protected $username;
    protected $email;
    protected $password;
    protected $role;

    public function __construct()
    {
        $this->table = 'User';
    }

    public function findOneByEmail(string $email)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE email = ?", [$email])->fetch();
    }

    public function findOneById(int $id)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE id_User = ?", [$id])->fetch();
    }

    public function setSession()
    {
        $_SESSION['user'] = [
            'id_user' => $this->id_user,
            'email' => $this->email,
            'username' => $this->username,
            'role' => $this->role,
        ];

        $_SESSION['error'] = "";
        $_SESSION['message'] = "";
    }

    public function getAllUser()
    {
        return $this->findAll($this->table);
    }

    public function createUser()
    {
        return $this->create();
    }

    public function delete(int $id)
    {
        return $this->request("DELETE FROM {$this->table} WHERE id_User = ?", [$id])->fetch();
    }

    public function updateUser()
    {
        return $this->update();
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

    /**
     * Get the value of role
     */
    public function getRole()
    {
        $role = $this->role;

        $role[] = 'role';

        return array_unique($role);
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
