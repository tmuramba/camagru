<?php
session_start();
$username = $_SESSION['username'];
try
{
    $pdo = new PDO("mysql:host=localhost;dbname=Camagru","root", "123456");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM users");
    while($row = $stmt->fetch())
    {
        if($row['username'] == $username)
        {
            if($row['mail'] == true)
            {
                $sql = "UPDATE users SET mail=false WHERE username='$username'";
                $na = $pdo->prepare($sql);
                $na->execute();
                echo "you will not recive notifications anymore";
            }
            else
            {
                $sql = "UPDATE users SET mail=true WHERE username='$username'";
                $na = $pdo->prepare($sql);
                $na->execute();
                echo "you will now recive notificatins";
            }
        }
    }
    header('refresh:3; url="../html/profile.phtml"');
}
catch(PDOException $e)
{
   echo $conn . "errorrorrorr <br/>" . $e->getMessage();
}
?>