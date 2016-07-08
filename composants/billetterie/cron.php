<?php
$whl_event_req = req('SELECT * FROM __billetterie_event ORDER BY id ASC');
	
	while($whl_event = fetch($whl_event_req)){
		$req = req('SELECT COUNT(*) AS total FROM __billetterie_reservation WHERE autorise = "'.$whl_event['id'].'"');
		$donnees = fetch($req);
		$plcrestant_cron = $whl_event['pmax']-$donnees['total'];
		$reqa = req('SELECT COUNT(*) AS total FROM __billetterie_attente WHERE autorise = "'.$whl_event['id'].'"');
		$donnees1 = fetch($reqa);
		$attente = $donnees1['total'];

		while(($plcrestant_cron > 0) && ($attente > 0)){
			$req1 = req('SELECT id, nom, prenom, commentaires, autorise FROM __billetterie_attente WHERE autorise = "'.$whl_event['id'].'" ORDER BY id ASC LIMIT 1');
			$move = fetch($req1);
			$req2 = req('SELECT id FROM __billetterie_reservation ORDER BY id DESC LIMIT 1');
			$donnees2 = fetch($req2);
			$newid = $donnees2['id']+1;
			$reqie = req('SELECT parents FROM __billetterie_reservation WHERE autorise = "'.$whl_event['id'].'" ORDER BY parents DESC LIMIT 1');
			$donneesie = fetch($reqie);
			$newidevent = $donneesie['parents']+1;
			req('INSERT INTO __billetterie_reservation(id, nom, prenom, parents, tarif, commentaires, autorise) VALUES(\''.$newid.'\', \''.$move['nom'].'\', \''.$move['prenom'].'\', \''.$newidevent.'\',\'3\', \''.$move['commentaires'].'\', \''.$move['autorise'].'\')');	
			req('DELETE FROM __billetterie_attente WHERE id = "'.$move['id'].'" AND commentaires = "'.$move['commentaires'].'"');

			$sujet = 'Tesquitoi - 1 ticket de votre file d\'attente a été validé !';
			$message = '<p style="font-family: Tahoma, Geneva, sans-serif;">Bonjour !</p>
			<p style="font-family: Tahoma, Geneva, sans-serif;">bonjour,<br />L\'un de vos tickets en file d\'attente a &eacute;t&eacute; valid&eacute; !</p>
			<p style="font-family: Tahoma, Geneva, sans-serif;">Vous pouvez d&eacute;sormais l\'imprimer !</p>
			<p style="font-family: Tahoma, Geneva, sans-serif;"><a href="http://www.tesquitoi.fr/reservations">http://www.tesquitoi.fr/reservations</a></p>
			<p style="font-family: Tahoma, Geneva, sans-serif;">&nbsp;</p>
			<p style="font-family: Tahoma, Geneva, sans-serif;">Cordialement,</p>
			<p style="font-family: Tahoma, Geneva, sans-serif;">L\'&eacute;quipe Tesquitoi</p>';
			$headers = "From: \"Tesquitoi\"<billetterie@tesquitoi.fr>\n";
			$headers .= "Reply-To: tesquitoi@lacroixrouge-brest.fr\n";
			$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
			mail($move['commentaires'],$sujet,$message,$headers);
			
			$req = req('SELECT COUNT(*) AS total FROM __billetterie_reservation WHERE autorise = "'.$whl_event['id'].'"');
			$donnees = fetch($req);
			$plcrestant_cron = $whl_event['pmax']-$donnees['total'];
			$reqa = req('SELECT COUNT(*) AS total FROM __billetterie_attente WHERE autorise = "'.$whl_event['id'].'"');
			$donnees1 = fetch($reqa);
			$attente = $donnees1['total'];
		}

	}
?>