<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss Coding</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        html,
        body {
            height: 100%;
        }


        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 24px;
            /* adjust according to your footer height */
        }
    </style>

    <title>iDiscuss - Coding forums</title>
</head>

<body>
    <?php include "partials/_header.php" ?>
    <?php include "partials/_dbconnect.php" ?>


    <?php
    $id = $_GET['catid'];
    // $userid = $_GET['userid'];
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //insert thread into threads db
        $th_title = $_POST['title'];
        //saving the xss attack
        $th_title = str_replace("<", "&lt", $th_title);
        $th_title = str_replace(">", "&gt", $th_title);
        //saving
        $th_desc = $_POST['desc'];
        $th_desc = str_replace("<", "&lt", $th_desc);
        $th_desc = str_replace(">", "&gt", $th_desc);

        $userid = $_POST['slno'];

        // echo $th_title;
        // echo $th_desc;
        // echo $id;

        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$userid', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your thread has been added! Please wait for community to respond
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                     </button>
                    </div>';
        }
    }
    ?>


    <?php

    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE `category_id`='$id'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>


    <!-- category conatiner starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> forums!</h1>
            <p class="lead"><?php echo $catdesc; ?> </p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each other.<br>
            <ol>
                <li>Keep it friendly.<br></li>
                <li>Be courteous and respectful. Appreciate that others may have an opinion different from yours.<br></li>
                <li>Stay on topic.<br></li>
                <li>Share your knowledge.<br></li>
                <li>Refrain from demeaning, discriminatory, or harassing behaviour and speech.<br></li>
            </ol>
            </p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>


    <?php


    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {


        echo '<div class="container">
        <h1 class="text-center py-2">Start a Discussion</h1>
        <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Thread Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">Keep your title as crisp and short as possible</small>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Elaborate Your Concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                <input type="hidden" name="slno" value="' . $_SESSION['userid'] . '">
            </div>
            <button type="submit" class="btn btn-success">Submit</button><br>
            &nbsp;
            &nbsp;
            &nbsp;
        </form>
    </div>';
    } else {
        echo '<div class="container">
        <h1 class="text-center py-2">Start a Discussion</h1>
        <p class="lead text-center">You are not Logged in. Please login to start Discussions </p>
        </div>';
    }
    ?>




    <!--Jumbotron-->
    <!-- <div class="container mb-5">
        <h1 class="text-center py-2">Browse Questions</h1>

        <?php

        $id = $_GET['catid'];
        //$userid = $_GET['userid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];

            $sql2 = "SELECT `user_email` FROM `users` WHERE `slno` = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);


            echo    '<div class="media my-3">
            <img src="img/userdefault.jfif" width="54px" class="mr-3" alt="...">
            <div class="media-body">' .
                '<h5 class="mt-0"> <a href="thread.php?threadid=' . $id . '">' . $title . '</a></h5>
               ' . $desc . '</div>' . '
               <div class="font-weight-bold my-0">Asked By ' . $row2['user_email'] . ' at ' . $thread_time . '
               </div>
            
        </div>
    ';
        }

        // echo var_dump($noResult);
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Threads Found</p>
              <p class="lead">Be the first person to ask a question</p>
            </div>
          </div>';
        }
        ?>


    </div> -->

    <div class="container mb-5">
        <h1 class="text-center py-2">Browse Questions</h1>

        <?php
        $id = $_GET['catid'];
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $results_per_page = 6; // You can adjust this as per your requirement

        $start_limit = ($page - 1) * $results_per_page;

        // Query to fetch paginated threads
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id LIMIT $start_limit, $results_per_page";
        $result = mysqli_query($conn, $sql);

        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $thread_id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];

            $sql2 = "SELECT `user_email` FROM `users` WHERE `slno` = '$thread_user_id'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo '<div class="media my-3">
                <img src="img/userdefault.jfif" width="54px" class="mr-3" alt="...">
                <div class="media-body">
                    <h5 class="mt-0"> <a href="thread.php?threadid=' . $thread_id . '">' . $title . '</a></h5>
                    ' . $desc . '
                </div>
                <div class="font-weight-bold my-0">Asked By ' . $row2['user_email'] . ' at ' . $thread_time . '</div>
            </div>';
        }

        // Check if pagination is needed
        $sql_count = "SELECT COUNT(*) AS total FROM `threads` WHERE thread_cat_id = $id";
        $result_count = mysqli_query($conn, $sql_count);
        $row_count = mysqli_fetch_assoc($result_count);
        $total_threads = $row_count['total'];

        if (!$noResult && $total_threads > $results_per_page) {
            // Pagination links
            $total_pages = ceil($total_threads / $results_per_page);

            echo '<div class="pagination mt-3">';
            if ($page > 1) {
                echo '<a href="?catid=' . $id . '&page=' . ($page - 1) . '" class="btn btn-primary">&laquo; Previous</a>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                $activeClass = ($page == $i) ? 'active' : ''; // Check if current page
                echo '<a href="?catid=' . $id . '&page=' . $i . '" class="btn btn-primary ' . $activeClass . '">' . $i . '</a>';
            }
            if ($page < $total_pages) {
                echo '<a href="?catid=' . $id . '&page=' . ($page + 1) . '" class="btn btn-primary">Next &raquo;</a>';
            }
            echo '</div>';
        }

        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <p class="display-4">No Threads Found</p>
                    <p class="lead">Be the first person to ask a question</p>
                </div>
            </div>';
        }
        ?>
    </div>




    &nbsp;
    &nbsp;
    &nbsp;
    <?php include "partials/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>