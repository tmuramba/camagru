<?php
    $set = 0;
    try
    {
        $pdo = new PDO("mysql:host=localhost;dbname=Camagru","root", "123456");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->query('SELECT * FROM users');
        while($row = $stmt->fetch())
        {
            if($row['email'] === $_POST['email'])
            {
                $mai = $_POST['email'];
                $str = str_shuffle("CAMAgru179");
                $s = "Your random Password is ".$str." You can change it once logged in or keep is as you permanent password";
                $str = md5($str);
                $sql = "UPDATE users SET pasword='$str' WHERE email='$mai'";
                echo "hi";
                $na = $pdo->prepare($sql);
                $na->execute();
                echo "hello123";
                mail($mai, "CAMAGRU_ : Password Reinstallation",$s);
                $set = 1;
            }
        }
    }
    catch(PDOException $e)
    {
        echo $pdo . "<br>" . $e->getMessage();
    }
    if ($set == 0)
    {
        echo "Email not found. Please create a new account";
        header('refresh:3; url="../html/login.phtml"');
    }
?>