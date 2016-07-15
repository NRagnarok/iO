<?php
if(!isset($_GET['id'])){
	if(!isset($_POST['id'])){
		redirection('billetterie_reservations');
		exit();
	}
}
if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['id'])){
	$nom = mb_strtoupper($_POST['nom']);
	$prenom = ucfirst($_POST['prenom']);
	
	if(isset($_POST['attente'])){
		$table = "__billetterie_attente";
	}else{
		$table = "__billetterie_reservation";
	}
	
	$req = req('SELECT id, nom, prenom, commentaires FROM '.$table.' WHERE id = "'.$_POST['id'].'" ORDER BY id');

	while ($donnees = fetch($req)){
		if($donnees['commentaires'] == $_SESSION['utilisateur']){
			$update = req('UPDATE '.$table.' SET nom="'.strtoupper($_POST['nom']).'", prenom="'.ucfirst($_POST['prenom']).'" WHERE id="'.$_POST['id'].'"');
			
			if(isset($_POST['attente'])){
				redirection('billetterie_reservations?cna='.$_POST['id']);
				exit();
			}else{
				redirection('billetterie_reservations?cn='.$_POST['id']);
				exit();
			}
		}else{
			redirection('billetterie_reservations');
			exit();
		}
	}
}

if(isset($_GET['attente'])){
	$table = "__billetterie_attente";
}else{
	$table = "__billetterie_reservation";
}
?>
<a href="javascript:history.go(-1)" class="btn btn-default"><i class="fa fa-chevron-left"></i> Retour</a>
<?php
$clcuserbillet = fetch(req('SELECT COUNT(*) AS total FROM '.$table.' WHERE id = "'.$_GET['id'].'"'));
					
$req = req('SELECT id, nom, prenom, commentaires FROM '.$table.' WHERE id = "'.$_GET['id'].'" ORDER BY id');

while ($donnees = fetch($req)){
	if($donnees['commentaires'] != $_SESSION['utilisateur']){
		alerte('Vous n\'avez pas la permission de modifier cette r&eacute;servation !', 'danger');	
		redirection('billetterie_reservations');
		exit();
	}else{
		if (strlen($donnees['id']) == 1){
			$num = "000".$donnees['id'];
		}else if (strlen($donnees['id']) == 2){
			$num = "00".$donnees['id'];
		}else if (strlen($donnees['id']) == 3){
			$num = "0".$donnees['id'];
		}else{
			$num = $donnees['id'];
		}
?>
<center>
	<strong>Billet #<?php echo $num; ?></strong></p>
    <form id="form1" name="form1" method="post" action="billetterie_modification">
    	<p><label for="nom">Nom&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text" name="nom" value="<?php echo mb_strtoupper($donnees['nom']); ?>"  class="form-control"/></p>
        <p><label for="prenom">Pr&eacute;nom</label> <input type="text" name="prenom"  value="<?php echo ucfirst($donnees['prenom']); ?>"  class="form-control"/></p>
        <p>
        	<input name="id" type="hidden" value="<?php echo $donnees['id']; ?>" />
			<?php if(isset($_GET['attente'])){?><input name="attente" type="hidden" value="1" /><?php }?>
        	<input type="submit" name="button" id="button" value="Modifier" class="btn btn-lg btn-warning"/>
		</p>
	</form>
</center>
<?php
	}
}
?>