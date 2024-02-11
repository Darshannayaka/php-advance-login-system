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
    $id = $_GET['threadid'];
    // $userid = $_GET['userid'];
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        //insert thread into comments db
        $comment = $_POST['comment'];
        $comment = str_replace("<", "&lt", $comment);
        $comment = str_replace(">", "&gt", $comment);
        $userid = $_POST['slno'];

        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$userid', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your Comment has been added!
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                     </button>
                    </div>';
        }
    }
    ?>

    <?php

    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE `thread_id`='$id'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];

        $sql3 = "SELECT `user_email` FROM `users` WHERE `slno` = '$thread_user_id'";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
    }
    ?>


    <!-- category conatiner starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?> </p>
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
            <p>Posted By: <em><?php echo $row3['user_email']; ?></em></p>
        </div>
    </div>

    <?php
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {


        echo ' <div class="container">
        <h1 class="text-center py-2">Post your Comment</h1>
        <form action="' . $_SERVER["REQUEST_URI"] . '" method="post">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type Your Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="slno" value="' . $_SESSION['userid'] . '">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button><br>
            &nbsp;
            &nbsp;
            &nbsp;
        </form>
    </div>';
    } else {
        echo '<div class="container">
        <h1 class="text-center py-2">Login</h1>
        <p class="lead text-center">You are not Logged in. Please login to Comment on this Post </p>
        </div>';
    }

    ?>

    <!--Jumbotron-->
    <!-- <div class="container mb-5">
        <h1 class="text-center py-2">Discussions</h1>

        <?php

        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $comment_by = $row['comment_by'];


            $sql2 = "SELECT `user_email` FROM `users` WHERE `slno` = '$comment_by'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            echo    '<div class="media my-3">
            <img src="img/userdefault.jfif" width="54px" class="mr-3" alt="...">
            <div class="media-body">
            <p class="font-weight-bold my-0"> ' . $row2['user_email'] . ' at ' . $comment_time . '</p>
               ' . $content . '
            </div>
        </div>
    ';
        }

        // echo var_dump($noResult);
        if ($noResult) {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Comments For this Thread Found</p>
              <p class="lead">Be the first person to comment on this Thread</p>
            </div>
          </div>';
        }
        ?> 
    </div>-->


    <div class="container mb-5">
        <h1 class="text-center py-2">Discussions</h1>

        <?php
        $id = $_GET['threadid'];
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $results_per_page = 6; // You can adjust this as per your requirement

        $start_limit = ($page - 1) * $results_per_page;

        // Query to fetch paginated comments
        $sql = "SELECT * FROM `comments` WHERE thread_id = $id LIMIT $start_limit, $results_per_page";
        $result = mysqli_query($conn, $sql);
        $noResult = true;

        // Check if there are more than 6 comments
        $sql_count = "SELECT COUNT(*) AS total FROM `comments` WHERE thread_id = $id";
        $result_count = mysqli_query($conn, $sql_count);
        $row_count = mysqli_fetch_assoc($result_count);
        $total_comments = $row_count['total'];

        if ($total_comments > $results_per_page) {
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $comment_id = $row['comment_id'];
                $content = $row['comment_content'];
                $comment_time = $row['comment_time'];
                $comment_by = $row['comment_by'];

                $sql2 = "SELECT `user_email` FROM `users` WHERE `slno` = '$comment_by'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);

                echo '<div class="media my-3">
                    <img src="img/userdefault.jfif" width="54px" class="mr-3" alt="...">
                    <div class="media-body">
                        <p class="font-weight-bold my-0"> ' . $row2['user_email'] . ' at ' . $comment_time . '</p>
                        ' . $content . '
                    </div>
                </div>';
            }

            // Pagination links
            $total_pages = ceil($total_comments / $results_per_page);

            echo '<div class="pagination mt-3">';
            if ($page > 1) {
                echo '<a href="?threadid=' . $id . '&page=' . ($page - 1) . '" class="btn btn-primary">&laquo; Previous</a>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                $activeClass = ($page == $i) ? 'active' : '';
                echo '<a href="?threadid=' . $id . '&page=' . $i . '" class="btn btn-primary ' . $activeClass . '">' . $i . '</a>';
            }
            if ($page < $total_pages) {
                echo '<a href="?threadid=' . $id . '&page=' . ($page + 1) . '" class="btn btn-primary">Next &raquo;</a>';
            }
            echo '</div>';
        } elseif ($total_comments > 0) { // Display comments if there are less than 6 but more than 0
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $comment_id = $row['comment_id'];
                $content = $row['comment_content'];
                $comment_time = $row['comment_time'];
                $comment_by = $row['comment_by'];

                $sql2 = "SELECT `user_email` FROM `users` WHERE `slno` = '$comment_by'";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);

                echo '<div class="media my-3">
                    <img src="img/userdefault.jfif" width="54px" class="mr-3" alt="...">
                    <div class="media-body">
                        <p class="font-weight-bold my-0"> ' . $row2['user_email'] . ' at ' . $comment_time . '</p>
                        ' . $content . '
                    </div>
                </div>';
            }
        } else {
            // No comments found
            echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <p class="display-4">No Comments For this Thread Found</p>
                    <p class="lead">Be the first person to comment on this Thread</p>
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