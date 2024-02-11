<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "idiscuss";

$conn = null;
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("could not connect to database" . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $category_title = $_POST['categoryTitle'];
    $category_desc = $_POST['categoryDes'];

    //check wheather this email exits
    echo $category_title;
    echo $category_desc;

    $sql = "INSERT INTO `categories` ( `category_name`, `category_description`, `created`) VALUES ('$category_title', '$category_desc', current_timestamp());";
    $result = mysqli_query($conn, $sql);
    header("location: /forum/index.php?showAlertss=true");
    exit();
}
