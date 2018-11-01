<?php

    session_start();
    
    include "function.php";
    
    if(isset($_POST['price']) && strlen($_POST['price']) > 0){
        $prezzo = $_POST['price'];
        $_SESSION['prezzo_ricevuta'] = $prezzo;
        echo "&#8364; ".$prezzo;
        echo "<input type='hidden' name='prezzosalvato' value='$prezzo'>";
        
    }
    
    if(isset($_POST['price_c']) && strlen($_POST['price_c']) > 0){
        
        $risultato = strtoupper($_POST['price_c']);
        $_SESSION['prezzo_car'] = $risultato;
        echo "&#8364; ".$risultato;
        
    }
    
?>