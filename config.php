<?php
    // Variabili per la connessione
    $hostname = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "ecommerceDB";
    $salt = '$3CuR1tY';

    // Stabilisci connessione
    $link = mysql_connect($hostname,$username,$password) or die("Impossibile connettere a MySQL: ".mysql_error());
    $db = mysql_select_db($dbname,$link) or die("Impossibile accedere al database: ".mysql_error());

    // Riporta gli errori incontrati
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Inizia sessione
    session_start();
?>
