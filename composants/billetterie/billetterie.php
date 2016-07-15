<?php
require "_fonctions.php";

function billetterie_cron(){
	include("cron.php");
}

function billetterie(){
	$limite_par_utilisateur = "0";
	global $billetterie, $theme, $utilisateur;
	autoAuthCheck();
	
	$check_limit = fetch(req('SELECT COUNT(*) AS total FROM __billetterie_depassement WHERE id = "'.$utilisateur['id'].'"'));
	if($check_limit['total'] == "0"){req('INSERT INTO __billetterie_depassement (id, depassement) VALUES("'.$utilisateur['id'].'", "'.$limite_par_utilisateur.'")');}
	
	
	switch($_GET['lien']){
		case "billetterie_evenements": 
			echo str_replace("{TITRE}", "Billetterie", $theme['page_entete']);
			include("reserver.php");
			echo $theme['page_pied']; 
			break;
		case "billetterie_reservations": 
			echo str_replace("{TITRE}", "Mes réservations", $theme['page_entete']);
			include("reservations.php"); 
			echo $theme['page_pied'];
			break;
		case "billetterie_imprimer": 
			include("print.php"); 
			break;
		case "billetterie_suppression": 
			echo str_replace("{TITRE}", "Suppression d'une réservation", $theme['page_entete']);
			include("suppression.php"); 
			echo $theme['page_pied'];
			break;
		case "billetterie_modification": 
			echo str_replace("{TITRE}", "Modification d'une réservation", $theme['page_entete']);
			include("nomresa.php");
			echo $theme['page_pied'];
			break;
		default: 
			echo str_replace("{TITRE}", "Billetterie", $theme['page_entete']);
			include("reserver.php");
			echo $theme['page_pied'];
			break;
	}
}

billetterie_cron();
?>