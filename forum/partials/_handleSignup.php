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

    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupcPassword'];

    //check wheather this email exits

    $exitSql = "SELECT * FROM `users` WHERE `user_email` = '$user_email'";
    $result = mysqli_query($conn, $exitSql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $showError = "Email already in use";
    } else {
        if ($pass == $cpass) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp());";
            $results = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
                header("location: /forum/index.php?signupsuccess=true");
                exit();
            }
        } else {
            $showError = "Passwords don not match";
        }
    }
    header("location: /forum/index.php?signupsuccess=false&error=$showError");
}
