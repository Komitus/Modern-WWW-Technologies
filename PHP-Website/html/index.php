<!DOCTYPE html>
<html lang="pl-PL">

<head>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/comments.css">
  <meta charset="UTF-8">
  <meta name="description" content="Strona o mnie">
  <meta name="keywords" content="Programming, Pwr">
  <meta name="author" content="Adam Niezgoda">

  <title>Strona główna</title>
  <noscript>
    <style>
      #menu_options {
        display: block;
      }

      #hamburger {
        display: none;
      }
    </style>
  </noscript>
</head>

<body>
  <?php require_once "navbar.php";?>

  <article id="start_article">
    <img id="photo_of_me" src="../img/ja.jpg" alt="Zdjęcie przedstawiające mnie">
    <h2>Cześć!</h2>
    <h3>Nazywam się Adam Niezgoda</h3>
    <p>Jestem studentem II roku informatyki na Wydziale Podstawowych Problemów Techniki Politechniki Wrocławskiej</p>
    <p>Określiłbym się jako studenta trójkowego, szczerze, nie idzie mi za dobrze. W tamtym semestrze udało mi się
      poprawić zaległy z I semestru kurs <a href="https://cs.pwr.edu.pl/cichon/2020_21_a/LiSF.php"
        title="Link do strony wykładowcy" target="_blank">LiSF</a>. To też nie ma czym za bardzo się czym pochwalić, ale
      jeśli będziesz chciał zobaczyć moje jakieś podstawowe projekty i/lub to czym zajmuję się po godzinach "na uczelni"
      (w sumie to ciągle przy PC, albo w edytorze czy na M$ Teams), to zapraszam do innych sekcji w pasku nawigacyjnym
      mojej strony.</p>
    <p>Skontaktować się ze mną można tylko przez maila: tu mój mail <br> albo Discorda, ponieważ nie mam konta na <img
        src="../img/fb.svg" alt="FBIcon"> </p>
  </article>

  <div class="comments">
    <h2>Mikroblog</h2>
      <?php 
        $connection = @new mysqli($host, $db_user, $db_password, $database);

        if ($connection->connect_errno!=0)
        {
          echo "<p>Error: </p>".$connection->connect_errno;
        }
        else
        {  
          
          $article_name = "index";
          $query = 'CALL select_comments('.'"'.$article_name.'")';
          $result = $connection->query($query);
          
          while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            echo '<div class="comment">';
            echo "<h3>" . $row['user'] . "</h3>";
            echo "<p>" . $row['text'] . "</p>";
            echo "</div>";
          }
          $connection->close();
        } 
      ?>

      <?php if (isset($_SESSION["id"])) { ?>
        <div class="form-add-comment">
          <form method="POST" action="comment.php">
            <input hidden=true name="article" value="index">
            <textarea placeholder="Napisz coś (max 500 znaków)" maxlength="500" name="content"></textarea>
            <input type="submit" value="Zapostuj">
          </form>
        </div>
      <?php } ?>
  </div>
  <?php require_once "footer.php";?>
 
</body>
<script src="../scripts/script.js">
</script>

</html>