<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "first_database";

    $db = new mysqli($hostname,$username,$password,$database);
    session_start();
?>