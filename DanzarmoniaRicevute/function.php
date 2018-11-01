<?php
    
    function openConnection($query){
        
        $link = new mysqli('localhost', 'root', '', 'my_danzarmonia');
        if ($link -> connect_errno) {
            die ('Non riesco a connettermi: ' . connect_error);
        }
        if(!$risultato_query = $link->query($query)){
            echo "Errore nella query: ".$link->error.".";
        }
        else{
            return $risultato_query;
        }
        
    }
    
    function extractData($res){
        
        $array = array(array());
        $i = 0;
        
        if($res -> num_rows > 0){
            
            
            while($arr = $res -> fetch_array(MYSQLI_NUM)){
                
                for($j=0;$j<count($arr);$j++)
                    $array[$i][$j] = $arr[$j];
                
                $i++;
                
            }
            
            return $array;
            
        }
        
    }

    //Controlla se una lettera sia una vocale o consonante
    function controllaLettera($c){
            		    
	    $c = strtolower($c);
	    
	    if($c != 'a' && $c != 'e' && $c != 'i' && $c != 'o' && $c != 'u'){
	        return true;
	    }
	    else{
	        return false;
	    }
	    
	}
            
	//Conta le occorrenze di vocali e consonanti in una
	//stringa e restituisce due array contenenti le vocali
	//e le consonanti trovate
	function contaVocaliConsonanti($stringa){
	    
	    $vocali = array();
	    $consonanti = array();
	    
	    $cons = 0;
	    $voc = 0;
	    
	    for($i=0;$i<strlen($stringa);$i++){
	        
	        $c = strtoupper(substr($stringa, $i, 1));
	        
	        if(controllaLettera($c)){
	            
	            $consonanti[$cons] = $c;
	            $cons++;
	            
	        }
	        else{
	            
	            $vocali[$voc] = $c;
	            $voc++;
	            
	        }
	        
	    }
	    
	    return array($vocali, $voc, $consonanti, $cons);
	    
	}
    
	//Calcola le prime tre lettere del codice fiscale data la stringa
	function calcolaTreLettere($stringa, $controllo){
	    
	    $arr = array();
	    
	    $conteggio = contaVocaliConsonanti($stringa);
	    
	    $vocali = $conteggio[0];
	    $voc = $conteggio[1];
	    $consonanti = $conteggio[2];
	    $cons = $conteggio[3];
	    
	    
	    for($i=0;$i<strlen($stringa);$i++){
	        
	        $c = strtoupper(substr($stringa, $i, 1));
	        
	        if($cons >= 3){
	            
	            if($controllo && $cons >= 4){
	                
	                for($j=0;$j<4;$j++){
	                    
	                    //Prendo la terza e la quarta consonante
	                    if($j == 1 || $j == 2){
	                        
                            $arr[$j] = $consonanti[$j+1];
                            if($j == 2) break;
	                        
	                    }
	                    else{
	                        
                            $arr[$j] = $consonanti[$j];
	                       
	                    }
	                    
	                }
	                
	            }
	            else{
	                
    	            for($j=0;$j<3;$j++)
    	               $arr[$j] = $consonanti[$j];
    	            
    	            break;
    	            
	            }
	                
	        }
	        else{
	            
	            $k = 0;
	            
	            for($j=0;$j<$cons;$j++)
	                $arr[$j] = $consonanti[$j];
	                
	                
                if(count($arr) < 3){
                    
                    for($k=0;$k<$voc;$k++){
                        
                        $arr[$j] = $vocali[$k];
                        $j++;
                        
                        if(count($arr) == 3)
                            break;
                            
                    }
                    
                    if(count($arr) < 3){
                        
                        while(count($arr) < 3){
                            
                            $arr[$j] = 'X';
                            
                        }
                        
                    }
                    
                }
	                
	        }
	        
	        if(count($arr) == 3)
	            break;
	            
	    }
	    
	    return $arr;
	    
	}
	
	function estraiUltimiDueNumeri($numero){
	    
	    $primo = substr($numero, 2, 1);
	    $secondo = substr($numero, 3, 1);
	    return array($primo, $secondo);
	    
	}
	
	function associaMeseLettera($mese){
	    
	    switch($mese){
	        
	        case 1:$lettera = 'A';break;
	        case 2:$lettera = 'B';break;
	        case 3:$lettera = 'C';break;
	        case 4:$lettera = 'D';break;
	        case 5:$lettera = 'E';break;
	        case 6:$lettera = 'H';break;
	        case 7:$lettera = 'L';break;
	        case 8:$lettera = 'M';break;
	        case 9:$lettera = 'P';break;
	        case 10:$lettera = 'R';break;
	        case 11:$lettera = 'S';break;
	        case 12:$lettera = 'T';break;
	        default:break;
	        
	    }
	    
	    return array($lettera);
	    
	}
	
	function calcolaGiorno($sesso, $giorno){
	    
	    $sesso = strtolower($sesso);
	    
	    if($sesso == "maschio"){
	        
	        if($giorno >= 1 && $giorno <= 9){
	            
	            $risultato = "0".$giorno;
	            
	        }
	        else if($giorno > 9){
	            
	            $risultato = $giorno;
	            
	        }
	        
	    }
	    else if($sesso == "femmina"){
	        
	        $risultato = $giorno + 40;
	        
	    }
	    
	    return array(substr($risultato, 0, 1), substr($risultato, 1, 1));
	    
	}
	
	function estraiCodiceComune($comune){
	    
	    $filename = "comuni.txt";
	    $comune = strtoupper($comune);
	    $lunghezza = strlen($comune);
	    
	    $file = fopen($filename, "r");
	    $leggi = fread($file, filesize($filename));
	    
	    $array_contents = explode("\n", $leggi);
	    
	    for($i=0;$i<count($array_contents);$i++){
	        
	        $stringa = $array_contents[$i];
	        
	        if(substr($stringa, 0, $lunghezza) == $comune){
	            
	            $codice = substr($stringa, $lunghezza + 1, $lunghezza);
	            break;
	            
	        }
	        
	    }
	    
	    fclose($file);
	    return array(substr($codice,0,1),substr($codice,1,1),substr($codice,2,1),substr($codice,3,1));
	    
	}
	
	function calcolaLetteraControllo($codice_parziale){
	    
	    $somma_valori = 0;
	    
	    for($i=0;$i<count($codice_parziale);$i++){
	        
	        if(($i+1) % 2 == 0){
	            
	            switch($codice_parziale[$i]){
	                
	                case "A":$somma_valori += 0;break;
	                case "B":$somma_valori += 1;break;
	                case "C":$somma_valori += 2;break;
	                case "D":$somma_valori += 3;break;
	                case "E":$somma_valori += 4;break;
	                case "F":$somma_valori += 5;break;
	                case "G":$somma_valori += 6;break;
	                case "H":$somma_valori += 7;break;
	                case "I":$somma_valori += 8;break;
	                case "J":$somma_valori += 9;break;
	                case "K":$somma_valori += 10;break;
	                case "L":$somma_valori += 11;break;
	                case "M":$somma_valori += 12;break;
	                case "N":$somma_valori += 13;break;
	                case "O":$somma_valori += 14;break;
	                case "P":$somma_valori += 15;break;
	                case "Q":$somma_valori += 16;break;
	                case "R":$somma_valori += 17;break;
	                case "S":$somma_valori += 18;break;
	                case "T":$somma_valori += 19;break;
	                case "U":$somma_valori += 20;break;
	                case "V":$somma_valori += 21;break;
	                case "W":$somma_valori += 22;break;
	                case "X":$somma_valori += 23;break;
	                case "Y":$somma_valori += 24;break;
	                case "Z":$somma_valori += 25;break;
	                
	                case 0:$somma_valori += 0;break;
	                case 1:$somma_valori += 1;break;
	                case 2:$somma_valori += 2;break;
	                case 3:$somma_valori += 3;break;
	                case 4:$somma_valori += 4;break;
	                case 5:$somma_valori += 5;break;
	                case 6:$somma_valori += 6;break;
	                case 7:$somma_valori += 7;break;
	                case 8:$somma_valori += 8;break;
	                case 9:$somma_valori += 9;break;
	                
	                
	            }
	            
	        }
	        else{
	            
	            switch($codice_parziale[$i]){
	                
	                case "A":$somma_valori += 1;break;
	                case "B":$somma_valori += 0;break;
	                case "C":$somma_valori += 5;break;
	                case "D":$somma_valori += 7;break;
	                case "E":$somma_valori += 9;break;
	                case "F":$somma_valori += 13;break;
	                case "G":$somma_valori += 15;break;
	                case "H":$somma_valori += 17;break;
	                case "I":$somma_valori += 19;break;
	                case "J":$somma_valori += 21;break;
	                case "K":$somma_valori += 2;break;
	                case "L":$somma_valori += 4;break;
	                case "M":$somma_valori += 18;break;
	                case "N":$somma_valori += 20;break;
	                case "O":$somma_valori += 11;break;
	                case "P":$somma_valori += 3;break;
	                case "Q":$somma_valori += 6;break;
	                case "R":$somma_valori += 8;break;
	                case "S":$somma_valori += 12;break;
	                case "T":$somma_valori += 14;break;
	                case "U":$somma_valori += 16;break;
	                case "V":$somma_valori += 10;break;
	                case "W":$somma_valori += 22;break;
	                case "X":$somma_valori += 25;break;
	                case "Y":$somma_valori += 24;break;
	                case "Z":$somma_valori += 23;break;
	                
	                case 0:$somma_valori += 1;break;
	                case 1:$somma_valori += 0;break;
	                case 2:$somma_valori += 5;break;
	                case 3:$somma_valori += 7;break;
	                case 4:$somma_valori += 9;break;
	                case 5:$somma_valori += 13;break;
	                case 6:$somma_valori += 15;break;
	                case 7:$somma_valori += 17;break;
	                case 8:$somma_valori += 19;break;
	                case 9:$somma_valori += 21;break;
	                
	            }
	            
	        }
	        
	    }
	    
	    $resto = $somma_valori % 26;
	    
	    switch($resto){
	        
	        case 0:$lettera = "A";break;
	        case 1:$lettera = "B";break;
	        case 2:$lettera = "C";break;
	        case 3:$lettera = "D";break;
	        case 4:$lettera = "E";break;
	        case 5:$lettera = "F";break;
	        case 6:$lettera = "G";break;
	        case 7:$lettera = "H";break;
	        case 8:$lettera = "I";break;
	        case 9:$lettera = "J";break;
	        case 10:$lettera = "K";break;
	        case 11:$lettera = "L";break;
	        case 12:$lettera = "M";break;
	        case 13:$lettera = "N";break;
	        case 14:$lettera = "O";break;
	        case 15:$lettera = "P";break;
	        case 16:$lettera = "Q";break;
	        case 17:$lettera = "R";break;
	        case 18:$lettera = "S";break;
	        case 19:$lettera = "T";break;
	        case 20:$lettera = "U";break;
	        case 21:$lettera = "V";break;
	        case 22:$lettera = "W";break;
	        case 23:$lettera = "X";break;
	        case 24:$lettera = "Y";break;
	        case 25:$lettera = "Z";break;
	        
	    }
	    
	    return array($lettera);
	    
	}
	
	function calcolaCodiceFiscale($cognome, $nome, $anno, $mese, $sesso, $giorno, $comune){
	    
	    $codice_fiscale = array();
	    
	    $cogn = calcolaTreLettere($cognome, false);
	    $nom = calcolaTreLettere($nome, true);
	    $ann = estraiUltimiDueNumeri($anno);
	    $mes = associaMeseLettera($mese);
	    $giorn = calcolaGiorno($sesso, $giorno);
	    $codice = estraiCodiceComune($comune);
	    $codice_parziale = array_merge($cogn, $nom, $ann, $mes, $giorn, $codice);
	    $lettera = calcolaLetteraControllo($codice_parziale);
	    
	    $codice_fiscale = array_merge($codice_parziale, $lettera);
	    
	    return $codice_fiscale;
	    
	}
	
	function trovaMeseInLettere($numero){
	    
	    $mesi = array();
	    
	    for($i=1;$i<13;$i++){
	        
	        switch($i){
	            
	            case 1: $mesi[$i] = "Gennaio";break;
	            case 2: $mesi[$i] = "Febbraio";break;
	            case 3: $mesi[$i] = "Marzo";break;
	            case 4: $mesi[$i] = "Aprile";break;
	            case 5: $mesi[$i] = "Maggio";break;
	            case 6: $mesi[$i] = "Giugno";break;
	            case 7: $mesi[$i] = "Luglio";break;
	            case 8: $mesi[$i] = "Agosto";break;
	            case 9: $mesi[$i] = "Settembre";break;
	            case 10: $mesi[$i] = "Ottobre";break;
	            case 11: $mesi[$i] = "Novembre";break;
	            case 12: $mesi[$i] = "Dicembre";break;
	            default: break;
	            
	        }
	        
	    }
	    
	    return $mesi[$numero];
	    
	}
	
?>