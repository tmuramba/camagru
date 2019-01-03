<?php
session_start();
{
    if (!empty($_SESSION['username']))
    {
        header("location:../html/home.phtml");
    }
}
include("password.php");
include("verify.php");
$servername = "localhost";
$username1 = "root";
$password = "123456";
$dbname = "Camagru";

    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    if($password1 != $password2)
    {
        echo "Passwords do not match";
        header('refresh:3; url="../html/signup.html"');

    }
    elseif(!checkpassword($password1))
    {
        header('refresh:3; url="../html/signup.html"');
    }
    else 
    {
        $pass = md5($password1);
        try 
        {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username1, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->query('SELECT * FROM users');
            while($row = $stmt->fetch())
            {
                if($row['username'] === $username || $row['email'] === $email || $row['username'] === "guest")
                {
                    echo "Username or Email already exists";
                    $u = 1;
                    break;
                }
            }
            if ($u == 0)
            {
                $code = rand(100000, 999999);
                $sql = ("INSERT INTO users (username,firstname,lastname,email,pasword,confirm,code) VALUES ('$username', '$firstname' , '$lastname', '$email' ,'$pass' , false , '$code')");
                $na = $pdo->prepare($sql);
                $na->execute();
                $link = "http://localhost:8080/Camagru/php/verify.php?user=".$username."&code=".$code;
                $body = "Your verification link is ".$link;
                mail($email,"CAMAGRU_ : Account Confimation mail", $body);
                echo "Confimation link has been sent to ".$email;
                header('refresh:3; url="../html/login.phtml"');
            }
        }
        catch(PDOException $e)
        {
            echo $sql . "errorrorrorr" . $e->getMessage();
        }
    }
    $conn = null;
?>
