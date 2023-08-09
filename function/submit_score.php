<?php
    session_start();
    $map = $_POST['mapId'];
    $name = $_POST['playerName'];
    $score = $_POST['playerScore'];
    $wave = $_POST['lastWave'];
    include('db_con.php');
    $sql = "INSERT INTO `score` (`id_score`, `map`, `name`, `score`, `wave`)
    VALUES
    (null, $map, '$name', $score, $wave)";
    
    if ($con->query($sql) === TRUE) {
        //echo "ok";
        header("location: /boe");
    }
    else {
        echo $con->error;
    }
    $con -> close();
?>