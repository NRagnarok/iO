<?php
function site_utilisateurs(){
	if(isset($_POST['editer'])){
		if(isset($_POST['mdp_change'])){
			if(($_POST['motdepasse'] != "") && ($_POST['motdepasse'] == $_POST['motdepasse2'])){
				
				req("UPDATE __utilisateurs SET nom = '".res(strtoupper($_POST['nom']))."', 
				prenom = '".res(ucfirst($_POST['prenom']))."', 
				mail = '".res($_POST['mail'])."', 
				grade = '".res($_POST['grade'])."',
				motdepasse = '".res(hash('sha512', $_POST['motdepasse']))."' WHERE id = '".$_POST['editer']."'");
				
				
				owncloudChangeGroupe(res($_POST['mail']), $_POST['grade']);
				owncloudChangeNom(res($_POST['mail']), res(strtoupper($_POST['nom'])).''.res(ucfirst($_POST['prenom'])));
				owncloudChangePass(res($_POST['mail']), $_POST['motdepasse']);
			
				echo ('<div class="alert alert-info">L\'utilisateur a été modifié sur le cloud !</div>');
				echo ('<div class="alert alert-success">L\'utilisateur a été modifié !</div>');
				
			
				echo ('<div class="alert alert-success">L\'utilisateur a été modifié !</div>');
			}else{
				echo ('<div class="alert alert-danger>Le mot de passe est incorrect !</div>');
			}
		}else{
			req("UPDATE __utilisateurs SET nom = '".res(strtoupper($_POST['nom']))."', 
			prenom = '".res(ucfirst($_POST['prenom']))."', 
			mail = '".res($_POST['mail'])."', 
			grade = '".res($_POST['grade'])."' WHERE id = '".$_POST['editer']."'");
			
			
			owncloudChangeGroupe(res($_POST['mail']), $_POST['grade']);
			owncloudChangeNom(res($_POST['mail']), res(strtoupper($_POST['nom'])).' '.res(ucfirst($_POST['prenom'])));
			
			echo ('<div class="alert alert-info">L\'utilisateur a été modifié sur le cloud !</div>');
			echo ('<div class="alert alert-success">L\'utilisateur a été modifié !</div>');
		}
	}
	
	if(isset($_POST['nouveau'])){
		if(($_POST['motdepasse'] != "") && ($_POST['motdepasse'] == $_POST['motdepasse2'])){
				
			req("INSERT INTO __utilisateurs (nom, prenom, mail, motdepasse, validation, grade) VALUES ('".res(strtoupper($_POST['nom']))."', '".res(ucfirst($_POST['prenom']))."', '".res($_POST['nouveau'])."', '".res(hash('sha512', $_POST['motdepasse']))."', '1', '".res($_POST['grade'])."')");
			
			owncloudAdduser(res($_POST['nouveau']), $_POST['motdepasse'], $_POST['grade']);
			
			
			//$t_hasher = new PasswordHash(8, CRYPT_BLOWFISH!=1);
			//$mdpOWNCLOUD = $t_hasher->HashPassword($_POST['motdepasse'].'LeV441Zu0CRpK8AmW9ZlGAU9hH2Q3E');
			
			
			//req("INSERT INTO oc_users (uid, displayname, password) VALUES ('".res($_POST['nouveau'])."', '".res(strtoupper($_POST['nom']))." ".res(ucfirst($_POST['prenom']))."', '".$mdpOWNCLOUD."')");
			//req("INSERT INTO oc_group_user (gid, uid) VALUES ('".res($_POST['grade'])."', '".res($_POST['nouveau'])."')");
			
			echo ('<div class="alert alert-info">L\'utilisateur a été ajouté au cloud !</div>');
			echo ('<div class="alert alert-success">L\'utilisateur a été ajouté !</div>');
		}else{
			echo ('<div class="alert alert-danger>Le mot de passe est incorrect !</div>');
		}
	}
	
	
	if(isset($_GET['activer'])){
		req("UPDATE __utilisateurs SET validation = '1' WHERE id = '".$_GET['activer']."'");
		req("DELETE FROM __userverif WHERE iduser = '".$_GET['activer']."'");
		echo ('<div class="alert alert-success">Le compte a été activé !</div>');
	}
	
	if(isset($_GET['supprimer'])){
		
		
		$req = req("SELECT mail FROM __utilisateurs WHERE id = '".$_GET['supprimer']."'");
        $d = fetch($req);
		owncloudRemoveuser($d['mail']);
		
		req("DELETE FROM __utilisateurs WHERE id = '".$_GET['supprimer']."'");
		
		echo ('<div class="alert alert-info">L\'utilisateur a été supprimé au cloud !</div>');
		echo ('<div class="alert alert-success">L\'utilisateur a été supprimé !</div>');
	}
?>

<div id="row">
	<div id="col_lg_12">
    	<div class="table-responsive">
        	<table class="table table-bordered table-hover table-striped">
            	<thead>
                	<tr>
                    	<th>ID</th>
                        <th>NOM Prénom</th>
                        <th>Email</th>
                        <th>Compte validé</th>
                        <th>Grade</th>
                        <th>Outils</th>
          			</tr>
               	</thead>
				<tbody>
                	<?php $req = req("SELECT * FROM __utilisateurs");?>
                    <?php while ($data = fetch($req)){?>
                	<tr>
                    	<td><?php echo $data['id'];?></td>
                        <td><?php echo strtoupper($data['nom']);?> <?php echo ucfirst($data['prenom']);?></td>
                        <td><?php echo $data['mail'];?></td>
                        <td>
							<?php if($data['validation'] == "1"){?>
                            	<i class="fa fa-check fa-lg"></i>								
							<?php }else{?> 
                        		<i class="fa fa-times fa-lg"></i>&nbsp;
                                <a class="btn btn-xs btn-warning" href="?activer=<?php echo $data['id'];?>"><i class="fa fa-check-circle"></i> Activer le compte</a>
							<?php }?>
                        </td>
                        <td><?php echo $data['grade'];?></td>
                        <td>
                        	<a class="btn btn-xs btn-primary" href="site_utilisateur?editer=<?php echo $data['id'];?>"><i class="fa fa-wrench"></i> Modifier</a>&nbsp;
                            <a class="btn btn-xs btn-danger" href="?supprimer=<?php echo $data['id'];?>"><i class="fa fa-times"></i> Supprimer</a>
                       	</td>
                  	</tr>
                    <?php }?>
              	</tbody>
          	</table>
            <center><a class="btn btn-success" href="site_utilisateur">Ajouter un utilisateur</a></center>
      	</div>
   	</div>
</div>
<?php
}

function site_utilisateur(){
	if(isset($_GET['editer'])){?>
    	<?php $req = req("SELECT * FROM __utilisateurs WHERE id = '".$_GET['editer']."'");?>
        <?php $data = fetch($req);?>
    	<form action="site_utilisateurs" method="post">
        	<div class="jumbotron">
            	<input type="hidden" name="editer" value="<?php echo $data['id'];?>">
                <div class="form-group"><label>ID</label><input type="text" class="form-control" value="<?php echo $data['id'];?>" disabled></div>
                <div class="form-group"><label>Nom</label><input type="text" class="form-control" name="nom" placeholder="Nom" value="<?php echo $data['nom'];?>" required></div>
                <div class="form-group"><label>Prénom</label><input type="text" class="form-control" name="prenom" placeholder="Prénom" value="<?php echo $data['prenom'];?>" required></div>
                <div class="form-group">
                	<label>Adresse Email</label>
                    <input type="hidden" name="mail" value="<?php echo $data['mail'];?>">
                    <input type="email" class="form-control" value="<?php echo $data['mail'];?>" disabled>
              	</div>
                <label>Mot de passe</label>
                <div class="form-group input-group">
                	<span class="input-group-addon"><label style="font-weight:normal;"><input type="checkbox" value="" name="mdp_change" id="check"> Changer le mot de passe</label></span>
                   	<input type="password" class="form-control" name="motdepasse" id="motdepasse" placeholder="Nouveau mot de passe">
                    <input type="password" class="form-control" name="motdepasse2" id="motdepasse2" placeholder="Confirmation du nouveau mot de passe">
             	</div>
                
                <div class="form-group">
                	<label>Grade</label>
                    <select class="form-control" name="grade">
                    	<option value=""<?php if($data['grade'] == ""){echo(' selected="selected"');}?>>Utilisateur</option>
                        <option value="Artistes"<?php if($data['grade'] == "Artistes"){echo(' selected="selected"');}?>>Artistes</option>
                        <option value="Bénévoles"<?php if($data['grade'] == "Bénévoles"){echo(' selected="selected"');}?>>Bénévoles</option>
                        <option value="Conseil d'Administration"<?php if($data['grade'] == "Conseil d'Administration"){echo(' selected="selected"');}?>>Conseil d'Administration</option>
                        <option value="admin"<?php if($data['grade'] == "admin"){echo(' selected="selected"');}?>>Administrateur</option>
                  	</select>
             	</div>
                
                <center><input type="submit" class="btn btn-success" value="Modifier l'utilisateur">&nbsp;<a class="btn btn-warning" href="site_utilisateurs">Annuler</a></center>
          	</div>
     	</form> 
        <script>
				$('#motdepasse').prop('disabled', true);
				$('#motdepasse2').prop('disabled', true);
				
$('#check').change(function(){
    if ($('#check').is(':checked') == true){
      $('#motdepasse').prop('disabled', false);
	  $('#motdepasse2').prop('disabled', false);
   } else {
     $('#motdepasse').prop('disabled', true);
	 $('#motdepasse2').prop('disabled', true);
   }
});
		</script>
	<?php }else{?>
		<form action="site_utilisateurs" method="post">
        	<div class="jumbotron">
                <div class="form-group"><label>Nom</label><input type="text" class="form-control" name="nom" placeholder="Nom" required></div>
                <div class="form-group"><label>Prénom</label><input type="text" class="form-control" name="prenom" placeholder="Prénom" required></div>
                <div class="form-group">
                	<label>Adresse Email</label>
                    <input type="email" class="form-control" name="nouveau" placeholder="mail@adres.se" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
              	</div>
                <label>Mot de passe</label>
                <div class="form-group input-group">
                	<span class="input-group-addon"></span>
                   	<input type="password" class="form-control" name="motdepasse" id="motdepasse" placeholder="Mot de passe">
                    <input type="password" class="form-control" name="motdepasse2" id="motdepasse2" placeholder="Confirmation du mot de passe">
             	</div>
                
                <div class="form-group">
                	<label>Grade</label>
                    <select class="form-control" name="grade">
                    	<option value="">Utilisateur</option>
                        <option value="Artistes">Artistes</option>
                        <option value="Bénévoles">Bénévoles</option>
                        <option value="Conseil d'Administration">Conseil d'Administration</option>
                        <option value="admin">Administrateur</option>
                  	</select>
             	</div>
                
                <center><input type="submit" class="btn btn-success" value="Ajouter un utilisateur">&nbsp;<a class="btn btn-warning" href="site_utilisateurs">Annuler</a></center>
          	</div>
     	</form> 
<?php 	}
}
?>