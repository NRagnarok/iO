<a href="javascript:history.go(-1)" class="btn btn-default"><i class="fa fa-chevron-left"></i> Retour</a>
<?php 
alerte('Aucune entr&eacute;e en salle ne sera autoris&eacute;e sans pr&eacute;sentation de vos billet, pensez &agrave; les 
		<a href="billetterie_imprimer?utilisateur='.$utilisateur['mail'].'" target="_blank">imprimer</a> !', 'info');
alerteFermeture(); 
if(isset($_GET['attente'])){
	alerte('Vos places ont &eacute;t&eacute; plac&eacute;es en attente.', 'succes');
} 
if(isset($_GET['novalid'])){
	alerte('Vous devez confirmer votre compte en cliquant sur le lien que vous avez re&ccedil;u par mail avant de pouvoir réserver. 
			Si vous ne l\'avez pas re&ccedil;u, v&eacute;rifiez votre dossier spams dans vos emails. 
			Si vous n\'avez toujours rien re&ccedil;u, vous pouvez <a href="inscription?renvoyermail='.$utilisateur['mail'].'">
			r&eacute;envoyer un mail de confirmation</a> ou <a href="moncompte">modifier votre adresse email</a>.', 'danger');
}
if(isset($_GET['newreserv'])){
	alerte('Vos r&eacute;servations ont &eacute;t&eacute; effectu&eacute;es. Pensez &agrave; imprimer vos billets ou &agrave; noter leur num&eacute;ro !', 'succes');
}
if(isset($_GET['errsuppressiona'])){
	alerte('La suppression du ticket en attente a &eacute;chou&eacute; !', 'danger');
}
if(isset($_GET['errsuppression'])){
	alerte('La suppression du ticket num&eacute;ro #'.adaptNum($_GET['errsuppression']).' a &eacute;chou&eacute; !', 'danger');
}
if(isset($_GET['succsuppression'])){
	alerte('Le ticket num&eacute;ro #'.adaptNum($_GET['succsuppression']).' a bien &eacute;t&eacute; supprim&eacute; !', 'succes');
}
if(isset($_GET['succsuppressiona'])){
	alerte('Le ticket en attente a bien &eacute;t&eacute; supprim&eacute; !', 'succes');
}
if(isset($_GET['cn'])){
	alerte('Le ticket #'.adaptNum($_GET['cn']).' a bien chang&eacute; de propri&eacute;taire !', 'succes');
}
if(isset($_GET['cna'])){
	alerte('Le ticket en attente a chang&eacute; de propri&eacute;taire !', 'succes');
}
if($billetterie['ouvert'] == "oui"){
	echo ('<p align="center"><a href="billetterie_evenements" class="btn btn-danger btn-lg">Faire une nouvelle r&eacute;servation</a></p><br />');
}else{
	alerte('La billetterie est fermée.', 'danger');
}

$clcuserbillet = fetch(req('SELECT COUNT(*) AS total FROM __billetterie_reservation WHERE commentaires = "'.$utilisateur['mail'].'"'));
?>
<b>Les tickets &agrave; votre nom (Actuellement vous avez 
<?php 
echo $clcuserbillet['total']; 
if($clcuserbillet['total'] <= 1){
	echo (" ticket");
}else{
	echo (" tickets");
}
?>
)</b>
<table width="100%" class="table table-bordered table-hover">
	<tr class="active">
		<td width="10%" align="center"><strong>Num&eacute;ro du ticket<span  class="red">*</span></strong></td>
		<td width="70%" align="center"><strong>&Eacute;v&eacute;nement</strong></td>
		<td width="20%" align="center">
        	<strong>Actions</strong><br />
            <a href="billetterie_imprimer?utilisateur=<?php echo $utilisateur['mail']; ?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Impression group&eacute;e</a>
        </td>
	</tr>
<?php
if($clcuserbillet['total'] == "0"){
?>
	<tr>
		<td width="10%" align="center"></td>
		<td width="70%" align="center" style="font-size:24px;">Vous n'avez effectu&eacute; aucune r&eacute;servation pour le moment !</td>
		<td width="20%" align="center"></td>
	</tr>
<?php
}
$donnees_req = req('SELECT id, nom, prenom, parents, autorise FROM __billetterie_reservation WHERE commentaires = "'.$utilisateur['mail'].'" ORDER BY id');
while ($donnees = fetch($donnees_req)){
	if(strlen($donnees['parents']) == 1){
		$num = "000".$donnees['parents'];
	}else if(strlen($donnees['parents']) == 2){
		$num = "00".$donnees['parents'];
	}else if(strlen($donnees['parents']) == 3){
		$num = "0".$donnees['parents'];
	}else{
		$num = $donnees['parents'];
	}
	$event = fetch(req('SELECT * FROM __billetterie_event WHERE id="'.$donnees['autorise'].'"'));
?>
	<tr>
		<td width="10%" align="center">#<?php echo $num; ?></td>
		<td width="70%" align="center">
			<div class="col-lg-2"><img src="<?php echo $billetterie['eventaff']; ?>" /></div>
			<div class="col-lg-10">
            	<h3><strong>Tesquitoi</strong></h3>
				<p>
                	Au nom de : <strong><?php echo mb_strtoupper($donnees['nom']); ?> <?php echo ucfirst($donnees['prenom']); ?></strong>
					<a href="billetterie_modification?id=<?php echo $donnees['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-wrench"></i> Modifier</a>
				</p>
      			<p><strong class="untick">Ticket 1 place</strong> - Caisse citoyenne**</p>
      			<p><strong><?php
				$date = explode(' ', $event['date']);
				$date = str_replace("/", "-", $date[0]);
				$formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,IntlDateFormatter::NONE,'Europe/Paris',IntlDateFormatter::GREGORIAN );
				$date =new DateTime($date);
				echo ucfirst($formatter->format($date));
				?></strong></p>
      			<p><?php echo $event['lieu']; ?></p>
      			<p> (<a href="a-propos">voir toutes les informations</a>)</p>
			</div>
		</td>
    	<td width="20%" align="center">
			<p><strong><a href="billetterie_imprimer?ticket=<?php echo $donnees['id']; ?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Imprimer ce ticket</a></strong></p>
			<p>&nbsp;</p>
			<p><strong><a href="billetterie_suppression?ticket=<?php echo $donnees['id']; ?>" class="btn btn-danger"><i class="fa fa-times"></i> Supprimer ce ticket</a></strong></p>
		</td>
	</tr>
<?php
}
$clcuserbillet = fetch(req('SELECT COUNT(*) AS total FROM __billetterie_attente WHERE commentaires = "'.$utilisateur['mail'].'"'));
?>
	<tr class="active">
		<td width="10%" align="center"><strong>Num&eacute;ro du ticket<span  class="red">*</span></strong></td>
		<td width="70%" align="center"><strong>&Eacute;v&eacute;nement</strong></td>
		<td width="20%" align="center">
        	<strong>Actions</strong><br />
            <a href="billetterie_imprimer?utilisateur=<?php echo $utilisateur['mail']; ?>" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Impression group&eacute;e</a>
		</td>
	</tr>
</table>
<?php
/////////////////////////////ici c'est l'attente
if($clcuserbillet['total'] >= "1"){
?>
<br />
<table width="100%" class="table table-bordered table-hover">
	<tr class="active">
		<td width="10%" align="center"><strong>Num&eacute;ro de la réservation</strong></td>
<?php
$clcuserbilletattente = fetch(req('SELECT COUNT(*) AS total FROM __billetterie_attente WHERE commentaires = "'.$utilisateur['mail'].'"'));
?>
		<td width="70%" align="center" style="font-size:24px; color:#C00;"><strong>File d'attente (<?php echo $clcuserbilletattente['total']; ?>)</strong></td>
		<td width="20%" align="center"></td>
 	</tr>
<?php 
}
$compteurtour = 1;
$whl_event_req = req('SELECT * FROM __billetterie_event ORDER BY id ASC');
while($whl_event = fetch($whl_event_req)){
	$req = req('SELECT id, parents, nom, prenom, autorise 
				FROM __billetterie_attente 
				WHERE autorise = "'.$whl_event['id'].'" AND commentaires = "'.$utilisateur['mail'].'" ORDER BY id');
	$compteurtour++;
						
	while ($donnees = fetch($req)){
		$num = adaptNum($donnees['parents']);
		$countreq = req('SELECT id 
						FROM __billetterie_attente 
						WHERE autorise = "'.$whl_event['id'].'" AND commentaires = "'.$utilisateur['mail'].'" AND id < "'.$donnees['id'].'"');
		$countdata = mysqli_num_rows($countreq);
?>
	<tr>
		<td width="10%" align="center" style="color:#C00;"><p>R&eacute;servation class&eacute;e n°<?php echo $countdata+1; ?> en attente</p></td>
		<td width="70%" align="center">
			<div class="col-lg-2"><img src="<?php echo $billetterie['eventaffwb']; ?>" /></div>
			<div class="col-lg-10">
            	<h3><strong>Tesquitoi</strong></h3>
				
                <p>Au nom de : <strong><?php echo mb_strtoupper($donnees['nom']); ?> <?php echo ucfirst($donnees['prenom']); ?></strong>
     			<a href="billetterie_modification?id=<?php echo $donnees['id']; ?>&attente" class="btn btn-sm btn-warning"><i class="fa fa-wrench"></i> Modifier</a></p>
      
      			<p><strong class="untick">Ticket 1 place</strong> - Caisse citoyenne**</p>
      			<p><strong><?php
				$date = explode(' ', $whl_event['date']);
				$date = str_replace("/", "-", $date[0]);
				$formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::FULL,IntlDateFormatter::NONE,'Europe/Paris',IntlDateFormatter::GREGORIAN );
				$date =new DateTime($date);
				echo ucfirst($formatter->format($date));
				?></strong></p>
      			<p><?php echo $whl_event['lieu']; ?></p>
      			<p>(<a href="a-propos">voir toutes les informations</a>)</p></div>
		</td>
		<td width="20%" align="center">
        	<p><strong><a href="billetterie_suppression?ticket=<?php echo $donnees['id']; ?>&attente" class="btn btn-danger"><i class="fa fa-times"></i> Supprimer ce ticket</a></strong></p>
        </td>
	</tr>
<?php
	}
}				
?>
	<tr class="active">
		<td width="10%" align="center"><strong>Num&eacute;ro de la réservation</strong></td>
		<td width="70%" align="center"><strong>&Eacute;v&eacute;nement</strong></td>
		<td width="20%" align="center"></td>
	</tr>
</table>
* pour pouvoir entrer en salle, vous devez &ecirc;tre en possession des tickets imprim&eacute;s ou des num&eacute;ros de vos tickets ainsi que d'une pi&egrave;ce d'identit&eacute;.
<br />
** Le soir du spectacle, une caisse citoyenne sera mise &agrave; votre disposition, et vous pourrez verser la somme que vous d&eacute;sirez.