<?php
$config = require basepath('config/db.php');
$db = new Database($config);

$id = $_GET['id'] ?? '';

$params = [
    'id' => $id
];

$listing = $db->query('SELECT * from listings where id = :id', $params)->fetch();
loadView('listings/show', [
    'listing' => $listing
]);
