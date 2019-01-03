<?php
include ("password.php");
$user = 0;
$pass = 0;
$mail = 0;
$first = 0;
$last = 0;

    if (!empty($_POST['username']))
    {
        $username = ($_POST['username']);
        $user = 1;
    }
    if (!empty($_POST['firstname']))
    {
        $firstname = ($_POST['firstname']);
        $first = 1;
    }
    if(!empty($_POST['lastname']))
    {
        $lastname = ($_POST['lastname']);
        $last = 1;
    }
    if (!empty($_POST['email']))
    {
        $email = ($_POST['email']);
        $mail = 1;
    }
    if(!empty($_POST['password']))
    {
        $password = ($_POST['password']);
        $pass = 1;
    } 

    try
    {
        session_start();
        $usr = $_SESSION['username'];
        $pdo = new PDO("mysql:host=localhost;dbname=Camagru","root", "123456");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->query("SELECT * FROM users");
        while($row = $stmt->fetch())
        {
            if($row['username'] == $usr && ($first || $user || $last || $pass || $mail))
            {
                if($last == 1 && $lastname != NULL)
                {
                    $sql = "UPDATE users SET lastname='$lastname' WHERE username='$usr'";
                    $na = $pdo->prepare($sql);
                    $na->execute();
                    echo "lastname has been changed <br/>";
                }
                if($first == 1)
                {
                    $sql = "UPDATE users SET firstname='$firstname' WHERE username='$usr'";
                    $na = $pdo->prepare($sql);
                    $na->execute();
                    echo "firstname has been changed <br/>";
                }
                
                if($user == 1 || $pass == 1 || $mail == 1)
                {
                    $s = $pdo->query("SELECT * FROM users");
                    if ($user == 1)
                    {
                        while($r = $s->fetch())
                        {
                            if($r['username'] === $username)
                            {
                                echo "Username currently in use";
                                $user = 0;
                                break ;
                            }
                        }
                    }
                    $s = $pdo->query("SELECT * FROM users");
                    if ($mail == 1)
                    {
                        while($r = $s->fetch())
                        {
                            if ($r['email'] === $email)
                            {
                                echo "Email currently in use";
                                $mail = 0;
                                break ;
                            }
                        }                         
                    }
                    if($pass == 1)
                    {
                        if(!checkpassword($password))
                        {
                            echo "password error";
                            $pass = 0;
                        }
                    }
                    if ($user == 1 || $pass == 1 || $mail == 1)
                    {
                        if ($pass == 1)
                        {
                            $hash = md5($password);
                            $sql = "UPDATE users SET pasword='$hash' WHERE username='$usr'";
                            $na = $pdo->prepare($sql);
                            $na->execute();
                            echo "Password Successfully changed.</br>";
                        }
                        if ($mail == 1)
                        {
                            $s = $pdo->query("SELECT * FROM images");
                            while($r = $s->fetch())
                            {
                                if($r['userid'] === $usr)
                                {
                                    $sql = "UPDATE images SET email='$email' WHERE userid='$usr'";
                                    $na = $pdo->prepare($sql);
                                    $na->execute();
                                }
                            }
                            $sql = "UPDATE users SET email='$email' WHERE username='$usr'";
                            $na = $pdo->prepare($sql);
                            $na->execute();
                            echo "Email Successfully changed.</br>";
                            session_unset();
                            $_SESSION['email'] = $email;
                        }
                        if ($user == 1)
                        {
                            $s = $pdo->query("SELECT * FROM images");
                            while($r = $s->fetch())
                            {
                                if($r['userid'] === $usr)
                                {
                                    $sql = "UPDATE images SET userid='$username' WHERE userid='$usr'";
                                    $na = $pdo->prepare($sql);
                                    $na->execute();
                                }
                            }
                            $sql = "UPDATE users SET username='$username' WHERE username='$usr'";
                            $na = $pdo->prepare($sql);
                            $na->execute();
                            echo "Username Successfully changed.</br>";
                            session_unset();
                            $_SESSION['username'] = $username;
                        }
                    }
                }
                echo "you will be redirected in 3 seconds!!!!!!";
                header('refresh:3; url="../html/profile.phtml"');
            }
        }
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
?>