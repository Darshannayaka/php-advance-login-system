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



    <!-- search Results-->
    <div class="container my-3">
        <h1>Search Results for <em>"<?php echo $_GET['search']; ?>"</em></h1>
        <?php
        $noresults = true;
        $query = $_GET["search"];
        $sql = "SELECT * FROM threads WHERE MATCH (thread_title,thread_desc) against ('$query')";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_id = $row['thread_id'];
            $noresults = false;
            echo '<div class="result">
            <h3><a href="thread.php?threadid=' . $thread_id . '" class="text-dark">' . $title . '</a> </h3>
                <p>' . $desc . '</p>
            </div>';
        }

        if ($noresults) {
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Records Found</p>
              <p class="lead">Suggestions: <ul>
              <li>Make sure that all words are spelled correctly.</li>
              <li>Try different words.</li>
              <li>Try more general keywords.</li>
              </ul></p>
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