<?php
    session_start();
	if (!empty($_SESSION['username']))
	{
		header("location:../html/home.phtml");
	}
	else{
	$connect = new PDO('mysql:host=localhost;dbname=camagru', 'root', '123456');
	if(isset($_POST['login']))
	{
		$username = $_POST['username'];
		$pasword = $_POST['password'];

		$password = md5($pasword);
		$query = $connect->prepare("SELECT COUNT(`id`) FROM `users` WHERE `username` = '$username' AND `pasword` = '$password' AND `confirm` = true");
		$query->execute();

		$count = $query->fetchColumn();

		if($count == "1") 
		{
			$_SESSION['username'] = $username;
            echo $_SESSION['username']."you are loged in";
			header('refresh:3; url="../html/home.phtml"');
		}
		else
		{
			echo "username or password incorrect ....... please check email verification also<br/>"."you will be redirected in 5 seconds";
			header('refresh:5; url="../html/login.phtml"');
		}
	}
}
?>