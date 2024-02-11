<?php

session_start();
include "partials/_dbconnect.php";

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand" href="/forum">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/forum">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#aboutModal">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Top Categories
                </a>
                <ul class="dropdown-menu">';

$sql = "SELECT category_name, category_id FROM `categories` ORDER BY category_id DESC LIMIT 10";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo ' <li><a class="dropdown-item" href="threadlist.php?catid=' . $row['category_id'] . '">' . $row['category_name'] . '</a></li>';
}

echo '
</ul>
</li>
    <li class="nav-item">
                <a class="nav-link" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#contactModal">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#categoryModal">Add Category</a>
            </li>
        </ul>';


//If the user login means show this
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo ' <form class="d-flex" role="search" action="search.php" method="get">
          
    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit" ">Search</button>
            <p class="text-light my-0 mx-2"> &nbsp;Welcome&nbsp;' . $_SESSION['useremail'] . '</p>    
            <a href="partials/_logout.php" class="btn btn-outline-success ml-2" >Logout</a>
            
            </form>';
} else {

    echo  '<form class="d-flex" role="search" action="search.php" method="get">
            <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
            </form>
        <div class="mx-2">
            <button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>
        </div>';
}

echo ' </div>
</div>
</nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';
include 'partials/_contactModal.php';
include 'partials/_aboutModal.php';
include 'partials/_categoryModal.php';


if (isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>Success!</strong> You can now Login
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}

if (isset($_GET['showAlertss']) && $_GET['showAlertss'] == "true") {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
        <strong>Success!</strong> Your category has been Successfully Added
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
             </button>
            </div>';
}
