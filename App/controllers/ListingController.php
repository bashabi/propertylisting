<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class ListingController
{
    protected $db;

    public function __construct()
    {
        $config = require basepath('config/db.php');
        $this->db = new Database($config);
    }

    public function index()
    {
        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();


        loadView('listings/index', [
            'listings' => $listings
        ]);
    }

    public function show($params)
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * from listings where id = :id', $params)->fetch();

        //check if $listing exists
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        loadView('listings/show', [
            'listing' => $listing
        ]);
    }

    public function create()
    {
        loadView('listings/create');
    }

    public function store()
    {
        $allowedFields = ['title', 'description', 'price', 'type', 'address', 'city', 'state', 'phone', 'email'];

        //To insert data only via form input and via Post method compare if the $_post data are in allowed fields
        $inputData = array_intersect_key($_POST, array_flip($allowedFields));

        $inputData['user_id'] = 1;

        //Sanitize Data
        $inputData = array_map('sanitize', $inputData);

        $requiredFields = ['title', 'description', 'price', 'type', 'address', 'city', 'state', 'phone', 'email'];
        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($inputData[$field]) || !Validation::string($inputData[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            //reload value with error
            loadView('listings/create', [
                'errors'   => $errors,
                'listing'  => $inputData
            ]);
        } else {

            $fields = [];
            foreach ($inputData as $field => $value) {
                $fields[] = $field;
            }
            $fields = implode(', ', $fields);

            $values = [];
            foreach ($inputData as $field => $value) {
                //convert empty string to null
                if ($value == '') {
                    $inputData[$field] = null;
                }
                $values[] = ':' . $field;
            }
            $values = implode(', ', $values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";
            $this->db->query($query, $inputData);

            redirect('/listings');
        }
    }
}
