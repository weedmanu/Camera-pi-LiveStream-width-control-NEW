<?php 
// ip du serveur  et port de mpg-streamer
$srv_addr = "http://${_SERVER['SERVER_ADDR']}:8080";

 // Si on reçoit quelque chose du formulaire (play stop))
 if(!empty($_POST))  {
	 //	 adresse ip du serveur (sevocam.py)
	 $host = "127.0.0.1";
	 //	 port du serveur (sevocam.py)
	 $port = 9999;
	 // création du socket
	 $socket = socket_create(AF_INET, SOCK_STREAM,0) or die("Impossible de créer le socket\n");
	 // ouverture de la connection
	 socket_connect ($socket, $host, $port ) ;
	// on place ce que l'on a reçu dans une variable
	 $form = $_POST['cam'];
	// si on reçoit play
	if ($form == 'play') {
		// la variable data vaut 6
		$data = 6;
		// envoi cette variable par le socket au serveur (servocam.py)
		socket_write($socket, $data, strlen ($data)) or die("Impossible d'écrie des datas, le programme servocam.py doit être fermé !!!!'\n");
		// attend 1/2 seconde avant d'afficher (pour être sur que tout soit lanncé)
		sleep(1);
		// déclaration des iframes à afficher (la camera, paneau de controle, prise de photos)
		$affiche = "<iframe class='cam' src='$srv_addr/cam.html' /></iframe>";				
		$affiche2 = "<iframe class='cam' src='servo.php'></iframe>";	
		$affiche3 = "<iframe class='cam' src='photo.php' ;></iframe>";
		}
	// si on reçoit stop
	if ($form == 'stop') {
		// la variable data vaut 7
		$data = 7;
		// envoi cette variable par le socket au serveur (servocam.py)
		socket_write($socket, $data, strlen ($data)) or die("Impossible d'écrie des datas, le programme servocam.py doit être fermé !!!!'\n");
		// on affiche plus rien (on enlève les iframes)
		$affiche = "";	
		$affiche2 = "";
	}

	// on ferme ce socket
	socket_close($socket) ;
}
?> 

<!DOCTYPE html>  <!-- html5 -->
<html lang="fr">  <!-- langage de la page -->
<head> 
	<meta charset="utf-8" />  <!--encodage -->
	<title>Live Streaming motorisé</title> <!-- titre -->
	<link rel="icon" type="image/png" href="img/cam.png" /> <!-- favicon -->
    <script type="text/javascript" src="dateheure.js"></script> <!-- appel de la fonction date et heure javascript --> 
    <link rel="stylesheet" href="index.css" /> <!-- appel du thème de la page -->    
</head>   
<body>
	<!-- en-tête -->
	<header> 	
		<div class="element" id="date">
			<!-- on affiche la date  -->
			<script type="text/javascript">window.onload = date('date');</script>
		</div>  	
		<div class="element" id="titre">
			<!-- on affiche le titre  -->	
			<h1>Live Streaming motorisé</h1>
		</div>	
		<div class="element" id="heure">
			<!-- on affiche l'heure  -->		
			<script type="text/javascript">window.onload = heure('heure');</script>
		</div>		
	</header> 
	<!-- corps de page -->
	<div id="content">
		<!-- la partie streaming  -->	
		<main>
			<!-- on  affiche ou pas l'iframe contenu dans la variable suivant play ou stop -->
			<div class="cam" class="element"><?php echo $affiche;?></div>
		</main>     
		<!-- le panneau de contrôle  -->
		<nav>
			<!-- on  affiche ou pas l'iframe contenu dans la variable suivant play ou stop -->
			<?php echo $affiche2;?>			 
		</nav>   
		<!-- la partie prise de photos  -->
		<aside>
			<!-- on  affiche ou pas l'iframe contenu dans la variable suivant play ou stop -->
			<?php echo $affiche3;?>	  
		</aside>       
	</div>
	<!-- pied de page -->
	<footer>
		<!-- div vide pour pour la disposition uniquement -->
		<div class="element"></div>
		<div class="element"></div>	
		<div class="element"><h3>Live streaming :</h3></div>
		<!-- bouton play -->
		<div class="element">
			<form class="form" method="post" action="index.php"> 		
				<input type="hidden" name="cam" value="play"><br>
				<input type="submit" name="play" id="play" value="play" />
			</form>		
		</div>
		<!-- bouton stop -->
		<div class="element">		
			<form class="form" method="post" action="index.php"> 		
				<input type="hidden" name="cam" value="stop"><br>
				<input type="submit" name="stop" id="stop" value="stop" />
			</form>	
		</div>		
		<!-- div vide pour pour la disposition uniquement -->
		<div class="element"></div>
		<div class="element"></div>		
	</footer> 
</body>
</html>
