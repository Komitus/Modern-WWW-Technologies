<footer>

<?php

    $handle = fopen("counter.txt", "r");
    if($handle){
        $counter = (int ) fread($handle,20);
        fclose ($handle);
        if (!isset($_COOKIE["visited"])) { 
            setcookie("visited", "visited", mktime(24,0,0));
            $counter++;
            $handle = fopen("counter.txt", "w+");
            fputs($handle,$counter);
            fclose ($handle);
        }
    } 
    
?>
   <p style="font-size: 110%; line-height: 40%"> Jesteś <strong> <?= $counter ?></strong> odwiedzającym </p>
   <p><i>Celem tej strony jest zdobycie punktów na zaliczenie kursu</i></p>
</footer>

   
