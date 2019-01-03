<?php
    session_start();
    if (empty($_SESSION['username']))
	{
        echo "please login first you will be redirected in 3 seconds";
		header('refresh:5; url="../html/login.phtml"');
    }
    else
    {
    $com = $_POST['com'];
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
                if (!empty($res['comments']))
                {
                    $str = array();
                    $str = unserialize($res['comments']);
                    array_push($str,$com);
                    $fin = serialize($str);
                }
                else
                {
                    $str = array($com);
                    $fin = serialize($str);
                }
                $sql = "UPDATE images SET comments='$fin' WHERE reg_date='$dte'";
                $conn->exec($sql);
                $username = $res['userid'];
                break ;
            }
        }
        $stmt = "SELECT * FROM users";
        $tmp = $conn->query($stmt);
        while($res = $tmp->fetch())
        {
            if($res['username'] === $username)
            {
                if($res['mail'] == true)
                {
                    $mai = "User ".$_SESSION['username']." commented on your photo";
                    $email = $res['email'];
                    mail($email,"CAMAGRU COMMENT", $mai);
                }
                break;
            }
        }
        header("location:../html/home.phtml");
    }
    catch(PDOException $e)
    {
        echo $conn . "errorrorrorr <br/>" . $e->getMessage();
    }
}
?>