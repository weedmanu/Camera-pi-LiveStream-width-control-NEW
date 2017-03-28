<?php    
 // Si on click sur un logo du panneau de commande (flêches et bouton home)
  if(!empty($_POST))  {
	// on met la valeur reçu du bouton dans une variable ( 1 à 5)
    $data = $_POST['com'];
	//	 adresse ip du serveur (sevocam.py)
	$host = "127.0.0.1";
	 //	 port du serveur (sevocam.py)
	$port = 9999;
	// création du socket
	$socket = socket_create(AF_INET, SOCK_STREAM,0) or die("Could not create socket\n");
	// ouverture de la connection
	socket_connect ($socket , $host,$port ) ;
	// envoi la variable data par le socket au serveur (servocam.py)
	socket_write($socket, $data, strlen ($data)) or die("Could not write data\n");
	// on ferme ce socket
	socket_close($socket) ;	
	}
echo '
<br/>
<h3>Panneau de commande</h3>
<br/>
<table id="table">    
   <tr>
       <td></td>
       <td></td>
       <td>		
		    <p><form class="form" method="post" action="servo.php"> 		
			<input type="hidden" name="com" value="4"><br>
			<input type="image" src="img/fleche-haut.png" alt="Submit" >
			</form></p>
		</td>
       <td></td>
       <td></td>
   </tr>
   <tr>
       <td>
		    <p><form class="form" method="post" action="servo.php"> 		
			<input type="hidden" name="com" value="1"><br>
			<input type="image" src="img/fleche-gauche.png" alt="Submit" >
			</form></p>
		</td>
		<td></td>
       <td>
		   	<p><form class="form" method="post" action="servo.php"> 		
			<input type="hidden" name="com" value="5"><br>
			<input type="image" src="img/home.png" alt="Submit" >
			</form></p>
		</td>
		<td></td>
       <td>
			<p><form class="form" method="post" action="servo.php"> 		
			<input type="hidden" name="com" value="2"><br>
			<input type="image" src="img/fleche-droite.png" alt="Submit" >
			</form></p>
       </td>       
   </tr>
      <tr>
       <td></td>
       <td></td>
       <td>
			<p><form class="form" method="post" action="servo.php"> 		
			<input type="hidden" name="com" value="3"><br>
			<input type="image" src="img/fleche-bas.png" alt="Submit" >
			</form></p>
       </td>
       <td></td>
       <td></td>
   </tr> 
</table>
';
?>
