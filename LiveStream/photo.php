<?php
// on affiche le logo en bouton (valeur 8)
echo '
			<h3>Photo :</h3>
			<div id="photo" style="margin-left:30%">
				<form class="form" method="post" action="photo.php"> 		
					<input type="hidden" name="photo" value="8"><br>
					<input type="image" src="img/icone-photo.png" alt="Submit">
				</form>
			</div>
			';
						
// Si on click sur le logo ou sur effacer
 if(!empty($_POST))  {
	 // on met sa valeur du bouton dans la variable data (8 ou 9)
	$data = $_POST['photo'];
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
	// attend 1 seconde
	sleep(1);		
}
// on lance la fonction fichier 
fichier();


// fonction fichier 
function fichier()
{
	$dir_nom = 'Photos'; // dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
	$dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
	$fichier= array(); // on déclare le tableau contenant le nom des fichiers
	$dossier= array(); // on déclare le tableau contenant le nom des dossiers

	while($element = readdir($dir)) { // on lit le dossier et place les elements dans une variable
		if($element != '.' && $element != '..') { //  si les element ne commence pas par . ou .. ( pour les ne pas lister les fichiers cachés)
			if (!is_dir($dir_nom.'/'.$element)) {$fichier[] = $element;}  // fait le tri entre fichiers et dossiers
			else {$dossier[] = $element;}
		}
	}
	closedir($dir); // ferme la lecture
	
	// si il y a des fichiers :
	if (!empty($fichier)){ 
		sort($fichier);//  tri croissant des fichiers, rsort() pour le tri décroissant
		echo "Photos prises : \n\n";  // pour chaque fichier affiche le lien dans une liste
		echo "\t\t<ul>\n";
			foreach($fichier as $lien) { 
				echo "\t\t\t<li><a href=\"$dir_nom/$lien \"target=\"_blank\">$lien</a></li>\n";
			}
		echo "\t\t</ul>";
		
		// et propose de les effacer (la valeur du bouton vaut 9)
		echo '<br>';
		echo 'Veux tu effacer les photos ? ';
		echo '<br>';
		echo '
		<form method="post" action="photo.php">
		<input type="radio" name="photo" value="9">
		Oui
		<input type="submit" value="Valider">
		</form> </br>';
	} else {
		echo ' ';					
		}
}
?>		
