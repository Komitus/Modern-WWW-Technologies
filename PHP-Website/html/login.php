<?php

session_start();

require_once "tools.php";

check_timeout();

if ( isset($_SESSION['id']) && isset($_SESSION['user']) )
{
	header('Location: index.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

$connection = @new mysqli($host, $db_user, $db_password, $database);

	if ($connection->connect_errno!=0)
	{
		echo "<p>Error: </p>".$connection->connect_errno;
	}
	else
	{
		$login = mysqli_real_escape_string($connection, htmlentities($_POST['login'], ENT_QUOTES, "UTF-8"));
		$password = mysqli_real_escape_string($connection, htmlentities($_POST['password'], ENT_QUOTES, "UTF-8"));

		if ($result = @$connection->query('CALL loginUser('.'"'.$login.'"'.', "'.$password.'")'))
		{	
			$row = $result->fetch_assoc();
			if($row['id'] != '0'){
				
				$_SESSION['id'] = $row['id'];
				$_SESSION['user'] = $row['user'];
				$_SESSION['LAST_ACTIVITY'] = time();
					
				unset($_SESSION['error']);
				$result->free_result();
				$connection->close();
				header('Location: index.php');
			}
			else {
				$connection->close();
				header('Location: login.php');
				$_SESSION['error'] = '<div class="error"> Nieprawidłowy login lub hasło!</div>';	
			}	
		}
		else 
		{
			echo "<p>Error from db</p>";
		}
	}
	
}	


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Logowanie</title>
	<link rel="stylesheet" href="../css/loginstyle.css" type="text/css" />
</head>

<body>
	
	<div id="container">
		<form action="login.php" method="post">
			<input type="text" name="login" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'" >
			<input type="password" name="password" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'" >
			<input type="submit" value="Zaloguj się">
		</form>
		<p>Nie masz konta? </p>
		<a href="register.php">Zarejestruj się</a>
	</div>
	
<?php
	if(isset($_SESSION['error']))	echo $_SESSION['error'];
?>

</body>
</html>
