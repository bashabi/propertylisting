<?php

namespace App\Controllers;


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

        redirect('/');
    }
}
