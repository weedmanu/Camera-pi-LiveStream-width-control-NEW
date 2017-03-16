<?php 
echo '
			<h3>Photo :</h3>

			<div id="photo" style="margin-left:30%">

				<form class="form" method="post" action="photo.php"> 		
				<input type="hidden" name="photo" value="8"><br>
				<input type="image" src="img/icone-photo.png" alt="Submit">
				</form>

			</div>
			';
						
// Si le tableau $_POST existe alors le formulaire a été envoyé
 if(!empty($_POST))  {
	 	
	$data = $_POST['photo'];

	$host = "127.0.0.1";
	$port = 9999;

	$socket = socket_create(AF_INET, SOCK_STREAM,0) or die("Could not create socket\n");

	socket_connect ($socket , $host,$port ) ;

	socket_write($socket, $data, strlen ($data)) or die("Could not write data\n");

	socket_close($socket) ;

	sleep(1);
		
}

fichier();

function fichier()
{
	$dir_nom = 'Photos'; // dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
	$dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
	$fichier= array(); // on déclare le tableau contenant le nom des fichiers
	$dossier= array(); // on déclare le tableau contenant le nom des dossiers

	while($element = readdir($dir)) {
		if($element != '.' && $element != '..') {
			if (!is_dir($dir_nom.'/'.$element)) {$fichier[] = $element;}
			else {$dossier[] = $element;}
		}
	}
	closedir($dir);

	if (!empty($fichier)){
		sort($fichier);// pour le tri croissant, rsort() pour le tri décroissant
		echo "Photos prises : \n\n";
		echo "\t\t<ul>\n";
			foreach($fichier as $lien) {
				echo "\t\t\t<li><a href=\"$dir_nom/$lien \"target=\"_blank\">$lien</a></li>\n";
			}
		echo "\t\t</ul>";
		
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
