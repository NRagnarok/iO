<?php
function billetterieVarInit(){
	global $billetterie;
	$req = req("SELECT * FROM __billetterie_configuration");
	while ($data = fetch($req)) {
		if($data['variable'] == "limituserreserv"){
			$billetterie['limituserreserv'] = $data['valeur'];
		}else if($data['variable'] == "reservationmaxperuser"){
			$billetterie['reservationmaxperuser'] = $data['valeur'];	
		}else if($data['variable'] == "ouvert"){
			$billetterie['ouvert'] = $data['valeur'];	
		}else if($data['variable'] == "alertefermeture"){
			$billetterie['alertefermeture'] = $data['valeur'];	
		}else if($data['variable'] == "eventaff"){
			$billetterie['eventaff'] = $data['valeur'];	
		}else if($data['variable'] == "eventaffwb"){
			$billetterie['eventaffwb'] = $data['valeur'];
		}else if($data['variable'] == "alertefermeturemsg"){
			$billetterie['alertefermeturemsg'] = $data['valeur'];	
		}
	}
}billetterieVarInit();

function alerteFermeture(){
	global $billetterie;
	if($billetterie['alertefermeture'] == "oui"){
		alerte($billetterie['alertefermeturemsg'], 'attention');
	}
}

function addReservation(){
	global $utilisateur, $billetterie;
	$req_depassement = fetch(req("SELECT depassement FROM __billetterie_depassement WHERE id = '".$utilisateur['id']."'"));
	$depassement_perso = $req_depassement['depassement'];
	$req = req('SELECT COUNT(*) AS total FROM __billetterie_reservation WHERE autorise = "'.$_POST['idevent'].'"');
	$donnees1 = fetch($req);
	$req = req('SELECT * FROM __billetterie_event WHERE id = "'.$_POST['idevent'].'"');
	$selectevent_d = fetch($req);
	$req = req('SELECT COUNT(*) AS totaluser FROM __billetterie_reservation WHERE commentaires = "'.$_SESSION['utilisateur'].'" AND autorise = "'.$_POST['idevent'].'"');
	$qtuserdonnes = fetch($req);
	$qtuser = $qtuserdonnes['totaluser'];
					
	if($selectevent_d['pmax']-$donnees1['total']-$_POST['nombre'] >= 0){
		if($depassement_perso == "0"){
		}else if($depassement_perso == ""){
		}else if($depassement_perso == "-1"){
			$billetterie['reservationmaxperuser'] = $selectevent_d['pmax']-$donnees1['total'];
		}else{
			$billetterie['reservationmaxperuser'] = $depassement_perso;
		}
		
		if($billetterie['limituserreserv'] == "oui" 
		&& $billetterie['reservationmaxperuser']-$qtuser-$_POST['nombre'] < 0 
		&& $depassement_perso != "-1"){
			redirection('billetterie?toosaveduser');
			exit();
		}else{
			$req = req('SELECT parents FROM __billetterie_reservation WHERE autorise = "'.$_POST['idevent'].'" ORDER BY id DESC LIMIT 1');
			$donnees = fetch($req);
			$newidevent = $donnees['parents']+1;
			$nbrcommande = $_POST['nombre'];
			
			while($nbrcommande > 0){
				$nom=str_replace("'"," ",$_SESSION['nom']);
				$prenom=str_replace("'"," ",$_SESSION['prenom']);
				$req = req('INSERT INTO __billetterie_reservation(nom, prenom, parents, tarif, commentaires, autorise) VALUES(\''.res(strtoupper($nom)).'\', \''.res(ucfirst($prenom)).'\', '.$newidevent.', \'3\', \''.$_SESSION['utilisateur'].'\', \''.$_POST['idevent'].'\')');						
				$nbrcommande=$nbrcommande-1;
				$req = req('SELECT parents FROM __billetterie_reservation WHERE autorise = "'.$_POST['idevent'].'" ORDER BY id DESC LIMIT 1');
				$donnees = fetch($req);
				$newidevent = $donnees['parents']+1;
			}
			redirection('billetterie_reservations?newreserv');
			exit();
		}
	}else{
		redirection('billetterie_evenements?toosaved'); 
		exit();
	}
}

