<?php
$racine = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']); //on enlève le index.php du lien complet système vers le fichier principal php
$lecture_conf = file($racine."configuration.php"); // on lit le fichier de conf
$contenu_conf = ""; 
foreach($lecture_conf as $ligne){
	$contenu_conf .= $ligne; //On met chaque ligne du fichier dans une même variable
}
$nouveau_contenu = str_replace($site['racine'], $racine, $contenu_conf); //on met à jour ces deux emplacements
$reecriture_conf = fopen($racine.'configuration.php', 'w+'); //On réécrit le fichier
fwrite($reecriture_conf, $nouveau_contenu);
fclose($reecriture_conf);
header('Location:index.php');
exit();
?>