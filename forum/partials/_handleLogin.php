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

$showError = "false";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["loginEmail"];
    $pass = $_POST["loginPass"];

    $sql = "SELECT * FROM `users` WHERE `user_email` = '$email' ";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($pass, $row['user_pass'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['useremail'] = $email;
            $_SESSION['userid'] = $row['slno'];
            // echo "logged in" . $email;
            //  header("Location: /forum/index.php");
            //  exit();
        } // else {
        // echo "unable to login";
        header("Location: /forum/index.php");
    }
    header("Location: /forum/index.php");
}
