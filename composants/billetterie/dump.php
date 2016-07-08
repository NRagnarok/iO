<?php 
error_reporting(E_ALL);
$mysqli_serveur_cron = "mysql51-65.pro"; // hôte de la base mysql51-65.pro
$mysqli_base_cron = "tesquitoi_site"; // nom de la base
$mysqli_utilisateur_cron = "tesquitoi_site"; // Identifiant de connexion
$mysqli_pass_cron = "ayxqs7k7"; // On regarde pas !
session_start();
try
{
    $bdd = new PDO('mysql:host='.$mysqli_serveur.';dbname='.$mysqli_base, $mysqli_utilisateur, $mysqli_pass);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
if(!isset($_SESSION['utilisateur']) && !isset($_SESSION['pass']) && !isset($_SESSION['nom']) && !isset($_SESSION['prenom']) && !isset($_SESSION['methodconnex'])){header('Location:connexion.php?noconnect'); exit();}else{
	$req = $bdd->prepare('SELECT motdepasse FROM portail_utilisateurs WHERE mail = ?');
						$req->execute(array($_SESSION['utilisateur']));
					$utilisateur = $req->fetch();
					$req->closeCursor();
					if($utilisateur['motdepasse'] != $_SESSION['pass']){header('Location:connexion.php?badpass'); exit();}
					}
function backupDatabase($link,$db_name,$structure,$donnees, $format,$insertComplet=""){
/* Parametres : 
* $link : lien vers la base de donnees
* $db_name : nom de la base de donnees
* $structure : true => sauvegarde de la structure des tables
* $donnees : true => sauvegarde des donnes des tables
* $format : format des donnees ('INSERT' => des clauses SQL INSERT,
* 'CSV' => donnees separees par des virgules)
* $insertComplet (optionnel) : true => clause INSERT avec nom des champs
*/
global $wpdb, $link;

$format = strtoupper($format);

$filename = "dump/backup_".$db_name."_".date("Y_m_d_H_i").".sql";
$fp = fopen($filename,"w");
if (!is_resource($fp))
echo "pb1";

$tablename= "portail_billetterie_reservation";

mysqli_select_db ($db_name, $link);
// les données de la table
$query = "SELECT * FROM portail_billetterie_reservation WHERE autorise = '".$_GET['event']."'";
$resData = mysqli_query($link, $query);
if (mysqli_num_rows($resData) > 0)
{
$sFieldnames = "";
if ($insertComplet === true)
{
$num_fields = mysqli_num_fields($resData);
for($j=0; $j < $num_fields; $j++)
{
$sFieldnames .= "`".mysqli_field_name($resData, $j)."`,";
}
$sFieldnames = "(".substr($sFieldnames,0,-1).")";
}
$sInsert = "INSERT INTO `us_event_tesquitoi".$_GET['event']."` $sFieldnames values ";

while($rowdata = mysqli_fetch_assoc($resData))
{
$lesDonnees = "<guillemet>".implode("<guillemet>,<guillemet>",$rowdata)."<guillemet>";
$lesDonnees = stripslashes($lesDonnees);
$lesDonnees = str_replace("<guillemet>","'",addslashes($lesDonnees));

if ($format == "INSERT")
{
$lesDonnees = "$sInsert($lesDonnees);";

}
fwrite($fp,"$lesDonnees\n");
}

}
fclose($fp);
return $filename;
}

$link = mysqli_connect($mysqli_serveur,$mysqli_utilisateur,$mysqli_pass);
$txt = backupDatabase($link,$mysqli_base,false,true,'INSERT');
echo('<meta http-equiv="content-type" content="text/html; charset=utf-8" />');
include($txt);
unlink($txt);
?>