<html>
	<head>
		<title>Danzarmonia A.S.D. | Nuovo inserimento</title>
		<link rel="stylesheet" type="text/css" href="stile.css"/>
	</head>
	<body>
	<?php
	
    	session_start();
    	include "function.php";
	
        if(!isset($_POST['opzione'])){
    		echo "<div id=\"opzioni\">
            		<img src=\"logo_ricevuta.jpeg\" alt=\"Danzarmonia ASD\" width=\"250\" height=\"120\">
            		<p>
            			DANZARMONIA A.S.D.</br>
            			Via Moia 11</br>
            			25075 Nave
            		</p>
            		<div style=\"width:100%;height:400px;text-align: center;\" id=\"opzioni\">
                        <h3 style='line-height:200px;'>Area nuovo cliente</h3>
                        <p>Inserimento tramite:</p>
                        <button type=\"button\" onclick=\"loadOption(0)\" class='bottoni'>Codice fiscale</button>
                        <button type=\"button\" onclick=\"loadOption(1)\" class='bottoni'>Dati anagrafici</button>
                    </div>
        		</div>";
	    }
	   
    ?>
	</body>
	<script>
		function loadOption(id) {
            
            var xhttp = new XMLHttpRequest();
            
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                document.getElementById("opzioni").innerHTML =
                this.responseText;
              }
            };
            
            xhttp.open("POST", "genitori_allievi.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("opzione="+id);
            
        }
	</script>
</html>


<?php
    
    if(isset($_POST['opzione']) && strlen($_POST['opzione']) > 0){
        
        $opzione = $_POST['opzione'];
        echo "<table>";
        echo "<form action='genitori_allievi.php' method='POST'>";
        echo "<caption>Dati del genitore</caption>";
        echo "<tr>";
        echo "<td>";
        echo "<input type='text' name='nome_nuovo_genitore' placeholder='Nome' required>";
        echo "</td>";
        echo "<td>";
        echo "<input type='text' name='cognome_nuovo_genitore' placeholder='Cognome' required>";
        echo "</td>";
        echo "</tr>";
        
        switch($opzione){
            
            case 0: 
                echo "<tr><td><input type='text' name='cf_nuovo_genitore' placeholder='Codice fiscale' required></td></tr>";
                break;
            case 1: 
                echo "<tr><td><input type='date' name='data_nascita_gen'></td></tr>";
                echo "<tr><td><input type='text' name='comune_nascita_gen' placeholder='Comune di nascita'></td></tr>";
                break;
            
        }
        
        echo "<caption>Dati dell'allievo</caption>";
        echo "<tr><td><input type='text' name='nome_nuovo_allievo' placeholder='Nome' required></td></tr>";
        echo "<tr><td><input type='text' name='cognome_nuovo_allievo' placeholder='Cognome' required></td></tr>";
        echo "</form>";
        echo "</table>";
        
    }
    
?>