<?php

class User {
    public $id;
    public $username;
    public $email;
    private $password;
    protected $roleName;

    public function __construct(int $id, string $username, string $email, string $password, string $roleName)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roleName = $roleName; 
    }

    // Get //

    public function getId() : int {
        return $this->id;
    }

    public function getUsername() : string {
        return $this->username;
    }

    public function getEmail() : string {
        return $this->email;
    }

    private function getPassword() : string {
        return $this->password;
    }

    protected function getRole() : string {
        return $this->roleName;
    }

    // Set //

    public function setId(int $id) {
        return $this->id;
    }

    public function setUsername(string $username) {
        return $this->username;
    }

    public function setEmail(string $email) {
        return $this->email;
    }

    private function setPassword(string $password) {
        return $this->password;
    }

    protected function setRole(string $roleName) {
        return $this->roleName;
    }

}