<?php
    
    session_start();
    
    include "function.php";
    
    if(isset($_POST['fusion']) && isset($_SESSION['categoria'])){
        
        $fusion = $_POST['fusion'];
        
        $p = strpos($fusion, " ");
        
        $nome = substr($fusion, 0 , $p);
        $cognome = substr($fusion, $p+1, strlen($fusion)-strlen($nome));
        
        $query = "SELECT * FROM genitori WHERE nome='$nome' AND cognome='$cognome';";
        $dati_genitori = openConnection($query);
        
        $val = extractData($dati_genitori);
        $_SESSION['id_genitore'] = $val[0][0];  //Id del genitore
        $data_nascita = $val[0][3];             //Data di nascita
        $comune = $val[0][4];                   //Comune di nascita
        $sesso = $val[0][5];                    //Genere
        $anno = substr($data_nascita, 0, 4);
        $mese = substr($data_nascita, 5, 2);
        $giorno = substr($data_nascita, 8, 2);
        
        $cf = implode(calcolaCodiceFiscale($cognome, $nome, $anno, $mese, $sesso, $giorno, $comune));
        
        $query = "SELECT * FROM genitori;";
        $dati_genitori = openConnection($query);
        $val = extractData($dati_genitori);
        
        $_SESSION['nome_genitore'] = $nome;
        $_SESSION['cognome_genitore'] = $cognome;
        $_SESSION['codice_fiscale'] = $cf;
        
        echo "RICEVUTO DA $nome $cognome";//<p style=\"font-size:18px;\">$nome $cognome</p>
        //echo "RICEVUTO DA <select id='scelta' onchange='loadDoc()'>";
        /*
        for($i=0;$i<count($val);$i++){
            for($j=0;$j<count($val[$i]);$j++){
                if($j==1){
                    if($val[$i][$j] == $nome && $val[$i][$j+1] == $cognome){
                        echo "<option value='".$val[$i][$j]." ".$val[$i][$j+1]."' selected>".$val[$i][$j]." ".$val[$i][$j+1]."</option>";
                    }
                    else{
                        echo "<option value='".$val[$i][$j]." ".$val[$i][$j+1]."'>".$val[$i][$j]." ".$val[$i][$j+1]."</option>";
                    }
                    $j++;
                }
            }
        }
        
        echo "</select></br></br>";
        */
        echo "</br></br>C.F. $cf";
        
    }
    

?>