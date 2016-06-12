<?php
    include_once("./config.php");
    $_SESSION['status'] = 0;
    $_SESSION['error'] = 0;
    session_destroy();
    header("Location: ./index.php");
    exit;
?>