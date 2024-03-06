<?php

namespace Source\Controllers;

use Source\Models\templates\UserModel;

class UserController extends Controller
{
    /**
     * Affiche tout les employer de la BDD
     * 
    */
    public function index()
    {
        $userModel = new UserModel;
        $user = $userModel->findAll();

        $this->render('user/user', compact('user'));

    } 

    
}