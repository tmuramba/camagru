<?php
    session_start();
    if (empty($_SESSION['username']))
	{
        echo "please login first you will be redirected in 3 seconds";
		header('refresh:3; url="../html/login.phtml"');
    }
    else{
    $dte = $_POST['date'];

    $servername = "localhost";
    $username = "root";
    $password = "123456";       
    $dbname = "Camagru";

    try
    {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = "SELECT * FROM images";
        $tmp = $conn->query($stmt);
        while($res = $tmp->fetch())
        {
            if($res['reg_date'] === $dte)
            {
                $nw = $res['likes'] + 1;
                $sql = "UPDATE images SET likes='$nw' WHERE reg_date='$dte'";
                $conn->exec($sql);
                header("location:../html/home.phtml");
                echo ($_SESSION['username']);
                break ;
            }
        }
    }
    catch(PDOException $e)
    {
        echo $conn . "errorrorrorr <br/>" . $e->getMessage();
    }
}
?>