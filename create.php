<?php

require_once 'users/user-functions.php';
include 'partials/header.php';

$user = [
    "id" => "",
    "name" => "",
    "username" => "",
    "email" => "",
    "phone" => "",
    "website" => ""
];

// if form has been submitted
if($_SERVER['REQUEST_METHOD'] === "POST"){
    // if an image is uploaded
    if(isset($_FILES)) saveImage($_FILES, $_POST);
    createUser($_POST);
}

// include the from
include 'partials/form.php'; 
// include the footer
include 'partials/footer.php';