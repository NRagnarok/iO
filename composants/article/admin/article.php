<?php 
function article_editeur(){
	global $site;
	
	if(isset($_POST['nouveau'])){
		$nom = res(chaine2url($_POST['nouveau']));
		$check_exist = fetch(req('SELECT COUNT(*) AS total FROM __article WHERE nom = "'.$nom.'"'));
		if($check_exist['total'] != "0"){$nom = $nom.rand();}		
		req("INSERT INTO __article (nom, titre, exec, auteur) VALUES ('".$nom."', '".res($_POST['nouveau'])."', 'non', '".$_SESSION['utilisateur']."')");
		mkdir($site['racine']."/ressources/article/".$nom."/");
		req("INSERT INTO __url (nom, type, lien) VALUES ('".res($_POST['nouveau'])."', 'article', '".$nom."')");
		$req = req("SELECT id FROM __article WHERE titre = '".res($_POST['nouveau'])."'");
		$f = fetch($req);
		$_GET['editer'] = $f['id'];
	}
	
	if(isset($_GET['editer'])){
		if(isset($_POST['editer'])){
			req('UPDATE __article SET contenu="'.res($_POST['editer']).'", titre="'.res($_POST['titre']).'" WHERE id="'.res($_GET['editer']).'"');
			echo('<div class="alert alert-success">Article enregistré !</div>');
		}
		
		$req = req("SELECT * FROM __article WHERE id = '".res($_GET['editer'])."'");
		$data = fetch($req);
		$_SESSION['SYST_imgdir'] = "/article/".$data['nom']."/";
?>
<form action="?editer=<?php echo $data['id']; ?>" method="post">
	<div class="form-group">
        <label>Titre de l'article</label>
    	<input type="text" class="form-control input-lg" name="titre" placeholder="Nouvel article" value="<?php echo $data['titre']; ?>" required>
    </div>

	<textarea name="editer" class="form-control" rows="60"><?php echo $data['contenu']; ?></textarea><br /><br />
    <center><input type="submit" class="btn btn-success" value="Enregistrer les modifications">&nbsp;<a class="btn btn-warning" href="article">Fermer</a></center>
</form>
<script>
	CKEDITOR.replace( 'editer', {
		extraPlugins: 'imageuploader,videodetector',
		filebrowserImageBrowseUrl: '../bibliotheques/3rd-party/js/ckeditor/plugins/imageuploader/imgbrowser.php'
	});
</script>

<?php
	}else{
		if(isset($_POST['nouveau'])){
			req('UPDATE __article SET contenu="'.res($_POST['nouveau']).'" WHERE id="'.res($_GET['editer']).'"');
			echo('<div class="alert alert-success">Article enregistré !</div>');
		}
		
?>
<form action="article_editeur" method="post">
	<div class="jumbotron">
   		<div class="form-group">
        	<label>Titre de l'article</label>
            <input type="text" class="form-control input-lg" name="nouveau" placeholder="Nouvel article" autofocus required>
        </div>
        <center><input type="submit" class="btn btn-success" value="Créer un article">&nbsp;<a class="btn btn-warning" href="article">Annuler</a></center>
    </div>
</form>
<?php
	}
}

function article(){
	global $site;
	unset($_SESSION['SYST_imgdir']);
	
	if(isset($_GET['supprimer'])){
		$req = req("SELECT nom FROM __article WHERE id = '".res($_GET['supprimer'])."'");
		$f = fetch($req);
    	@rmDossier($site['racine']."ressources/article/".$f['nom']."/");		
		req("DELETE FROM __url WHERE type = 'article' AND lien LIKE '".$f['nom']."%'");
		req("DELETE FROM __article WHERE id = '".res($_GET['supprimer'])."'");
		echo ('<div class="alert alert-info">Article supprimé !</div>');
	}
?>
<div id="row">
	<div id="col_lg_12">
    	<div class="table-responsive">
        	<table class="table table-bordered table-hover table-striped">
            	<thead>
                	<tr>
    					<th>ID</th>
    					<th>Titre</th>
    					<th>Param&egrave;tres</th>
    					<th>Auteur</th>
   						<th>Outils</th>
          			</tr>
          		</thead>
				<tbody>
<?php
	$req = req("SELECT * FROM __article WHERE drapeau <> 'systeme'");
		while ($data = fetch($req)) {
?>
<tr>
    <td><?php echo $data['id']; ?></td>
    <td><?php echo "<a href=\"article_editeur?editer=".$data['id']."\">".$data['titre']."</a>"; ?></td>
    <td><?php echo "PHP exec : ".$data['exec']; ?></td>
    <td><?php echo $data['auteur']; ?></td>
    <td>
    	<a class="btn btn-xs btn-primary" href="article_editeur?editer=<?php echo $data['id'];?>"><i class="fa fa-wrench"></i> Modifier</a>&nbsp;
        <a class="btn btn-xs btn-danger" href="?supprimer=<?php echo $data['id'];?>"><i class="fa fa-times"></i> Supprimer</a>
    </td>
</tr>
<?php 
		}
?>
				</tbody>
   			</table>
    		<center><a class="btn btn-success" href="article_editeur">Ajouter un article</a></center>
      	</div>
	</div>
</div>
<?php
}
?>