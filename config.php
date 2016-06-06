<?php
    // Set up variables
    $hostname = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "ecommerceDB";

    // Set up connection
    $link = mysql_connect($hostname,$username,$password) or die("Impossibile connettere a MySQL: ".mysql_error());
    $db = mysql_select_db($dbname,$link) or die("Impossibile accedere al database: ".mysql_error());

    // Start session
    session_start();
?>