function addAttente(){
	global $utilisateur, $billetterie;
	$req_depassement = fetch(req("SELECT depassement FROM __billetterie_depassement WHERE id = '".$utilisateur['id']."'"));
	$depassement_perso = $req_depassement['depassement'];
	$req = req('SELECT COUNT(*) AS totaluser FROM __billetterie_attente WHERE commentaires = "'.$_SESSION['utilisateur'].'" AND autorise = "'.$_POST['idevent'].'"');
	$qtuserdonnes = fetch($req);
	$req = req('SELECT * FROM __billetterie_event WHERE id = "'.$_POST['idevent'].'"');
	$selectevent_d = fetch($req);
	$qtuser = $qtuserdonnes['totaluser'];
	$req = req('SELECT COUNT(*) AS totaluser FROM __billetterie_reservation WHERE commentaires = "'.$_SESSION['utilisateur'].'" AND autorise = "'.$_POST['idevent'].'"');
	$qtuserdonnes = fetch($req);
	$qtuser = $qtuser+$qtuserdonnes['totaluser'];

		if($depassement_perso == "0"){
		}else if($depassement_perso == ""){
		}else if($depassement_perso == "-1"){
			$billetterie['reservationmaxperuser'] = 999;
		}else{
			$billetterie['reservationmaxperuser'] = $depassement_perso;
		}
		
		if($billetterie['limituserreserv'] == "oui" 
		&& $billetterie['reservationmaxperuser']-$qtuser-$_POST['nombre'] < 0){
			redirection('billetterie?toosaveduser'); 
			exit();
		}else{
			$nbrcommande = $_POST['attente'];
		
			while($nbrcommande > 0){
				$nom=str_replace("'"," ",$_SESSION['nom']);
				$prenom=str_replace("'"," ",$_SESSION['prenom']);
				$req = req('INSERT INTO __billetterie_attente(nom, prenom, tarif, commentaires, nodeclare, rentre, sorti, psortir, date, autorise) VALUES(\''.res(strtoupper($nom)).'\', \''.res(ucfirst($prenom)).'\', \'3\', \''.$_SESSION['utilisateur'].'\', \'0\', \'0\', \'0\', \'0\', \'0\', \''.$_POST['idevent'].'\')');												
				$nbrcommande=$nbrcommande-1;
				$req = req('SELECT id FROM __billetterie_attente ORDER BY id DESC LIMIT 1');
				$donnees = fetch($req);
			}
			
			redirection('billetterie_reservations?attente');
			exit();
		}
}

function adaptNum($num){
	switch(strlen($num)){
		case '1':
			return "000".$num;
			break;
		case '2':
			return "00".$num;
			break;
		case '3':
			return "0".$num;
			break;
		default:
			return $num;
	}
}

function genererFormulaireAttente($whl_event_id){
	global $billetterie, $utilisateur, $qtuser;
	$req_depassement = fetch(req("SELECT depassement FROM __billetterie_depassement WHERE id = '".$utilisateur['id']."'"));
	$depassement_perso = $req_depassement['depassement'];
$contenu_reservationattente = '<form action="billetterie" method="post"><input type="hidden" name="idevent" value="'.$whl_event_id.'"> <select name="attente" class="form-control">';

	if($depassement_perso == "0"){
	}else if($depassement_perso == ""){
	}else if($depassement_perso == "-1"){
		$billetterie['reservationmaxperuser'] = "999";
	}else{
		$billetterie['reservationmaxperuser'] = $depassement_perso;
	}
		$billetterie['reservationmaxperuser_boucle'] = $billetterie['reservationmaxperuser'];
		$option = 1;
		
		while($billetterie['reservationmaxperuser_boucle'] > 0){
			$contenu_reservationattente .= '<option value="'.$option.'"';
			
			if(50-$option < 0){
				$contenu_reservationattente .= 'disabled';
			}else{
				if($billetterie['limituserreserv'] == "oui" 
				&& $option+$qtuser > $billetterie['reservationmaxperuser']){
					$contenu_reservationattente .= 'disabled';
				}
			}
			
			if($option == 1){
				$contenu_reservationattente .= '>1 place</option>';
			}else{
				$contenu_reservationattente .= '>'.$option.' places</option>';
			}		
			
			$option=$option+1;
			$billetterie['reservationmaxperuser_boucle']=$billetterie['reservationmaxperuser_boucle']-1;
		}
		
		$contenu_reservationattente .= '</select><input type="submit" value="Mettre en file d\'attente" class="btn btn-warning" /></form>';
		
	return $contenu_reservationattente;
}
?>