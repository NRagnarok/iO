<?php
function boite(){
	global $site;
	$xml = simplexml_load_file('themes/'.$site['theme'].'/modeles/boites.xml');
	foreach($xml as $boite){
		$entete = $boite->entete;
		$pied = $boite->pied;		
	}
	
	echo str_replace("{TITRE}", "Mon compte", $entete);
	

if(!isset($_SESSION['utilisateur']) 
&& !isset($_SESSION['pass']) 
&& !isset($_SESSION['nom']) 
&& !isset($_SESSION['prenom']) 
&& !isset($_SESSION['methodconnex']) 
&& !isset($_SESSION['grade'])){
	
	$add = "";	
	if(isset($_GET['lien'])){
		$add = "?retour=".$_GET['lien'];
	}
		
		alerte('Vous n\'&ecirc;tes pas connect&eacute;.', 'info');
		echo ('<a href="connexion'.$add.'" class="btn btn-primary">Se connecter</a>');

}else{

		alerte('Bienvenue <b>'.mb_strtoupper($_SESSION['nom']).' '.$_SESSION['prenom'].'</b> !', 'succes'); 
		
	if($_SESSION['grade'] == "admin"){
		echo('<a href="administration/" class="btn btn-success"><i class="fa fa-fw fa-wrench"></i> Accéder à l\'administration</a>&nbsp;&nbsp;');
	}
		echo('<a href="http://cloud.penn-ar-rock.fr" target="_blank" class="btn btn-default"><i class="fa fa-fw fa-cloud"></i> Cloud</a>&nbsp;&nbsp;');
		echo('<a href="deconnexion" class="btn btn-danger"><i class="fa fa-fw fa-sign-out"></i> Se déconnecter</a>');
}
echo "<br />";
echo $pied;
}
?>