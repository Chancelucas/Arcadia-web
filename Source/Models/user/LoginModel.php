<?php

namespace Source\Models\user;

use Source\Models\MainModel;
use Source\Models\user\UserModel;

class LoginModel extends MainModel
{

    protected $table = 'user';
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    //authenticate
    public function authenticate(string $email, string $password)
{
    $user = $this->userModel->findOneByEmail($email);

    if ($user && password_verify($password, $user->password)) {

        $_SESSION['user'] = [
            'id_user' => $user->id_user,
            'email' => $user->email,
            'username' => $user->username,
            'role' => $user->role,
        ];

        return true;
    }

    return false;
}

}


