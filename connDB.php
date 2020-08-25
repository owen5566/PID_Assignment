<?php
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "root";
    $dbName = "PID_db";
    $dbPort = 8889;
    
    $link = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName,$dbPort) or die(mysqli_connect_error());
    $result = mysqli_query($link, "use names utf8");
?>