<?php
    
    session_start();
    
    include "function.php";

    if(isset($_POST['fusion']) && strlen($_POST['fusion']) > 0 && 
       isset($_POST['month']) && strlen($_POST['month']) > 0 &&
       isset($_POST['descrizione']) && strlen($_POST['descrizione']) > 0){
        
        $fusion = $_POST['fusion'];
        $mese = $_POST['month'];
        $descrizione = $_POST['descrizione'];
        
        $p = strpos($fusion, " ");
        
        $nome = substr($fusion, 0 , $p);
        $cognome = substr($fusion, $p+1, strlen($fusion)-strlen($nome));
        
        $_SESSION['nome_allievo'] = $nome;
        $_SESSION['cognome_allievo'] = $cognome;
        $_SESSION['descrizione'] = $descrizione;
        
        echo "$nome $cognome </br> Retta di $mese </br>";
        echo "<div style='width:250px;'>$descrizione</div>";
        
    }