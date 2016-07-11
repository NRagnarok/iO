<?php
if(isset($_SERVER['HTTPS'])){
	$url = "https://";
	if($_SERVER['SERVER_PORT'] == "443"){
		$port = "";
	}else{
		$port = ":".$_SERVER['SERVER_PORT'];
	}//Si la connexion est en https alors le port ajouté à l'url sera vide (car par défaut 443) mais si il est différent, il prend le numéro correspondant
}else{
	$url = "http://";
	if($_SERVER['SERVER_PORT'] == "80"){
		$port = "";
	}else{
		$port = ":".$_SERVER['SERVER_PORT'];
	}//Si la connexion est en http alors le port ajouté à l'url sera vide (car par défaut 80) mais si il est différent, il prend le numéro correspondant
}

$url = 	str_replace($site['HTTP'].$_SERVER['SERVER_NAME'].$port, '',
		str_replace('index.php', '', 
		str_replace(':/', '://', 
		str_replace('//', '/', $url.$_SERVER['SERVER_NAME'].$port."/".$_SERVER['PHP_SELF'])))); //on bidouille un peu l'url...
	
$racine = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']); //on enlève le index.php du lien complet système vers le fichier principal php

$lecture_conf = file($racine."configuration.php"); // on lit le fichier de conf
$contenu_conf = ""; 
foreach($lecture_conf as $ligne){
$contenu_conf .= $ligne; //On met chaque ligne du fichier dans une même variable
}
$nouveau_contenu = str_replace(str_replace($site['HTTP'].$_SERVER['SERVER_NAME'].$port, '', $site['url']), $url, str_replace($site['racine'], $racine, $contenu_conf)); //on met à jour ces deux emplacements

$reecriture_conf = fopen($racine.'configuration.php', 'w+'); //On réécrit le fichier
fwrite($reecriture_conf, $nouveau_contenu);
fclose($reecriture_conf);
header('Location:index.php');
exit();
?>