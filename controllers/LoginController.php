<?php
require_once '../models/login/FormLoginModel.php';
require_once '../models/login/LoginModel.php';

class LoginController
{
    public function login() {
        require_once('../views/templates/form/form_login_page.php');
    }
}
?>
