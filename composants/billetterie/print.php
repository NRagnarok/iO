<?php
include ("print/qrlib.php");

function clearFolder($folder){
	$dossier=opendir($folder);
	while ($fichier = readdir($dossier)){
		if($fichier != "." && $fichier != ".."){
			$Vidage= $folder.$fichier;
			unlink($Vidage);
		}
	}
	closedir($dossier);
}

if(isset($_GET['ticket'])){
	$clcuserbillet = fetch(req('SELECT COUNT(*) AS total FROM __billetterie_reservation WHERE commentaires = "'.$_SESSION['utilisateur'].'" AND id = "'.$_GET['ticket'].'"'));
	if($clcuserbillet['total'] != "0"){
		$donnees = fetch(req('SELECT * FROM __billetterie_reservation WHERE commentaires = "'.$_SESSION['utilisateur'].'" AND id = "'.$_GET['ticket'].'"'));
		$event = fetch(req('SELECT * FROM __billetterie_event WHERE id="'.$donnees['autorise'].'"'));
		
		$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'print'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    	$PNG_WEB_DIR = 'print/temp/';
		if(!file_exists($PNG_TEMP_DIR))mkdir($PNG_TEMP_DIR);
		//$filename = $PNG_TEMP_DIR.md5('http://192.168.0.40/qr.php?i='.$donnees['id'].'&m='.$donnees['commentaires'].'|L|5').'.png';
        //QRcode::png("http://192.168.0.40/qr.php?i=".$donnees['id']."&m=".$donnees['commentaires'], $filename, "L", "5", 2);
		$filename = $PNG_TEMP_DIR.md5($donnees['id'].'|L|5').'.png';
        QRcode::png($donnees['id'], $filename, "L", "5", 2); 
		$name = $PNG_WEB_DIR.basename($filename);  
		$contenu = ('
<html>
	<body style="text-align:center;">
		');
		$name = $PNG_WEB_DIR.basename($filename);  
		
		if(strlen($donnees['parents']) == 1){
			$num = "000".$donnees['parents'];
		}else if (strlen($donnees['parents']) == 2){
			$num = "00".$donnees['parents'];
		}else if (strlen($donnees['parents']) == 3){
			$num = "0".$donnees['parents'];
		}else{
			$num = $donnees['parents'];
		}

		$contenu .= ('
		<table width="100%" border="0">
			<tr style="border-width:2px;border-style:solid;border-color:white;">
				<td align="center" bgcolor="#e8e8e8" width="385">
					<table width="100%" border="0">
						<tr>
							<td width="100"><img src="'.$billetterie['eventaff'].'" /></td>
							<td>
								<h3 class="verdana"><strong>Tesquitoi</strong></h3><span style="font-size:10px;">Ticket 1 place</span>
								<p class="trebuchet"><strong>');
					
					
				$date = explode(' ', $event['date']);
				$date = str_replace("/", "-", $date[0]);
				$formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,IntlDateFormatter::NONE,'Europe/Paris',IntlDateFormatter::GREGORIAN );
				$date =new DateTime($date);
				$contenu .= ucfirst($formatter->format($date));
				
					
					$contenu .= ('</strong></p>
								<p class="trebuchet">'.$event['lieu'].'</p><p align="right">Ticket '.$num.'</p>
							</td>
						</tr>
					</table>
				</td>
				<td align="center" bgcolor="#e8e8e8" class="trebuchet" width="145">
					<strong>Num&eacute;ro '.$num.'</strong><br />'.mb_strtoupper($donnees['nom']).' '.ucfirst($donnees['prenom']).'<br />
					<br /><strong>Tesquitoi</strong><br /><span style="font-size:10px">Ticket 1 place</span><br />
					<br />');
					
					
				$date = explode(' ', $event['date']);
				$date = str_replace("/", "-", $date[0]);
				$formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,IntlDateFormatter::NONE,'Europe/Paris',IntlDateFormatter::GREGORIAN );
				$date =new DateTime($date);
				$contenu .= ucfirst($formatter->format($date));
				
					
					$contenu .= ('<br /><br />'.$event['lieu'].'
				</td>
    			<td align="center" bgcolor="#e8e8e8" width="195">
					<img src="composants/billetterie/'.$name.'" /><br />
					<span style="font-size:8px;">Ticket '.$num.'</span>
				</td>
			</tr>
		</table>
		<hr />
	</body>
</html>
');
		require_once('print/pdf-core/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','fr');
		$html2pdf->WriteHTML($contenu);
		ob_end_clean();
		$html2pdf->Output();
		clearFolder("print/temp/");
	}
}else if(isset($_GET['utilisateur'])){
	$clcuserbillet = fetch(req('SELECT COUNT(*) AS total FROM __billetterie_reservation WHERE commentaires = "'.$_SESSION['utilisateur'].'"'));
	if($clcuserbillet['total'] != "0"){
		$contenu = ('
<html>
	<body style="text-align:center;">
		');
		$nbr = $clcuserbillet['total'];
		$req = req('SELECT * FROM __billetterie_reservation WHERE commentaires = "'.$_SESSION['utilisateur'].'" ORDER BY id ASC');
		while ($donnees = fetch($req)){
			$event = fetch(req('SELECT * FROM __billetterie_event WHERE id="'.$donnees['autorise'].'"'));
		
			$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'print'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    		$PNG_WEB_DIR = 'print/temp/';
			if(!file_exists($PNG_TEMP_DIR))mkdir($PNG_TEMP_DIR);
			//$filename = $PNG_TEMP_DIR.md5('http://192.168.0.40/qr.php?i='.$donnees['id'].'&m='.$donnees['commentaires'].'|L|5').'.png';
        	//QRcode::png("http://192.168.0.40/qr.php?i=".$donnees['id']."&m=".$donnees['commentaires'], $filename, "L", "5", 2); 
			$filename = $PNG_TEMP_DIR.md5($donnees['id'].'|L|5').'.png';
        	QRcode::png($donnees['id'], $filename, "L", "5", 2); 
			$name = $PNG_WEB_DIR.basename($filename);  
		
			if(strlen($donnees['parents']) == 1){
				$num = "000".$donnees['parents'];
			}else if (strlen($donnees['parents']) == 2){
				$num = "00".$donnees['parents'];
			}else if (strlen($donnees['parents']) == 3){
				$num = "0".$donnees['parents'];
			}else{
				$num = $donnees['parents'];
			}

			$contenu .= ('
		<table width="100%" border="0">
			<tr style="border-width:2px;border-style:solid;border-color:white;">
				<td align="center" bgcolor="#e8e8e8" width="385">
					<table width="100%" border="0">
						<tr>
							<td width="100"><img src="'.$billetterie['eventaff'].'" /></td>
							<td><h3 class="verdana">
								<strong>Tesquitoi</strong></h3><span style="font-size:10px;">Ticket 1 place</span>
								<p class="trebuchet"><strong>');
					
					
				$date = explode(' ', $event['date']);
				$date = str_replace("/", "-", $date[0]);
				$formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,IntlDateFormatter::NONE,'Europe/Paris',IntlDateFormatter::GREGORIAN );
				$date =new DateTime($date);
				$contenu .= ucfirst($formatter->format($date));
				
					
					$contenu .= ('</strong></p>
								<p class="trebuchet">'.$event['lieu'].'</p><p align="right">Ticket '.$num.'</p>
							</td>
						</tr>
					</table>
				</td>
				<td align="center" bgcolor="#e8e8e8" class="trebuchet" width="145">
					<strong>Num&eacute;ro '.$num.'</strong><br />'.mb_strtoupper($donnees['nom']).' '.ucfirst($donnees['prenom']).'<br />
					<br /><strong>Tesquitoi</strong><br /><span style="font-size:10px">Ticket 1 place</span><br />
					<br />');
					
					
				$date = explode(' ', $event['date']);
				$date = str_replace("/", "-", $date[0]);
				$formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,IntlDateFormatter::NONE,'Europe/Paris',IntlDateFormatter::GREGORIAN );
				$date =new DateTime($date);
				$contenu .= ucfirst($formatter->format($date));
				
					
					$contenu .= ('<br /><br />'.$event['lieu'].'
				</td>
				<td align="center" bgcolor="#e8e8e8" width="195"><img src="composants/billetterie/'.$name.'" /><br /><span style="font-size:8px;">Ticket '.$num.'</span></td>
  			</tr>
		</table>
			');
		
			if($nbr != "1"){
				$contenu .= "<hr />";
			}
			$nbr = $nbr-1;
		}
	
		$contenu .= ('
	</body>
</html>
		');
	
		require_once('print/pdf-core/html2pdf.class.php');
    
		$html2pdf = new HTML2PDF('P','A4','fr');
    	$html2pdf->WriteHTML($contenu);
		ob_end_clean();
    	$html2pdf->Output();
		clearFolder("print/temp/");
	}
}
?>