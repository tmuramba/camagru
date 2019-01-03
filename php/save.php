<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "123456";
    $dbname = "Camagru";
    $usr = $_SESSION['username'];
    $src = $_POST["img"];
    $cap = $_POST["cap"];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $str = "SELECT email FROM users WHERE username='$usr'";
        $em = $conn->query($str);
        $mai = $em->fetch();
        $email = $mai['email'];
        $stmt = "INSERT INTO images (img_title,img_src,userid,email) VALUES ('$cap','$src','$usr', '$email')";
        $conn->exec($stmt);
        echo "Uploaded";
        header ("location:../html/webcam.phtml");
    }
    catch(PDOException $e)
    {
    echo $conn . "errorrorrorr <br/>" . $e->getMessage();
    }
?>