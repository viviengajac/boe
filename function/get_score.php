<?php
    $sql = "SELECT * FROM `score` WHERE `map` = $map ORDER BY score DESC";
    $result = $con->query($sql);
?>