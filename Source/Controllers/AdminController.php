<?php

namespace Source\Controllers;

use Source\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        // if($this->isAdmin()){
            
        // }
    }

    public function idAdmin()
    {
        if(isset($_SESSION['user']) && in_array('nameRole', $_SESSION['user']['role'])){
            
        }
    }
}