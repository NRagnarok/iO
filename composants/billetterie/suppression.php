<?php
if(isset($_POST['ticket'])){
	if(isset($_POST['attente'])){
		$table = "__billetterie_attente";
	}else{
		$table = "__billetterie_reservation";
	}

	$donnees = fetch(req('SELECT COUNT(*) AS total FROM '.$table.' WHERE commentaires = "'.$_SESSION['utilisateur'].'" AND id = "'.$_POST['ticket'].'"'));

	if($donnees['total'] != "1"){
		if(isset($_POST['attente'])){
			redirection('reservations?errsuppression='.$_POST['ticket'].'&attente');
			exit();
		}else{
			redirection('reservations?errsuppression='.$_POST['ticket']);
			exit();
		}
	}else{
		req('DELETE FROM '.$table.' WHERE id = "'.$_POST['ticket'].'" AND commentaires = "'.$_SESSION['utilisateur'].'"'); 
		redirection('reservations?succsuppression='.$_POST['ticket']); 
		exit();
	}
}
?>
<center>
	<b>&Ecirc;tes-vous s&ucirc;r de vouloir supprimer votre ticket num&eacute;ro #<?php echo($_GET['ticket']);?> ?<br />
		<form action="suppression-reservation" method="post">
    		<input name="ticket" type="hidden" value="<?php echo($_GET['ticket']);?>" />
<?php if(isset($_GET['attente'])){?>
			<input name="attente" type="hidden" value="1" />
<?php }?>
			<input name="" type="submit" value="Je veux supprimer ce ticket !" class="btn btn-danger"/>
        	&nbsp;&nbsp;&nbsp;<a href="reservations" class="btn btn-success">Annuler...</a>
		</form>
    </b>
</center>