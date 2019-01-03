<?php
    $dte = $_POST['date'];
    
    $servername = "localhost";
    $username = "root";
    $password = "123456";       
    $dbname = "Camagru";
    
    try
    {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = "DELETE FROM images WHERE reg_date='$dte'";
        $conn->exec($stmt);
        header("location: ../html/home.phtml");
        // echo "hello";
    }
    catch(PDOException $e)
    {
        echo $conn . "errorrorrorr <br/>" . $e->getMessage();
    }
?>