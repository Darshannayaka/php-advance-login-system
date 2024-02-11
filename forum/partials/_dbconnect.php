<?php
//script to connect to the database

$servername = "localhost";
$username = "root";
$password = "";
$database = "idiscuss";

$conn = null;
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("could not connect to database" . mysqli_connect_error());
} else {
    //  echo "connected ";
}
