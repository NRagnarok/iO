<?php
require($site['racine'].'composants/billetterie/cron.php');
function billetterie_evenement(){
	if(isset($_GET['editer'])){
		$req = req("SELECT * FROM __billetterie_event WHERE id='".res($_GET['editer'])."'");
		$d = fetch($req);
?>
    	<form action="billetterie_evenements" method="post">
        	<div class="jumbotron">
            	<input type="hidden" name="editer" value="<?php echo $d['id'];?>">
                <div class="form-group"><label>ID</label><input type="text" class="form-control" value="<?php echo $d['id'];?>" disabled></div>
                <div class="form-group"><label>Lieu</label><input type="text" class="form-control" name="lieu" placeholder="2 rue Mirabeau" value="<?php echo $d['lieu'];?>" required></div>
                <label>Date</label>
                <div class="input-group date">
                    <span class="input-group-addon"><span class="fa fa-calendar-o"></span></span>
                    <input type="text" class="form-control" name="date" id="datepicker" placeholder="14/02/2028 20:50" value="<?php echo $d['date'];?>" required>
                </div>
                <div class="form-group"><label>Places maximales</label><input type="text" class="form-control" name="pmax" placeholder="145" value="<?php echo $d['pmax'];?>" required></div>
                
                <center><input type="submit" class="btn btn-success" value="Modifier l'événement">&nbsp;<a class="btn btn-warning" href="billetterie_evenements">Annuler</a></center>
          	</div>
     	</form>
        <script>
		    $(function () {
                $('#datepicker').datetimepicker({
                    locale: 'fr'
                });
            });
		</script>
<?php
	}else{
?>
    	<form action="billetterie_evenements" method="post">
        	<div class="jumbotron">
                <div class="form-group"><label>Lieu</label><input type="text" class="form-control" name="nouveau" placeholder="2 rue Mirabeau" required></div>
                <label>Date</label>
                <div class="input-group date">
                    <span class="input-group-addon"><span class="fa fa-calendar-o"></span></span>
                    <input type="text" class="form-control" name="date" id="datepicker" placeholder="14/02/2028 20:50" required>
                </div>
                <div class="form-group"><label>Places maximales</label><input type="text" class="form-control" name="pmax" placeholder="145" required></div>
                
                <center><input type="submit" class="btn btn-success" value="Ajouter un événement">&nbsp;<a class="btn btn-warning" href="billetterie_evenements">Annuler</a></center>
          	</div>
     	</form>
        <script>
		    $(function () {
                $('#datepicker').datetimepicker({
                    locale: 'fr'
                });
            });
		</script>
<?php
	}
}

