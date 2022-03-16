<?php 

function connectToDB($db){
    $host = "localhost";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($host, $username, $password, $db);

    if (!$conn) {
        die("<script>console.log('Connection failed')</script>" . "Connection failed: " . mysqli_connect_error());
    }
    echo "<script>console.log('Connection succesful!')</script>";

    return $conn;
}
