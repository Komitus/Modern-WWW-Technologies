<!DOCTYPE html>
<html lang="pl-PL">

<head>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/comments.css">
  <meta charset="UTF-8">
  <meta name="description" content="Strona o mnie">
  <meta name="keywords" content="Programming, Pwr">
  <meta name="author" content="Adam Niezgoda">
  <title>Hobby</title>
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

  <?php require_once 'navbar.php';?>


  <article class="article-with-bar">
    <h2>Rowery</h2>
    <p>
      Nie tylko jężdzę, ale też naprawiam. Już kilka odrestaurowałem, poniżej zdjęcia.
    </p>
    <div class="gallery">
      <div class="gallery-elem">
        <img src="../img/moj.jpg" alt="mojRower">
      </div>
      <div class="gallery-elem">
        <img src="../img/kacper.jpg" alt="kacper">
      </div>
      <div class="gallery-elem">
        <img src="../img/michal.jpg" alt="kacper">
      </div>
      <div class="gallery-elem">
        <img src="../img/tato.jpg" alt="tatyRower">
      </div>
    </div>
  </article>

  <article class="article-with-bar">
    <h2>Wykop-pasty</h2>
    <p>
      Znam prawie wszystkie "normickie" pasty, trochę anonkowych. <br>
      Czytam od liceum
    </p>


    <pre id="article-in-hobby">
      <cite>
Mirki... znowu to zrobiłem.
Studia (nie, nie prawo) z roku na rok mi się przedłużają - 6 lat studiowania a ja ciągle na 3cim roku. Z Paniami w dziekanacie jestem prawie na "cześć" a Pani Dziekan jak mnie zobaczy zawsze rzuci z uśmieszkiem na twarzy: "ooo Pan Anon, Pan jeszcze u nas studiuje?" lub coś w tym rodzaju. Tak właściwie to utknąłem na dwóch przedmiotach, więc nie mam za dużo zajęć. 2 lata temu postanowiłem urozmaicić sobie studiowanie... wtedy jeszcze nie wiedziałem, że stanie się to moim rytuałem.
1 października, uroczyste rozpoczęcie roku akademickiego, cała aula wypełniona pierwszorocznikami. To już trzeci raz. Trzeci raz zagracie w moją grę. Wstaję wcześnie rano i już wiem, że to będzie cudowny dzień. Śniadanie, prysznic, mycie zębów. Nie golę się. Wyjmuje z szafy starą, brązową marynarkę. Chcę wyglądać na zmęczonego życiem belfra. Spod łóżka wyciągam czarną, skórzaną aktówkę. W środku mam notatki z poprzednich roczników, ale ONI o tym nie wiedzą. Ruszam na uczelnię. Czekam. Kończy się uroczystość a ja czekam już pod drzwiami auli. Stoję gdzieś z boku i czekam i wypatruję swojej ofiary. Nie biorę pierwszych lepszych, zawsze wybieram tych ze strachem w oczach, tych którzy narobią w majtki gdy tylko do nich podejdę. Mam. Są. W tym roku jest ich dwóch. Dwóch niskich, szczupłych chłopaczków, w okularach. Nerwowo rozglądają się dookoła. Stoję kilka metrów obok i czekam na ich najmniejszy błąd: "ale nudny wykład", jakiekolwiek przekleństwo czy słowo krytyki... JEST! "po**bało ich z tym planem zajęć" zabrzmiało niczym gong rozpoczynający walkę. Przechodzi mnie zimny dreszcz podniecenia, wiem że to już, zaraz się zacznie. Podchodzę i mówię:
- Poproszę Panów nazwiska.
- Ale yy.. ee o co cho...
- Nazwiska proszę.
- Marcin Srającywmajtki, Adrian Kujoniasty
(wyjmuję z marynarki notes i długopis i zapisuję)
- Jeśli nie podoba Wam się plan zajęć, to na moje zajęcia nie musicie już przychodzić. Właściwie to nie macie się już po co pokazywać.
- Ale.. ale... jak to...
- A żeby było ciekawiej, nie powiem Wam, które to zajęcia. Do widzenia Panom.
- ...
Znowu wygrałem. Odchodzę pewnym krokiem w kierunku windy. Wiem, że stoją tam jeszcze przez chwilę i patrzą na mnie. Wykorzystuję to przyciskając guzik wskazujący 7 piętro i przez zasuwające się drzwi rzucam im ostatnie, pogardliwe spojrzenie.
Z uczelni wychodzę tylnym wyjściem. Już mnie nie znajdą. Wiem, że będą szukać. Będą chcieli przeprosić, błagać o szansę. Ale mnie już nie ma. Wiem, że przez następne 2 tygodnie będą czekać przed salą na kolejne zajęcia. W ich głowach będzie kołotała tylko jedna myśl: "czy to już? czy zaraz do sali wejdzie ON?"
A ja? Ja będę siedział w domu i przeglądał mirko. A oni tam, ze swoim planem wyjaśnień, czekają uwiązani strachem i niepewnością.....
Tak to ja. Student 3 roku.
    </cite>   
  </pre>
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
          
          $article_name = "hobby";
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
            <input hidden=true name="article" value="hobby">
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