function billetterie(){
	if(isset($_POST['limituserreserv'])){
		$req = req("SELECT * FROM __billetterie_configuration");
    	while ($f = fetch($req)){
			req('UPDATE __billetterie_configuration SET valeur="'.res($_POST[$f['variable']]).'" WHERE variable="'.$f['variable'].'"');
		}
		echo('<div class="alert alert-success">Paramètres sauvegardés !</div>');
	}
	$req = req("SELECT * FROM __billetterie_configuration");
    while ($f = fetch($req)){
		$d[$f['variable']] = $f['valeur'];
	}
	
	if(isset($_POST['editer'])){
		req('UPDATE __billetterie_event SET 
		lieu="'.res($_POST['lieu']).'", 
		date="'.res($_POST['date']).'", 
		pmax="'.res($_POST['pmax']).'" WHERE id="'.res($_POST['editer']).'"');
		echo('<div class="alert alert-success">Événement mis à jour !</div>');
	}
	
	if(isset($_GET['vider'])){
		$req = req("SELECT id FROM __billetterie_reservation WHERE autorise='".res($_GET['vider'])."'");
    	while ($f = fetch($req)){
			req('DELETE FROM __billetterie_reservation WHERE id="'.$f['id'].'"');
		}
		$req = req("SELECT id FROM __billetterie_attente WHERE autorise='".res($_GET['vider'])."'");
    	while ($f = fetch($req)){
			req('DELETE FROM __billetterie_attente WHERE id="'.$f['id'].'"');
		}
		echo('<div class="alert alert-info">Les réservations ont été vidées !</div>');
	}
	
	if(isset($_GET['supprimer'])){
		$req = req("SELECT id FROM __billetterie_reservation WHERE autorise='".res($_GET['supprimer'])."'");
    	while ($f = fetch($req)){
			req('DELETE FROM __billetterie_reservation WHERE id="'.$f['id'].'"');
		}
		$req = req("SELECT id FROM __billetterie_attente WHERE autorise='".res($_GET['supprimer'])."'");
    	while ($f = fetch($req)){
			req('DELETE FROM __billetterie_attente WHERE id="'.$f['id'].'"');
		}
		req('DELETE FROM __billetterie_event WHERE id="'.res($_GET['supprimer']).'"');
		echo('<div class="alert alert-info">L\'événement a été supprimé !</div>');
	}
	
	if(isset($_POST['nouveau'])){
		req("INSERT INTO __billetterie_event (lieu, date, pmax) VALUES ('".res($_POST['nouveau'])."', '".res($_POST['date'])."', '".res($_POST['pmax'])."')");
			echo ('<div class="alert alert-success">L\'événement a été ajouté !</div>');
	}
?>
<h2>Liste des événements</h2>
<div id="row">
	<div id="col_lg_12">
    	<div class="table-responsive">
        	<table class="table table-bordered table-hover table-striped">
            	<thead>
                	<tr>
                    	<th>ID</th>
                        <th>Lieu</th>
                        <th>Date</th>
                        <th>Nombre de places</th>
                        <th>Outils</th>
          			</tr>
               	</thead>
				<tbody>
                	<?php $req = req("SELECT * FROM __billetterie_event ORDER BY id ASC");?>
                    <?php while ($data = fetch($req)){
							$donnees = fetch(req('SELECT COUNT(*) AS total FROM __billetterie_reservation WHERE autorise = "'.$data['id'].'"'));
							$donnees2 = fetch(req('SELECT COUNT(*) AS total FROM __billetterie_attente WHERE autorise = "'.$data['id'].'"'));
							$plcrestant = $data['pmax']-$donnees['total'];
							if($plcrestant <= 0){
								$couleur = "ff0000";
							}else if($plcrestant <= $data['pmax']*10/100){
										$couleur = "ff6c00";
							}else if($plcrestant <= $data['pmax']*50/100){
										$couleur = "067b00";
							}else if($plcrestant <= $data['pmax']*75/100){
										$couleur = "0ade00";
							}else if($plcrestant <= $data['pmax']){
										$couleur = "004d8e";
							}
							if($donnees2['total'] != 0){
								if($donnees2['total'] == 0){
									$attente_txt = '<span class="label label-warning">Il y a '.$donnees2['total'].' réservation en attente</span>';
								}else{
									$attente_txt = '<span class="label label-warning">Il y a '.$donnees2['total'].' réservations en attente</span>';
								}
							}else{
								$attente_txt = '';
							}
						?>
                	<tr>
                    	<td><?php echo $data['id'];?></td>
                        <td><?php echo $data['lieu'];?></td>
                        <td><?php echo $data['date'];?></td>
                        <td>
                        	<span class="badge">
                            	<span style="color:#<?php echo $couleur;?>;"><?php echo $donnees['total'];?></span>/<?php echo $data['pmax'];?>
                            </span>
							<?php echo ' '.$attente_txt;?></td>
                        <td>
                        	<a class="btn btn-xs btn-primary" href="billetterie_evenement?editer=<?php echo $data['id'];?>"><i class="fa fa-wrench"></i> Modifier</a>&nbsp;
                            <a class="btn btn-xs btn-warning" href="?vider=<?php echo $data['id'];?>"><i class="fa fa-refresh"></i> Vider</a>&nbsp;
                            <a class="btn btn-xs btn-danger" href="?supprimer=<?php echo $data['id'];?>"><i class="fa fa-times"></i> Supprimer</a>
                       	</td>
                  	</tr>
                    <?php }?>
              	</tbody>
          	</table>
            <center><a class="btn btn-success" href="billetterie_evenement">Ajouter un événement</a></center>
      	</div>
   	</div>
</div>
<form action="?page=billetterie" method="post">
	<h2>Paramètres généraux</h2>
	<div class="jumbotron">
		<div class="form-group">
			<label>Activation la limitation de r&eacute;servations par utilisateur</label>
    			<select name="limituserreserv" class="form-control">
                	<option value="oui">oui</option>
                    <option value="non"<?php if($d['limituserreserv'] == "non"){echo(' selected="selected"');}?>>non</option>
    			</select>
      	</div>
        <div class="form-group">
    		<label>Nombre de r&eacute;servations maximum par utilisateur</label>
            <input type="text" class="form-control" size="40" name="reservationmaxperuser" value="<?php echo $d['reservationmaxperuser']; ?>">
        </div>
    	<div class="form-group">
    		<label>Rendre disponibles les r&eacute;servations</label>
    		<select name="ouvert" class="form-control"><option value="oui">oui</option><option value="non"<?php if($d['ouvert'] == "non"){echo(' selected="selected"');}?>>non</option></select>
    	</div>
    	<div class="form-group">
        	<label>Alerter les utilisateurs de la fermeture des r&eacute;servations</label>
    		<select name="alertefermeture" class="form-control">
            	<option value="oui">oui</option>
                <option value="non"<?php if($d['alertefermeture'] == "non"){echo(' selected="selected"');}?>>non</option>
            </select>
      	</div>
		<div class="form-group">
        	<label>Message d'alerte</label>
			<textarea name="alertefermeturemsg" class="form-control"><?php echo $d['alertefermeturemsg']; ?></textarea>
       	</div>
        <div class="form-group">
			<label>Image affich&eacute;e sur les billets (110*190px)</label>
			<input type="text" class="form-control" size="40" name="eventaff" value="<?php echo $d['eventaff']; ?>">
       	</div>
		<div class="form-group">
        	<label>Image affich&eacute;e sur les billets (version noir et blanc 110*190px)</label>
			<input type="text" class="form-control" size="40" name="eventaffwb" value="<?php echo $d['eventaffwb']; ?>">
       	</div>
		<center><input type="submit" class="btn btn-success" value="Enregistrer les modifications"></center>
	</div>
</form>
<?php }?>