<?php
function site_parametres(){
	global $mysql, $site;
	if(isset($_POST['nom'])){
		miseajourConfiguration("site", "maintenance", $_POST['maintenance']);
		miseajourConfiguration("site", "nom", $_POST['nom']);
		miseajourConfiguration("site", "meta", $_POST['meta']);
		miseajourConfiguration("site", "description", $_POST['description']);
		miseajourConfiguration("site", "apache", $_POST['apache']);
		miseajourConfiguration("site", "theme", $_POST['theme']);	
		echo ('<div class="alert alert-success">Le fichier de configuration a été mis à jour !</div>');
		echo('<center><a class="btn btn-primary btn-lg" href="site_parametres">Retour</a></center>');
	}else{
?>
<form action="" method="post">
<h2>Paramètres</h2>
<div class="jumbotron">
	<div class="form-group">
    	<label>Mode maintenance du site</label>
        <select class="form-control" name="maintenance">
        	<option value="oui" <?php if($site['maintenance'] == "oui"){echo('selected');}?>>oui</option>
        	<option value="non" <?php if($site['maintenance'] == "non"){echo('selected');}?>>non</option>
        </select>
    </div>
    <div class="form-group">
    	<label>Nom du site</label>
		<input type="text" class="form-control" name="nom" value="<?php echo($site['nom']);?>">
    </div>
    <div class="form-group">
    	<label>Mots clefs du site</label>
		<input type="text" class="form-control" name="meta" data-role="tagsinput" value="<?php echo($site['meta']);?>">
    </div>
    <div class="form-group">
    	<label>Description du site</label>
		<input type="text" class="form-control" name="description" value="<?php echo($site['description']);?>">
    </div>
    <div class="form-group">
    	<label>Mode des liens du site</label>
        <select class="form-control" name="apache">
        	<option value="htaccess" <?php if($site['apache'] == "htaccess"){echo('selected');}?>>htaccess</option>
        	<option value="direct" <?php if($site['apache'] == "direct"){echo('selected');}?>>direct</option>
            <option value="php" <?php if($site['apache'] == "php"){echo('selected');}?>>php</option>
        </select>
    </div>
    <div class="form-group">
    	<label>Thème</label>
		<input type="text" class="form-control" name="theme" value="<?php echo($site['theme']);?>">
    </div>
</div>
<center><input type="submit" class="btn btn-warning" value="Sauvegarder les paramètres"></center>
</form>
<?php
	}
}
?>