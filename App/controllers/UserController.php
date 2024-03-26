<?php

namespace App\Controllers;

use Framework\Session;
use Framework\Database;
use Framework\Validation;

class UserController
{
    protected $db;

    public function __construct()
    {
        $config = require basepath('config/db.php');
        $this->db = new Database($config);
    }

    public function login()
    {
        loadView('users/login');
    }

    public function create()
    {
        loadView('users/create');
    }

    public function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];

        $errors = [];

        //Validate Email
        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        //Validate Name
        if (!Validation::string($name, 5, 50)) {
            $errors['name'] = 'Name must be betwenn 5 and 50 charecters';
        }

        //Validate Password
        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must atleast 6 charecters';
        }

        //Validate Password and Confirm Password
        if (!Validation::match($password, $password_confirmation)) {
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            loadView('users/create', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                ]
            ]);
            exit;
        }

        //check if the email alreay exists
        $params = ['email' => $email];
        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if ($user) {
            $errors['email'] = 'The email already exists';
            loadView('users/create', [
                'errors' => $errors
            ]);
            exit;
        }

        //Create user account
        $params = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $this->db->query('INSERT INTO users (name, email, password) values (:name, :email, :password)', $params);

        //Get new user ID
        $userID = $this->db->conn->lastInsertId();
        Session::set('user', [
            'id' => $userID,
            'name' => $name,
            'email' => $email
        ]);

        redirect('/');
    }

    public function logout()
    {
        Session::clearAlL();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

        redirect('/');
    }

    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        //Validation 
        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email';
        }
        //Validation
        if (!Validation::string($password)) {
            $errors['password'] = 'Please enter a valid password';
        }

        if (!empty($errors)) {
            loadView('users/login', [
                'errors' => $errors
            ]);
            exit;
        }

        //check for email registered
        $params = ['email' => $email];
        $user = $this->db->query('SELECT * FROM users WHERE email = :email ', $params)->fetch();

        if (!$user) {
            $errors['email'] = 'Incorrect credentials';
            loadView('users/login', [
                'errors' => $errors
            ]);
            exit;
        }

        //check if password is correct
        if (!password_verify($password, $user->password)) {
            $errors['password'] = 'Incorrect credentials';
            loadView('users/login', [
                'errors' => $errors
            ]);
            exit;
        }

        //Set user Session
        Session::set('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);

        redirect('/');
    }
}
