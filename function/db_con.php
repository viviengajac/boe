<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "boe";
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $con->set_charset("utf8");
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());
    }
?>