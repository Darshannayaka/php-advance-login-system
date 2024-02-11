<?php
session_start();
echo "LOGGing You out... Please Wait...";

session_unset();
session_destroy();

header("Location: /forum/index.php");
