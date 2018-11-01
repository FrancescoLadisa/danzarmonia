<html>
	<head>
		<title>Danzarmonia A.S.D. | Ricevute</title>
		<link rel="stylesheet" type="text/css" href="stile.css"/>
		<script type='text/javascript'>
    		function nascondiSelezione(){
    			document.getElementById("nascosto").style.display="none";
    		}
        </script>
		
	</head>
	<body>
	<center>
		<form action="index.php" method="POST">
			<a href="index.php">Indietro</a>
			<table>
				<tr>
        			<td>
        				<img src="logo_ricevuta.jpeg" alt="Danzarmonia ASD" width="250" height="120">
            			<p>
            				DANZARMONIA A.S.D.</br>
            				Via Moia 11</br>
            				25075 Nave
            			</p>
            		</td>
            		<td>
            			<div id="nascosto">
                			<p>Selezionare una categoria per la ricevuta: </p>
                			<select class="categorie" name="categoria" onChange="submit()">
                				<option selected>---</option>
                				<option value="iscrizioni">Iscrizioni</option>
                				<option value="rette">Rette</option>
                				<option value="quote">Quote</option>
                			</select>
            			</div>
            		</td>
                    <td>
                    
		<?php
		
    		  session_start();
		      include "function.php";
    	      
    	      if((isset($_POST['categoria']) && $_POST['categoria'] != "---") || 
    	         (isset($_GET['cambia']) && $_GET['cambia'] == 1) ||
    	          isset($_POST['salva'])){
    		       
	              if(isset($_POST['categoria']) && !isset($_POST['salva'])){
	                  
    	              $categoria = $_POST['categoria'];
    	              $_SESSION['categoria'] = $categoria;
    	              
    	          }
    	          
    	          else if(isset($_SESSION['categoria'])){
    	              $categoria = $_SESSION['categoria'];
    	          }
    	          
    		       $data_odierna = date("d-m-Y", time());
    		       $data_inglese = date("Y-m-d", time());
    		       $anno_attuale = date("Y", time());
    		       
    		       if(strtotime($data_odierna) >= strtotime("01-01-$anno_attuale") && strtotime($data_odierna) < strtotime("31-08-$anno_attuale"))
    		           $anno_attuale -= 1;
    		       
    		       $anno_successivo = $anno_attuale + 1;
    		       $mese_attuale = date("m", time());
    		       
    		       $mese_lettere = trovaMeseInLettere((int)$mese_attuale);
    		       
    		       $query = "SELECT MAX(numero) 
                             FROM ricevute 
                             WHERE data BETWEEN '$anno_attuale-08-31' AND '$data_inglese'
                             AND categoria='$categoria';";
    		       $dati_ricevute = openConnection($query);
    		       echo $query;
    		       $val = extractData($dati_ricevute);
    		       $numero_ricevuta = $val[0][0] + 1;
    		       
    		       if($numero_ricevuta == 0){
    		           $numero_ricevuta = 1;
    		       }
    		       
    		       $_SESSION['numero_ricevuta'] = $numero_ricevuta;
    		       $_SESSION['data_odierna'] = $data_odierna;
    		       $_SESSION['anno_attuale'] = $anno_attuale;
    		       $_SESSION['anno_successivo'] = $anno_successivo;
    		       
    		       //echo $numero_ricevuta;
                   $query = "SELECT * FROM genitori;";
                   $dati_genitori = openConnection($query);
                   
                   $val = extractData($dati_genitori);
                   
    		       echo "<script type='text/javascript'>
                            javascript:nascondiSelezione();
                         </script>";
    		       
    		       $str = "<table class='prima'>";
    		       $str .= "<tr>";
    		       $str .= "<td>";
    		       $str .= "<p class='prima_p'>RICEVUTA N&#176; $numero_ricevuta DEL  $data_odierna</p>";
    		       $str .= "</td>";
    		       $str .= "</tr>";
    		       
    		       $str .= "<tr>";
    		       $str .= "<td>";
    		       $str .= "<p class='prima_p' id='codice'>RICEVUTO DA <select id='scelta' onchange='loadCode()'>";
    		       
    		       for($i=0;$i<count($val);$i++){
    		           
    		           if($i==0){
    		               $str .= "<option>---</option>";
    		           }
    		           
    		           for($j=0;$j<count($val[$i]);$j++){
    		               
    		               if($j==1){
    		                   
    		                   $str .= "<option value='".$val[$i][$j]." ".$val[$i][$j+1]."'>".$val[$i][$j]." ".$val[$i][$j+1]."</option>";
    		                   $j++;
    		                   
    		               }
    		               
    		           }
    		           
    		       }
    		       
    		       $str .= "</select>";
    		       $str .= "</p>";
    		       $str .= "</td>";
    		       $str .= "</tr>";
    		       
    		       $str .= "<tr>";
    		       $str .= "<td>";
    		       $str .= "<p id='prezzo_p' class='prima_p_prezzo'>&#8364; <input type='number' name='prezzo' id='prezzo' required></p>";
    		       $str .= "</td>";
    		       $str .= "</tr>";
    		       
    		       $str .= "</table>";
    		       $str .= "</td>
                            </tr>
                            <tr>";
    		       
    		       
    		       
    		       if(isset($_SESSION['id_genitore']) && strlen($_SESSION['id_genitore']) > 0)
        		       $query = "SELECT * FROM allievi AS a, genitori AS g 
                                 WHERE a.id_genitore=g.id_genitore AND g.id_genitore=".$_SESSION['id_genitore'];
    		       else
    		           $query = "SELECT * FROM allievi";
    		       
    		       $dati_allievi = openConnection($query);
    		       
    		       $val = extractData($dati_allievi);
    		       
    		         $str .= "<td colspan='3'>";
       		         $str .= "<table>";
       		         $str .= "<tr>";
       		         $str .= "<td style=\"width:100%;\">";
       		         $str .= "<p id='prezzo_c' style='width: 1030px;border: 1px solid black;padding:15px;font-size: 20px;'>
                                <input type='text' id='prezzo_car' style='padding: 15px;width:400px;height:40px;' placeholder='Inserire valore del prezzo in caratteri' required>
                                <a href='#' style='font-size:12px;' onclick='loadPrice();'>Salva</a>
                              </p></td></tr>";
       		         $str .= "<tr><td style=\"width:100%;\" colspan=2>
                                <p class=\"descrizione\" id=\"alunno\">
                                    Per <select id='allievo'>";
       		         
       		         for($i=0;$i<count($val);$i++){
       		             
       		             if($i==0){
       		                 $str .= "<option>---</option>";
       		             }
       		             
       		             for($j=0;$j<count($val[$i]);$j++){
       		                 
       		                 if($j==1){
       		                     
       		                     $str .= "<option value='".$val[$i][$j]." ".$val[$i][$j+1]."'>".$val[$i][$j]." ".$val[$i][$j+1]."</option>";
       		                     $j++;
       		                     
       		                 }
       		                 
       		             }
       		             
       		         }
       		         
       		         $str .= "</select></br>";
       		         
       		         switch($categoria){
       		             
       		             case "iscrizioni": 
       		                 $str .= "Quota iscrizione</br>
                                      Assicurazione</br>
                                      Tessera CSEN [$anno_attuale/$anno_successivo]
                                    </p>
                                  </td>";
       		                 break;
       		                 
       		             case "rette": 
       		                 
       		                 $str .= "Retta di <select id='mese'>";
       		                 
       		                 for($i=1;$i<13;$i++){
       		                     
       		                     $mese = trovaMeseInLettere($i);
       		                     
       		                     if($mese == $mese_lettere)
       		                         $str .= "<option value='$mese' selected>$mese</option>";
       		                     else 
       		                         $str .= "<option value='$mese'>$mese</option>";
       		                     
       		                 }
       		                 
       		                 $str .= "</select> <a href='#' style='font-size:12px;' onclick='loadNameAndMonth();'>Salva</a></br>";
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
    		   		
    		   		 if(isset($_POST['salva']) && isset($_POST['prezzosalvato']) && isset($_SESSION['id_genitore']) && 
    		   		    isset($_SESSION['numero_ricevuta'])){
    		   		     
    		   		     $prezzo = $_POST['prezzosalvato'];
    		   		     $id_genitore = $_SESSION['id_genitore'];
    		   		     $categoria = $_SESSION['categoria'];
    		   		     $numero_ricevuta = $_SESSION['numero_ricevuta'];
    		   		     
    		   		     $query = "INSERT INTO `ricevute`(id_ricevuta,id_genitore,numero,data,categoria,prezzo) 
                                   VALUES(0,$id_genitore,$numero_ricevuta,'$data_inglese','$categoria',$prezzo)";
    		   		     //echo $query;
    		   		     $inserimento = openConnection($query);
    		   		     
    		   		     if($inserimento){
    		   		         $riuscito = "Salvataggio avvenuto con successo";
    		   		         echo "<script type='text/javascript'>javascript:confirm('$riuscito');</script>";
    		   		         header("Refresh: 2; url=stampa.php");
    		   		     }
    		   		     else if(!$inserimento){
    		   		         $nonriuscito = "Errore nel salvataggio della ricevuta, riprova";
    		   		         echo "<script type='text/javascript'>javascript:confirm('$nonriuscito');</script>";
    		   		     }
    		   		     
    		   		 }
    		   		 else{
    		   		     echo $str;
    		   		 }
    		   		 
    		   		 echo "<input type='submit' name='salva' value='Salva'> ";
    		   		 echo " <a href=\"index.php?cambia=1\" style=\"font-size: 12px;\">Cancella</a>";
    		   		 echo "</form>";
    		   		 
       		     }
    		   		
    ?>
		</center>
		<script>
		
            function loadCode() {
                
              var xhttp = new XMLHttpRequest();
              var fusion = document.getElementById("scelta").value;
              
              xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("codice").innerHTML =
                  this.responseText;
                }
              };
              
              xhttp.open("POST", "codicefiscale.php", true);
              xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
              xhttp.send("fusion="+fusion);
              
            }
            function loadNameAndMonth() {
                
                var xhttp = new XMLHttpRequest(), xhttp2 = new XMLHttpRequest();
                var fusion = document.getElementById("allievo").value;
                var month = document.getElementById("mese").value;
                var descrizione = document.getElementById("descrizione").value;

				if(fusion.length > 0 && month.length > 0 && descrizione.length > 0){
                
                    xhttp.onreadystatechange = function() {
                      if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("alunno").innerHTML =
                        this.responseText;
                      }
                    };
                    
                    xhttp.open("POST", "nome.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send("fusion="+fusion+"&month="+month+"&descrizione="+descrizione);
                    
				}
                
            }
            function loadPrice(){

            	var xhttp = new XMLHttpRequest(), xhttp2 = new XMLHttpRequest();
                var price = document.getElementById("prezzo").value;
                var price_char = document.getElementById("prezzo_car").value;

                if(price.length > 0 && price_char.length > 0){
                    
                    xhttp.onreadystatechange = function() {
                      if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("prezzo_p").innerHTML = this.responseText;
                      }
                    };
                    
                    xhttp.open("POST", "salvaprezzo.php", true);
                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp.send("price="+price);

                    
                    xhttp2.onreadystatechange = function() {
                      if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("prezzo_c").innerHTML = this.responseText;
                      }
                    };
                    
                    xhttp2.open("POST", "salvaprezzo.php", true);
                    xhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhttp2.send("price_c="+price_char);
                    
                }

            }
            
        </script>
	</body>
</html>