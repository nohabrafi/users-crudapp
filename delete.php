<?php
require_once 'users/user-functions.php';
include 'partials/header.php';

deleteUser($_GET['id']);

// include the footer
include 'partials/footer.php'; 