<?php

    session_start();
    include "function.php";
    
    if(isset($_SESSION['categoria']) && $_SESSION['categoria'] != "---" && strlen($_SESSION['categoria']) > 0){
        
        $categoria = $_SESSION['categoria'];
        
        if(isset($_SESSION['nome_genitore']) && isset($_SESSION['cognome_genitore']) &&
            isset($_SESSION['prezzo_ricevuta']) && isset($_SESSION['nome_allievo']) &&
            isset($_SESSION['cognome_allievo']) && isset($_SESSION['numero_ricevuta']) && 
            isset($_SESSION['data_odierna']) && isset($_SESSION['prezzo_car']) &&
            isset($_SESSION['anno_attuale']) && isset($_SESSION['anno_successivo'])){
                
            $nome_genitore = $_SESSION['nome_genitore'];
            $cognome_genitore = $_SESSION['cognome_genitore'];
            $prezzo = $_SESSION['prezzo_ricevuta'];
            $nome_allievo = $_SESSION['nome_allievo'];
            $cognome_allievo = $_SESSION['cognome_allievo'];
            $numero = $_SESSION['numero_ricevuta'];
            $data_odierna = $_SESSION['data_odierna'];
            $prezzo_car = $_SESSION['prezzo_car'];
            $anno_attuale = $_SESSION['anno_attuale'];
            $anno_successivo = $_SESSION['anno_successivo'];
        
            $str = "<table>
    				<tr>
            			<td>
            				<img src=\"logo_ricevuta.jpeg\" alt=\"Danzarmonia ASD\" width=\"250\" height=\"120\">
                			<p>
                				DANZARMONIA A.S.D.</br>
                				Via Moia 11</br>
                				25075 Nave
                			</p>
                		</td>
                		<td>";
            
            $str .= "<table class='prima'>";
            $str .= "<tr>";
            $str .= "<td>";
            $str .= "<p class='prima_p'>RICEVUTA N&#176; $numero DEL  $data_odierna</p>";
            $str .= "</td>";
            $str .= "</tr>";
            
            $str .= "<tr>";
            $str .= "<td>";
            $str .= "<p class='prima_p' id='codice'>RICEVUTO DA $nome_genitore $cognome_genitore";
            $str .= "</p>";
            $str .= "</td>";
            $str .= "</tr>";
            
            $str .= "<tr>";
            $str .= "<td>";
            $str .= "<p id='prezzo_p' class='prima_p_prezzo'>&#8364; $prezzo</p>";
            $str .= "</td>";
            $str .= "</tr>";
            
            $str .= "</table>";
            $str .= "</td>
                        </tr>
                        <tr>";
            
            $str .= "<td colspan='3'>";
            $str .= "<table>";
            $str .= "<tr>";
            $str .= "<td style=\"width:100%;\">"; 
            $str .= "<p id='prezzo_c' style='width: 1030px;border: 1px solid black;padding:15px;font-size: 20px;'>
                        $prezzo_car
                     </p></td></tr>";
            $str .= "<tr><td style=\"width:100%;\" colspan=2>
                                    <p class=\"descrizione\" id=\"alunno\">
                                        Per $nome_allievo $cognome_allievo</br>";
            
            switch($categoria){
                
                case "iscrizioni":
                    $str .= "Quota iscrizione</br>
                             Assicurazione</br>
                             Tessera CSEN [$anno_attuale/$anno_successivo]
                            </p>
                          </td>";
                    break;
                    
                case "rette":
                    
                    $str .= "Retta di ";
                    $str .= "<textarea name='descrizione' id='descrizione' placeholder='Descrizione attivit&agrave;'></textarea>
                              </p>
                              </td>";
                    break;
                    
                case "quote":
                    $str .= "Quota saggio [$anno_attuale]
                                </p>
                              </td>";
                    break;
                    
            }
            
            $str .= "</tr>";
            $str .= "</table>";
            $str .= "</td>";
            $str .= "</tr>";
            $str .= "</table>";
            $str .= "<button onclick='window.print();'>Stampa</button>";
        
        }
        
    }

?>