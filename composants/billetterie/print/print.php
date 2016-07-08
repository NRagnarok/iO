<?php
require('../configuration.php');
include "qrlib.php";
    function clearFolder($folder)
    {
            // 1 ouvrir le dossier
            $dossier=opendir($folder);
            //2)Tant que le dossier est aps vide
            while ($fichier = readdir($dossier))
            {
                    //3) Sans compter . et ..
                    if ($fichier != "." && $fichier != "..")
                    {
                            //On selectionne le fichier et on le supprime
                            $Vidage= $folder.$fichier;
                            unlink($Vidage);
                    }
            }
            //Fermer le dossier vide
            closedir($dossier);
    }


try
{
    $bdd = new PDO('mysql:host='.$mysql_serveur.';dbname='.$mysql_base, $mysql_utilisateur, $mysql_pass);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
session_start();
if(!isset($_SESSION['utilisateur']) && !isset($_SESSION['pass']) && !isset($_SESSION['nom']) && !isset($_SESSION['prenom']) && !isset($_SESSION['methodconnex'])){header('Location:../connexion.php?noconnect'); exit();}else{

					if($utilisateur['motdepasse'] != $_SESSION['pass']){header('Location:../connexion.php?badpass'); exit();}
					}
					if(isset($_GET['ticket'])){
						$req2 = $bdd->prepare('SELECT COUNT(*) AS total FROM __billetterie_reservation WHERE commentaires = ? AND id = ?');
						$req2->execute(array($_SESSION['utilisateur'], $_GET['ticket']));
					$clcuserbillet = $req2->fetch();
					$req2->closeCursor();
					if($clcuserbillet['total'] != "0"){
	$req = $bdd->prepare('SELECT * FROM __billetterie_reservation WHERE commentaires = ? AND id = ?');
$req->execute(array($_SESSION['utilisateur'], $_GET['ticket']));
$donnees = $req->fetch();
$event_req = $bdd->prepare('SELECT * FROM __billetterie_event WHERE id="'.$donnees['autorise'].'"');
$event_req->execute();
$event = $event_req->fetch();
$event_req->closeCursor();
		$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'temp/';
	
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
		
          $filename = $PNG_TEMP_DIR.md5('http://192.168.0.40/qr.php?i='.$donnees['id'].'&m='.$donnees['commentaires'].'|M|4').'.png';
        QRcode::png("http://192.168.0.40/qr.php?i=".$donnees['id']."&m=".$donnees['commentaires'], $filename, "M", "5", 2); 
		$name = $PNG_WEB_DIR.basename($filename);  

$contenu = ('
<html>
<body style="text-align:center;">');
		$name = $PNG_WEB_DIR.basename($filename);  
		if (strlen($donnees['id']) == 1) {$num = "000".$donnees['id'];}else 
if (strlen($donnees['id']) == 2) {$num = "00".$donnees['id'];}else 
if (strlen($donnees['id']) == 3) {$num = "0".$donnees['id'];}else 
{$num = $donnees['id'];}
$contenu .= ('<table width="100%" border="0">
     <tr style="border-width:2px;border-style:solid;border-color:white;">
    <td align="center" bgcolor="#e8e8e8" width="385">
    <table width="100%" border="0">
  <tr>
    <td width="100"><img src="'.$eventaff.'" /></td>
    <td><h3 class="verdana"><strong>Tesquitoi</strong></h3><span style="font-size:10px;">Ticket 1 place</span>
      <p class="trebuchet"><strong>'.$event['date'].'</strong></p>
      <p class="trebuchet">'.$event['lieu'].'</p><p align="right">Ticket '.$num.'</p></td>
  </tr>
</table></td><td align="center" bgcolor="#e8e8e8" class="trebuchet" width="145"><strong>Num&eacute;ro '.$num.'</strong><br />'.mb_strtoupper($donnees['nom']).' '.ucfirst($donnees['prenom']).'<br /><br /><strong>Tesquitoi</strong><br /><span style="font-size:10px">Ticket 1 place</span><br /><br />'.$event['date'].'<br /><br />'.$event['lieu'].'</td>
    <td align="center" bgcolor="#e8e8e8" width="195"><img src="'.$name.'" /><br /><span style="font-size:8px;">Ticket '.$num.'</span></td>
  </tr>
</table><hr />');
$contenu .= ('</body></html>');
    require_once('pdf-core/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($contenu);
	ob_end_clean();
    $html2pdf->Output();
	clearFolder("temp/");
	
 }
 } else if(isset($_GET['utilisateur'])){
	 						$req2 = $bdd->prepare('SELECT COUNT(*) AS total FROM __billetterie_reservation WHERE commentaires = ?');
						$req2->execute(array($_SESSION['utilisateur']));
					$clcuserbillet = $req2->fetch();
					$req2->closeCursor();
					if($clcuserbillet['total'] != "0"){
	$req = $bdd->prepare('SELECT * FROM __billetterie_reservation WHERE commentaires = ? ORDER BY id ASC');
$req->execute(array($_SESSION['utilisateur']));
		
$contenu = ('
<html>
<body style="text-align:center;">');
$nbr = $clcuserbillet['total'];
while ($donnees = $req->fetch())
{
	$event_req = $bdd->prepare('SELECT * FROM __billetterie_event WHERE id="'.$donnees['autorise'].'"');
$event_req->execute();
$event = $event_req->fetch();
$event_req->closeCursor();
	$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'temp/';
	
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
		
          $filename = $PNG_TEMP_DIR.md5('http://192.168.0.40/qr.php?i='.$donnees['id'].'&m='.$donnees['commentaires'].'|M|5').'.png';
        QRcode::png("http://192.168.0.40/qr.php?i=".$donnees['id']."&m=".$donnees['commentaires'], $filename, "M", "5", 2); 
		$name = $PNG_WEB_DIR.basename($filename);  
		if (strlen($donnees['id']) == 1) {$num = "000".$donnees['id'];}else 
if (strlen($donnees['id']) == 2) {$num = "00".$donnees['id'];}else 
if (strlen($donnees['id']) == 3) {$num = "0".$donnees['id'];}else 
{$num = $donnees['id'];}
$contenu .= ('<table width="100%" border="0">
     <tr style="border-width:2px;border-style:solid;border-color:white;">
    
    <td align="center" bgcolor="#e8e8e8" width="385">
    <table width="100%" border="0">
  <tr>
    <td width="100"><img src="'.$eventaff.'" /></td>
    <td><h3 class="verdana"><strong>Tesquitoi</strong></h3><span style="font-size:10px;">Ticket 1 place</span>
      <p class="trebuchet"><strong>'.$event['date'].'</strong></p>
      <p class="trebuchet">'.$event['lieu'].'</p><p align="right">Ticket '.$num.'</p></td>
  </tr>
</table></td><td align="center" bgcolor="#e8e8e8" class="trebuchet" width="145"><strong>Num&eacute;ro '.$num.'</strong><br />'.mb_strtoupper($donnees['nom']).' '.ucfirst($donnees['prenom']).'<br /><br /><strong>Tesquitoi</strong><br /><span style="font-size:10px">Ticket 1 place</span><br /><br />'.$event['date'].'<br /><br />'.$event['lieu'].'</td>
    <td align="center" bgcolor="#e8e8e8" width="195"><img src="'.$name.'" /><br /><span style="font-size:8px;">Ticket '.$num.'</span></td>
  </tr>
</table>');
if($nbr != "1"){$contenu .= "<hr />";}
$nbr = $nbr-1;
}

$contenu .= ('</body></html>');
   require_once('pdf-core/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($contenu);
	ob_end_clean();
    $html2pdf->Output();
	clearFolder("temp/");
					}
	 }
?>
