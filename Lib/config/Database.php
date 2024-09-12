<?php

namespace Lib\config;

use PDO;
use PDOException;
use Source\Models\role\RoleModel;
use Source\Models\user\UserModel;

class Database extends PDO
{
    private static $instance;

    // private const DBHOST = 'localhost';
    private const DBHOST = '127.0.0.1';
    private const DBPORT = 8889;
    private const DBNAME = 'arcadia';
    private const DBUSERNAME = 'root';
    private const DBPASS = 'root';

    public function __construct()
    {
        $_dsn = 'mysql:host=' . self::DBHOST . ';port=' . self::DBPORT . ';dbname=' . self::DBNAME;
        try {
            parent::__construct($_dsn, self::DBUSERNAME, self::DBPASS);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //getInstance
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        };
        return self::$instance;
    }

    //firstLogin
    public static function firstLogin()
    {
        $pdo = self::getInstance();

        $stmt = $pdo->query('SELECT COUNT(0) FROM User');
        $count = $stmt->fetchColumn();
        return $count === 0;
    }

    //createAdminUser
    public static function fixtureAdmin()
    {
        $pdo = self::getInstance();


        $email = 'a@a';
        $username = 'admin';
        $password = 'a';

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $adminRole = 'Admin';

        $existingUser = (new UserModel)->findOneByEmail($email);

        if (!is_null($existingUser)) {
            echo "L'utilisateur admin existe déjà";
            return;
        }

        // get role_id from role (Admin)
        $roleId = (new RoleModel)->findOneByRole($adminRole)->getId();

        try {
            $user = new UserModel;

            $user->setUsername($username)
                ->setEmail($email)
                ->setPassword($hashedPassword)
                ->setIdRole($roleId);

            $user->createUser();

            echo "L'utilisateur admin a été créé avec succès.";
        } catch (PDOException $e) {
            echo "Erreur lors de la création de l'utilisateur admin : " . $e->getMessage();
        }
    }
}