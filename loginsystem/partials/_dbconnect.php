<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "users";

$conn = null;
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("cannot connect to database" . mysqli_connect_error());
} else {
    //echo "Successfully connected";
}
