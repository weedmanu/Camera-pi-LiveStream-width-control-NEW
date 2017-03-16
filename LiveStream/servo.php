<?php    

 // Si le tableau $_POST existe alors le formulaire a été envoyé
  if(!empty($_POST))  {
	
    $data = $_POST['com'];
	
	$host = "127.0.0.1";
	$port = 9999;

	$socket = socket_create(AF_INET, SOCK_STREAM,0) or die("Could not create socket\n");

	socket_connect ($socket , $host,$port ) ;

	socket_write($socket, $data, strlen ($data)) or die("Could not write data\n");

	socket_close($socket) ;	

	}

?>

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
			<input type="hidden" name="com" value="2"><br>
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
			<input type="hidden" name="com" value="1"><br>
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
   
