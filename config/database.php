<?php
    $host = "localhost";
    $user = "root";
    $pass = "123456";
    try{
    $con = new PDO("mysql:host=$host", $user, $pass);
    $con-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE DATABASE IF NOT EXISTS Camagru";
    $con->exec($sql);
    echo "DB  made!!";
    header ("location:../config/setup.php");
        }
    catch(PDOException $e)
        {
            echo $con . "<br>" . $e->getMessage();
        }
    $con = null;
?>