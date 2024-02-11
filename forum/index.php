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


    <!-- slider starts here  -->
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slider-1.png" style="height: 600px;" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider-2.webp" style="height: 600px;" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider-3.webp" style="height: 600px;" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <!-- category conatiner starts here -->
    <div class="container mb-5">
        <h2 class="text-center">iDiscuss - Browse Categories</h2>
        <div class="row my-4">

            <!-- fetch all the categories -->
            <!-- Use a loop to iterate through categories -->

            <!-- <?php

                    $sql = "SELECT * FROM `categories` ";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {


                        $id = $row["category_id"];
                        $cat = $row["category_name"];
                        $catDes = $row["category_description"];

                        echo '<div class="col-md-4 mb-3">
                <div class="card my-2" style="width: 18rem;" >
                    <img src="https://source.unsplash.com/500x400/?' . $cat . ',coding" class="card-img-top" alt="Please wait image is loading">
                    <div class="card-body">
                        <h5 class="card-title"> <a href="threadlist.php?catid=' . $id . '">' . $cat . '</a> </h5>
                        <p class="card-text">' . substr($catDes, 0, 25) . '...</p>
                        <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                    </div>
                </div>
            </div>';
                    }
                    ?> -->

            <?php
            // Pagination configuration
            $results_per_page = 6; // Adjust as needed
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start_limit = ($page - 1) * $results_per_page;

            // Query to fetch categories
            $sql = "SELECT * FROM `categories` LIMIT $start_limit, $results_per_page";
            $result = mysqli_query($conn, $sql);

            // Check if there are categories
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row["category_id"];
                    $cat = $row["category_name"];
                    $catDes = $row["category_description"];

                    echo '<div class="col-md-4 mb-3">
                <div class="card my-2" style="width: 18rem;" >
                    <img src="https://source.unsplash.com/500x400/?' . $cat . ',coding" class="card-img-top" alt="Please wait image is loading">
                    <div class="card-body">
                        <h5 class="card-title"> <a href="threadlist.php?catid=' . $id . '">' . $cat . '</a> </h5>
                        <p class="card-text">' . substr($catDes, 0, 25) . '...</p>
                        <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View Threads</a>
                    </div>
                </div>
            </div>';
                }

                // Pagination links
                $sql_count = "SELECT COUNT(*) AS total FROM `categories`";
                $result_count = mysqli_query($conn, $sql_count);
                $row_count = mysqli_fetch_assoc($result_count);
                $total_pages = ceil($row_count['total'] / $results_per_page);

                echo '<div class="pagination mt-3 mb-5">';
                if ($page > 1) {
                    echo '<a href="?page=' . ($page - 1) . '" class="btn btn-primary">&laquo; Previous</a>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    $activeClass = ($page == $i) ? 'active' : '';
                    echo '<a href="?page=' . $i . '" class="btn btn-primary ' . $activeClass . '">' . $i . '</a>';
                }
                if ($page < $total_pages) {
                    echo '<a href="?page=' . ($page + 1) . '" class="btn btn-primary">Next &raquo;</a>';
                }
                echo '</div>';
            } else {
                // No categories found
                echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
                <p class="display-4">No Categories Found</p>
            </div>
        </div>';
            }
            ?>




            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;

        </div>
    </div>

    <?php include "partials/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>