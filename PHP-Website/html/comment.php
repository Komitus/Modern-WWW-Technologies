<?php
  session_start();
  require_once "tools.php";
  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $connection = @new mysqli($host, $db_user, $db_password, $database);

    if ($connection->connect_errno!=0)
    {
      echo "<p>Error: </p>".$connection->connect_errno;
    }
    else
    {
      $query = 'CALL add_comment('.'"'.$_POST['article'].'", "'.$_SESSION["user"].'", "'.$_POST['content'].'")';
      $connection->query($query);
      header("Location: ".$_POST["article"].".php");
    }
  } 
?>