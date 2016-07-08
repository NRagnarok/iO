<?php
if($utilisateur['validation'] != "1"){
	redirection('reservations?novalid');
	exit();
}

$selectevent_d = fetch(req('SELECT * FROM __billetterie_event'));
$req_depassement = fetch(req("SELECT depassement FROM __billetterie_depassement WHERE id = '".$utilisateur['id']."'"));
$depassement_perso = $req_depassement['depassement'];

if(isset($_POST['nombre'])){
	addReservation();
}
if(isset($_POST['attente'])){
	addAttente();
}
if(isset($_GET['toosaved'])){
	alerte('Il n\'y a plus de place disponible. Si vous d&eacute;sirez nous contacter, vous pouvez <a href="nous-contacter">cliquer ici</a>.', 'danger');
}
if(isset($_GET['toosaveduser'])){
	alerte('Vous avez atteint votre limite de r&eacute;servations. Si vous d&eacute;sirez nous contacter, vous pouvez <a href="nous-contacter">cliquer ici</a>.', 'danger');
}
alerteFermeture();
if($billetterie['ouvert'] == "non"){
	redirection('reservations');
	exit();
}
?>
<center><a href="reservations" class="btn btn-danger btn-lg">Voir mes réservations</a></center>
<b>Les &eacute;v&eacute;nements disponibles</b>
<table width="100%" class="table table-bordered table-hover">
	<tr class="active">
    	<td width="10%" align="center"><strong>Place(s) restante(s)</strong></td>
    	<td width="70%" align="center"><strong>&Eacute;v&eacute;nement</strong></td>
    	<td width="20%" align="center"><strong>R&eacute;server</strong></td>
	</tr>
<?php
$whl_event_req = req('SELECT * FROM __billetterie_event ORDER BY id ASC');
while($whl_event = fetch($whl_event_req)){					
?>
	<!-- Debut zone event -->
     <tr style="border-radius: 0px 20px 0px 20px;">
<?php 
	$donnees = fetch(req('SELECT COUNT(*) AS total FROM __billetterie_reservation WHERE autorise = "'.$whl_event['id'].'"'));
	
	$qtuserdonnes = fetch(req('SELECT COUNT(*) AS totaluser FROM __billetterie_reservation WHERE commentaires = "'.$_SESSION['utilisateur'].'" AND autorise = "'.$whl_event['id'].'"'));
	$qtuser = $qtuserdonnes['totaluser'];
	
	$qtuserdonnes = fetch(req('SELECT COUNT(*) AS totaluser FROM __billetterie_attente WHERE commentaires = "'.$_SESSION['utilisateur'].'" AND autorise = "'.$whl_event['id'].'"'));
	$qtuser = $qtuser+$qtuserdonnes['totaluser'];
				
	$plcrestant = $whl_event['pmax']-$donnees['total'];
	if($plcrestant <= 0){
		$couleur = "ff0000";
	}else if($plcrestant <= $whl_event['pmax']*10/100){
		$couleur = "ff6c00";
	}else if($plcrestant <= $whl_event['pmax']*50/100){
		$couleur = "067b00";
	}else if($plcrestant <= $whl_event['pmax']*75/100){
		$couleur = "0ade00";
	}else if($plcrestant <= $whl_event['pmax']){
		$couleur = "004d8e";
	}
	echo('<td width="10%" align="center" style="font-size:36px; color:#'.$couleur.';">'.$plcrestant.'</td>');
?>        
		<td width="70%" align="center">
			<div class="col-lg-2"><img src="<?php echo $billetterie['eventaff']; ?>" /></div>
			<div class="col-lg-10">
            	<h3><strong>Tesquitoi</strong></h3>
				<p><strong class="untick">Ticket 1 place</strong> - Caisse citoyenne*</p>
      			<p style="color:<?php if($whl_event['id']%2){echo('#03F;');}else{echo('#093;');}?>"><strong><?php
				$date = explode(' ', $whl_event['date']);
				$date = str_replace("/", "-", $date[0]);
				$formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,IntlDateFormatter::NONE,'Europe/Paris',IntlDateFormatter::GREGORIAN );
				$date =new DateTime($date);
				echo ucfirst($formatter->format($date));
				?></strong></p>
      			<p><?php echo $whl_event['lieu']; ?></p>
      			<p>(<a href="a-propos">voir toutes les informations</a>)</p>
			</div>
		</td>
		<td width="20%" align="center">
        <form action="billetterie" method="post">
			<input type="hidden" name="idevent" value="<?php echo $whl_event['id']; ?>">
			<select name="nombre" <?php if($plcrestant <= 0){echo('disabled');} ?> class="form-control">
<?php
	if($depassement_perso == "0"){
	}else if($depassement_perso == ""){
	}else if($depassement_perso == "-1"){
		$billetterie['reservationmaxperuser'] = $plcrestant;
	}else{
		$billetterie['reservationmaxperuser'] = $depassement_perso;
	}
	$billetterie['reservationmaxperuser_boucle'] = $billetterie['reservationmaxperuser'];
	$option = 1;
	while($billetterie['reservationmaxperuser_boucle'] > 0){
		echo('<option value="'.$option.'"');
		if($depassement_perso != "-1"){
			if($plcrestant-$option < 0){
				echo('disabled');
			}else{
				if($billetterie['limituserreserv'] == "oui" && $option+$qtuser > $billetterie['reservationmaxperuser']){
					echo('disabled');
				}
			}
		}
		
		if($option == 1){
			echo('>1 place</option>');
		}else{
			echo('>'.$option.' places</option>');
		}		
		$option=$option+1;
		$billetterie['reservationmaxperuser_boucle']=$billetterie['reservationmaxperuser_boucle']-1;
	}
?>
			</select>
        	<br />
            <input type="submit" value="<?php if($plcrestant <= 0){echo('Plus aucune place disponible !');}else{echo('Faire la r&eacute;servation');} ?>" <?php if($plcrestant <= 0){echo('disabled');} ?> class="btn btn-success" />
 		</form>
        <br />
<?php 
	if($plcrestant <= 0){
		alerte('<strong>Vous pouvez r&eacute;server en file d\'attente</strong><br />
        		Si des places se lib&egrave;rent, vous serez notifi&eacute; par mail et votre liste d\'attente passera en tant que r&eacute;servation.<br />
				'.genererFormulaireAttente($whl_event['id']), 'danger');
	} 

	if($billetterie['limituserreserv'] == "oui"){
		echo "<em>Vous pouvez effectuer au maximum ".$billetterie['reservationmaxperuser']." r&eacute;servations.
			(sous condition de places disponibles)</em><br />Si vous d&eacute;sirez r&eacute;server plus de tickets, vous pouvez <a href=\"contact\">nous contacter</>.";
	}
?>
		</td>
	</tr>
  <!-- Fin zone event -->
<?php
}
?>
	<tr class="active">
		<td width="10%" align="center"><strong>Place(s) restante(s)</strong></td>
		<td width="70%" align="center"><strong>&Eacute;v&eacute;nement</strong></td>
		<td width="20%" align="center"><strong>R&eacute;server</strong></td>
	</tr>
</table>
* Le soir du spectacle, une caisse citoyenne sera mise &agrave; votre disposition, et vous pourrez verser la somme que vous d&eacute;sirez.