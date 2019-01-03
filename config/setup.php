<?php
     $host = "localhost";
     $user = "root";
     $pass = "123456";
     $dbname = "Camagru";
     try 
    {
        $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql ="CREATE TABLE IF NOT EXISTS users(
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(100) NOT NULL,
            pasword TEXT NOT NULL,
            username VARCHAR(100) NOT NULL,
            confirm BOOLEAN,
            mail BOOLEAN DEFAULT TRUE,
            code INT(6) UNSIGNED NOT NULL)";
        $con->exec($sql);
        echo "users created";

        $img_table = "CREATE TABLE IF NOT EXISTS images (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userid VARCHAR(30) NOT NULL,
            email VARCHAR(100) NOT NULL,
            img_title TEXT,
            img_src LONGTEXT NOT NULL,
            likes INT(6) UNSIGNED,
            comments TEXT,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $con->exec($img_table);
        echo "table images created";
        header ("location:../html/home.phtml");
    }
    catch(PDOException $e)
    {
        echo $con . "<br>" . $e->getMessage();
    }
?>