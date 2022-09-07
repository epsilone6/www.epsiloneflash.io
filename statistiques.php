<?php
//			_____ _______ _____ ________
//		   / ____|__   _ |  __ | __   _
//		   \___     | |     ..||   | |
//		       \ \	| |    |  ||   | |
//		   |___/_/  |_|   _|  ||   |_|

//	par Dolvann Feupi, pour EPSILONE FLASH.
//			 		© Juillet 2022

$connexion = mysqli_connect('host', 'root', ' ');
$db = mysqli_select_db($connexion, 'epsilone');

$nb_visites = file_get_contents('data/pagesvues.txt');
$nb_visites++;

file_put_contents('data/pagesvues.txt', $nb_visites);

echo 'Nombre de pages vues : <strong>' . $nb_visites .
'</strong><br/>';

//ETAPE 1 - Affichage du nombre de visites d'aujourd'hui
$retour_count = mysqli_query($connexion, 'SELECT COUNT(*) AS nbre_entrees FROM visites_jour WHERE date=CURRENT_DATE()'); //On compte le nombre d'entrées pour aujourd'hui

$donnees_count = mysqli_fetch_assoc($retour_count); //Fetch-array
echo 'Pages vues aujourd\'hui : <strong>'; // On affiche tout de suite pour pas le retaper 2 fois après

if ($donnees_count['nbre_entrees'] == 0) //Si la dated'aujourd'hui n'a pas encore été enregistrée (première visite de la journée)
{
	mysqli_query($connexion, 'INSERT INTO visites_jour(visites, date) VALUES (1, CURRENT_DATE());'); //On rentre la date d'aujourd'hui et on marque 1 comme nombre de visites.
echo '1'; //On affiche une visite car c'est la première visite de la journée

} else { //Si la date a déjà été enregistrée
	$retour = mysqli_query($connexion, 'SELECT visites FROM visites_jour WHERE date=CURRENT_DATE()'); //On sélectionne l'entrée qui correspond à notre date
	$donnees = mysqli_fetch_assoc($retour);
	$visites = $donnees['visites'] + 1; //Incrémentation du nombre de visites
	mysqli_query($connexion, 'UPDATE visites_jour SET visites = visites + 1 WHERE date=CURRENT_DATE()'); //Update dans la base dedonnées
	echo $visites; //Enfin, on affiche le nombre de visites d'aujourd'hui !
}
echo '</strong></br/>';


//ETAPE 2 - Record des connectés par jour
$retour_max = mysqli_query($connexion, 'SELECT visites, date FROM
visites_jour ORDER BY visites DESC LIMIT 0, 1'); //On sélectionnel'entrée qui a le nombre visite le plus important
$donnees_max = mysqli_fetch_assoc($retour_max);
echo 'Record : <strong>' . $donnees_max['visites'] . '</strong>
établi le <strong>' . $donnees_max['date'] . '</strong><br/>'; //On l'affiche ainsi que la date à laquelle le record a été établi


//ETAPE 3 - Moyenne du nombre de visites par jour
$total_visites = 0; //Nombre de visites
$total_jours = 0;//Nombre de jours enregistrés dans la base
$total_visites = mysqli_fetch_assoc(mysqli_query($connexion,'SELECT SUM(visites) FROM visites_jour AS total_visites'));
$total_visites = $total visites['total visites'];
$total_jours = mysqli_fetch_assoc(mysqli_query($connexion, 'SELECT
COUNT(*) FROM visites_jour AS total_jours'));
$total_jours = $total_jours['total_jours'];
$moyenne = $total_visites/$total_jours; //on fait la moyenne
echo 'Moyenne : <strong>' . $moyenne . '</strong> visiteurs par
jour<br/>'; // On affiche ! Terminé !!!



?>
