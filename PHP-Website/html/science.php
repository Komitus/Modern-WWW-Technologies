<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/comments.css">
    <meta charset="UTF-8">
    <meta name="description" content="Science">
    <meta name="keywords" content="Programming, Pwr">
    <meta name="author" content="Adam Niezgoda">
    <title>Nauka</title>
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
        <h2>Ogólnie</h2>
        <p>
            Z racji tego, co wspomniałem na stronie głównej, nie za bardzo mam się czym pochwalić, jedynie projekty
            klepane w ramach kursów na uczelni.
        </p>
        <ul>
            <li>Najbardziej Zainteresował mnie projekt z baz danych, ponieważ musiałem tam dużo kombinować.</li>
            <li>Drugi w kolejności jest projekt z Technologii programowania, pisany w Javie przy wykorzystaniu wzorców
                projektowych.</li>
            <li>Ostatni to program "Minitalk" na zajęcia "Architekturę komputerów i systemów operacyjnych"</li>
        </ul>
        A tak poza tym, to z przedmiotów matematycznych najbardziej lubianym przeze mnie była analiza matematyczna.
    </article>
    <div class="science_articles">
        <article class="article-with-bar">
            <h2>Bazy danych</h2>
            <h3>Projekt wypożyczalni zimowej</h3>
            Projekt robiłem razem z Wojtkiem Strzeleckim. Wykorzystaliśmy tu czysty sterownik JDBC (sami pisaliśmy każdą
            kwerendę w kodzie, uprzednio tworząc procedury SQL, i ją wywoływaliśmy - bez mapowania). Kod jest napisany w
            języku java, Maven zarządzał zależnościami, a interface został wykonany przy pomocy SceneBuilder i JavaFx.
            <h3>Przykład dodania składników do zamówienia, używający transakcji:</h3>
            <pre>
    <code class="code_for_projects">
    for(ProductData item : order.trolley)
    {
        System.out.println("teraz przy dodawaniu");
        int itemId = item.getId();
        System.out.println(itemId);
        stm = dbConnector.getConnection().
            prepareCall("{CALL dodajSkladniki(?,?) }");
        stm.setInt(1, itemId);
        stm.setInt(2, orderId);
        stm.executeQuery();
    }                             
        dbConnector.getConnection().commit();
        success = true;
            /SQL/    
                                                    
        delimiter //
        create procedure dodajSkladniki(idTowaru int(11),
             idZamowienia int(11), startDate DATE, endDate DATE)
            begin
                insert into skladniki_zamowien 
                    (idTowaru, idZamowienia) values (idTowaru, idZamowienia);
                update towar set odKiedy = startDate, doKiedy = endDate;
                update towar set koszyk = 0 where id = idTowaru;
            end
        delimiter;
    </code>
</pre>
            <h3>Widok koszyka wypożyczalni</h3>
            <img class="img_in_article" src="../img/bazy_danych.png" alt="Projekt1 ScreenShot">
        </article>




        <article class="article-with-bar">
            <h2>Technologie programowania</h2>
            <h3>Chińskie warcaby</h3>
            Tak samo, jak wcześniej, Wojtek był ze mną w ekipie. Znowu maven, scenebuilder, wzorce projektowe.
            Do komunikacji między oddzielnymi oknami gry dla każdego gracz wykorzystaliśmy sockety i przez nie
            wysyłaliśmy
            informacje na jakie pole gracz się ruszył, rola serwer było sprawdzenie poprawności ruchów i wysłanie
            informacji zwrotnej;
            Zrobiliśmy też do tego diagram UML.


            <h3>In Game.java - how game ends:</h3>
            <pre>
<code class="code_for_projects">
    public void run() {
        boolean gameFinished = false;
        String msgToClient;
        PlayerPattern activePlayer;
        int wonPlayersNum = 0;
        int activePlayerNum = 0;
        msgToClient = "GAMESTART("+numberOfPlayers+")";
        sendToEveryPlayer(msgToClient);

        while(!gameFinished) {
            activePlayerNum = activePlayerNum % numberOfPlayers;
            activePlayer = mapOfPlayers.get(activePlayerNum);
            if (!activePlayer.hasWon() ) {
                playRound(activePlayer);
            }
            for (int i=0; i &lt; numberOfPlayers; i++) {
                PlayerPattern p = mapOfPlayers.get(i);
                if (board.hasPlayerWon(p.getColour())) {
                    wonPlayersNum++;
                }
            }
            if (wonPlayersNum == numberOfPlayers-1) {
                gameFinished = true;
            }
            activePlayerNum++;
        }
        System.out.println("Game has finished!");
        msgToClient = "GAMEFINISHED()";
        sendToEveryPlayer(msgToClient);
    }
    </code>
</pre>
            <h3>Okno powitalne gry</h3>
            <img class="img_in_article" src="../img/tp.png" alt="Projekt2 ScreenShot">
        </article>

        <article class="article-with-bar">
            <h2>AKISO</h2>
            <h3>MiniTalk</h3>
            Oj... AKISO i pisanie w czystym C. Wspaniały to był przedmiot, nie zapomnę go nigdy.
            A czego sobie życzę w tym sem? Tego co w poprzednim.
            Apka. Wykorzystanie selecta który wybiera na którym filedeskryptorze(i konkretnym sokecie) mamy dane do
            odebrania albo nadania.
            Można pisać wiadomości, pisząc nazwę użytkowniaka do którego chcemy wysłać.

            <h3>Fragment kodu z selectem</h3>
            <pre>
    <code class="code_for_projects">
    if(select(max_socket_yet+1, &cli_fds, NULL, NULL, NULL) &lt; 0) { 

        perror("select error"); 
        exit(EXIT_FAILURE); 
    }
    
    for(int i=0; i &lt;= max_socket_yet; i++) {  
    if(FD_ISSET(i, &cli_fds)) { 
        if(i == server_socket){ 
            //new connection 
            int client = handle_new_connections 
                (&server_socket, &clients, &main_fd); 
                FD_SET(client, &main_fd); 
                if(client > max_socket_yet)  
                    max_socket_yet = client;        
            }  
    } 
    </code>
</pre>

            <h3>Widok z terminala</h3>
            <img class="img_in_article" src="../img/akiso.png" alt="Projekt3 ScreenShot">
        </article>

    </div>

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
          
          $article_name = "science";
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
            <input hidden=true name="article" value="science">
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