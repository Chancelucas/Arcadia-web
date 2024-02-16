<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


var_dump($_POST);

if (!empty($_POST)) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $valid = (bool) true;

    if (isset($_POST['connection'])) {
        $email = trim($email);
        $password = trim($password);

        if (empty($email)) {
            $valid = false;
            $err_email = "Ce champ ne peux pas être vide";
        }
        if (empty($password)) {
            $valid = false;
            $err_password = "Ce champ ne peux pas être vide";
        }

        if ($valid) {
            echo 'ok';
        } else {
            echo 'nok';
        }
    }
}




var_dump($_POST);

if (!empty($_POST)) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $valid = (bool) true;

    if (isset($_POST['connection'])) {
        $email = trim($email);
        $password = trim($password);

        if (empty($email)) {
            $valid = false;
            $err_email = "Ce champ ne peux pas être vide";
        }
        if (empty($password)) {
            $valid = false;
            $err_password = "Ce champ ne peux pas être vide";
        }

        if ($valid) {
            echo 'ok';
        } else {
            echo 'nok';
        }
    }
}

