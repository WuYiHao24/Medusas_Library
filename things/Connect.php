<?php
$host = 'localhost';
$user = 'webserver';
$password = 'ws@2023.';
$database = "library";
$conn = mysqli_connect($host, $user, $password, $database);

if (mysqli_connect_error()) {
    exit('Error' . mysqli_connect_error());
}
?>
