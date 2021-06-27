<?php

session_start();

include "tools.php";

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
		
		if ($result = @$connection->query('CALL addUser('.'"'.$login.'"'.', "'.$password.'")'))
		{	
			$row = $result->fetch_assoc();
			if($row['result']==1){
					
				$_SESSION['error'] = '<div class="error" >Pomyślnie założono konto <br> Możesz się zalogować</div>';
				$result->free_result();
				$connection->close();
				header('Location: register.php');
			}
			else {
				$connection->close();
				header('Location: register.php');
				$_SESSION['error'] = '<div class="error" >Nazwa zajęta</div>';	
			}	
		} 
		$connection->close();
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
		<form action="register.php" method="post">
			<input type="text" name="login" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'" >
			<input type="password" name="password" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'" >
			<input type="submit" value="Zarejestruj się">
		</form>
		<p>Masz już konto? </p>
		<a href="login.php">Zaloguj się</a>
	</div>
	
<?php
	if(isset($_SESSION['error']))	echo $_SESSION['error'];
?>

</body>
</html>
