<?php
function contact(){
	if(isset($_GET['editer'])){
		$req = req("SELECT * FROM __contact WHERE id = '".$_GET['editer']."'");
		$data = fetch($req);
		echo ('<form action="contact" method="post"><div class="jumbotron">');
		echo ('<input type="hidden" name="id" value="'.$data['id'].'">');
		echo ('<div class="form-group"><label>Nom du contact</label>');
		echo('<input type="text" class="form-control" name="nom" placeholder="Nom prénom, statut" value="'.$data['nom'].'" required></div>');
		echo ('<div class="form-group"><label>Adresse Email</label>');
		echo('<input type="email" class="form-control" name="editer" placeholder="mail@adres.se"');
		echo(' pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="'.$data['destinataire'].'" required></div>');
		echo ('<center><input type="submit" class="btn btn-success" value="Modifier le contact">&nbsp;<a class="btn btn-warning" href="contact">Annuler</a></center>');
		echo ('</div></form>');
	}else if(isset($_GET['nouveau'])){
		echo ('<form action="contact" method="post"><div class="jumbotron">');
		echo ('<div class="form-group"><label>Nom du contact</label><input type="text" class="form-control" name="nom" placeholder="Nom prénom, statut" required></div>');
		echo ('<div class="form-group"><label>Adresse Email</label>');
		echo('<input type="email" class="form-control" name="nouveau" placeholder="mail@adres.se" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required></div>');
		echo ('<center><input type="submit" class="btn btn-success" value="Ajouter un contact">&nbsp;<a class="btn btn-warning" href="contact">Annuler</a></center>');
		echo ('</div></form>'); 
	}else{
		if(isset($_POST['nouveau'])){
			req("INSERT INTO __contact (nom, destinataire) VALUES ('".res($_POST['nom'])."', '".res($_POST['nouveau'])."')");
			echo ('<div class="alert alert-success">Le contact a été ajouté !</div>');
		}else if(isset($_POST['editer'])){
			req("UPDATE __contact SET nom = '".res($_POST['nom'])."', destinataire = '".res($_POST['editer'])."' WHERE id = '".$_POST['id']."'");
			echo ('<div class="alert alert-success">Le contact a été modifié !</div>');
		}else if(isset($_GET['supprimer'])){
			req("DELETE FROM __contact WHERE id = '".$_GET['supprimer']."'");
			echo ('<div class="alert alert-info">Le contact a été supprimé !</div>');
		}
		
		$req = req("SELECT * FROM __contact");
		echo ('<table class="table table-bordered table-hover table-striped"><thead><tr><th>Nom du contact</th><th>Adresse Email</th><th>Outils</th></tr></thead><tbody>');
		while ($data = fetch($req)){
			echo ('<tr><td>'.$data['nom'].'</td><td>'.$data['destinataire'].'</td><td><a class="btn btn-xs btn-primary" href="?editer='.$data['id'].'">');
			echo ('<i class="fa fa-wrench"></i> Modifier</a>&nbsp;<a class="btn btn-xs btn-danger" href="?supprimer='.$data['id'].'"><i class="fa fa-times"></i> Supprimer</a></td></tr>');
		}
		echo ('</tbody></table><br /><center><a class="btn btn-lg btn-success" href="?nouveau">Ajouter un contact</a></center>');
	}
}
?>                              