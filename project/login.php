<?php

session_start();

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "user";
$conn = null;

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("connection failed:" . mysqli_connect_error());
} else {
    //    echo "Connected Successfully";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM `login` WHERE username='$username' AND password='$password' ";

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);

    if ($row) {
        if ($row["usertype"] == "user") {
            $_SESSION["username"] = $username;
            header("location:userhome.php");
        } elseif ($row["usertype"] == "admin") {
            $_SESSION["username"] = $username;
            header("location:adminhome.php");
        }
    } else {
        // Username or password is incorrect
        $sql_username_check = "SELECT * FROM `login` WHERE username='$username'";
        $result_username_check = mysqli_query($conn, $sql_username_check);
        $row_username_check = mysqli_fetch_assoc($result_username_check);

        if (!$row_username_check) {
            echo "Username is incorrect";
        } elseif ($row_username_check["password"] != $password) {
            echo "Password is incorrect";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            /* Fallback color */
            background-image: linear-gradient(45deg, #f0f0f0, #f0f0f0);
            /* Fallback gradient */
        }

        .card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            width: 100%;
            text-align: center;
        }

        .card label {
            display: block;
            margin-bottom: 10px;
            text-align: left;
        }

        .card input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .toggle-password {
            cursor: pointer;
            color: #007bff;
            margin-top: 10px;
            text-decoration: underline;
            display: block;
        }
    </style>
</head>

<body>

    <Form action="#" method="post">
        <div class="card" id="loginCard">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <div>
                <input type="password" id="password" name="password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility()">Show password</span>
            </div>
            <input type="submit" value="Login">
        </div>
    </Form>
    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                document.querySelector(".toggle-password").innerText = "Hide password";
            } else {
                passwordField.type = "password";
                document.querySelector(".toggle-password").innerText = "Show password";
            }
        }

        function generateRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function updateCardColor() {
            var card = document.getElementById("loginCard");
            var color1 = generateRandomColor();
            var color2 = generateRandomColor();
            card.style.backgroundImage = "linear-gradient(45deg, " + color1 + ", " + color2 + ")";
        }

        setInterval(updateCardColor, 5000); // Update color every 5 seconds
        updateCardColor(); // Initial update
    </script>

</body>

</html>