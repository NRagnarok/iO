<?php
function site_parametres(){
	global $mysql, $site;

if(isset($_SERVER['HTTPS'])){
	$url = "https://";
	if($_SERVER['SERVER_PORT'] == "443"){
		$port = "";
	}else{
		$port = ":".$_SERVER['SERVER_PORT'];
	}
}else{
	$url = "http://";
	if($_SERVER['SERVER_PORT'] == "80"){
		$port = "";
	}else{
		$port = ":".$_SERVER['SERVER_PORT'];
	}
}

if(isset($_POST['serveur'])){
	if(substr($_POST['url'], -1) != "/"){$_POST['url'] = $_POST['url']."/";}
	if(substr($_POST['racine'], -1) != "/"){$_POST['racine'] = $_POST['racine']."/";}
	
$configuration = '<?php
ini_set(\'display_errors\',1);
date_default_timezone_set(\'Europe/Paris\');
if(isset($_SERVER[\'HTTPS\'])){$site[\'HTTP\'] = "https://";}else{$site[\'HTTP\'] = "http://";}
$mysql[\'serveur\'] = "'.$_POST['serveur'].'";
$mysql[\'utilisateur\'] = "'.$_POST['utilisateur'].'";
$mysql[\'motdepasse\'] = "'.$_POST['motdepasse'].'";
$mysql[\'base\'] = "'.$_POST['base'].'";
$mysql[\'prefixe\'] = "'.$_POST['prefixe'].'";
$site[\'maintenance\'] = "'.$_POST['maintenance'].'";
$site[\'nom\'] = "'.str_replace("'", "\'", $_POST['nom']).'";
$site[\'meta\'] = "'.str_replace("'", "\'", $_POST['meta']).'"; 
$site[\'description\'] = "'.str_replace("'", "\'", $_POST['description']).'";
$site[\'charset\'] = "utf-8";
$site[\'url\'] = $site[\'HTTP\'].$_SERVER[\'SERVER_NAME\'].":".$_SERVER[\'SERVER_PORT\']."'.$_POST['url'].'";
$site[\'racine\'] = "'.$_POST['racine'].'";
$site[\'apache\'] = "'.$_POST['apache'].'";
$site[\'theme\'] = "'.$_POST['theme'].'";
?>';

	if(@$fichier_configuration = fopen($site['racine'].'configuration.php',"w")){
		ftruncate($fichier_configuration, 0);
		fputs($fichier_configuration, $configuration);
		fclose($fichier_configuration);
		echo ('<div class="alert alert-success">Le fichier de configuration a été mis à jour !</div>');
	}else{
		echo ('<div class="alert alert-danger"><strong>Erreur d\'écriture</strong> Le fichier de configuration n\'a pas pu être édité !</div>');
	}
		echo('<center><a class="btn btn-primary btn-lg" href="">Retour</a></center>');
}else{
?>
<h2>Base de donnée (MySQL)</h2>
<form action="" method="post">
<div class="jumbotron">
	<div class="form-group">
    	<label>Hôte</label>
		<input type="text" class="form-control" name="serveur" value="<?php echo($mysql['serveur']);?>">
    </div>
    <div class="form-group">
    	<label>Utilisateur</label>
		<input type="text" class="form-control" name="utilisateur" value="<?php echo($mysql['utilisateur']);?>">
    </div>
    <div class="form-group">
    	<label>Mot de passe</label>
		<input type="text" class="form-control" name="motdepasse" value="<?php echo($mysql['motdepasse']);?>">
    </div>
    <div class="form-group">
    	<label>Base</label>
		<input type="text" class="form-control" name="base" value="<?php echo($mysql['base']);?>">
    </div>
    <div class="form-group">
    	<label>Préfixe des tables</label>
		<input type="text" class="form-control" name="prefixe" value="<?php echo($mysql['prefixe']);?>">
    </div>
</div>
<h2>Site</h2>
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
    <label>URL du site</label>
    <div class="form-group input-group">
        <span class="input-group-addon"><?php echo ($site['HTTP'].$_SERVER['SERVER_NAME'].$port); ?></span>
		<input type="text" class="form-control" name="url" value="<?php echo(str_replace($site['HTTP'].$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'], "", $site['url']));?>">
    </div>
    <label>Chemin absolu du site</label>
    <div class="form-group input-group">
        <span class="input-group-addon"></span>
		<input type="text" class="form-control" name="racine" value="<?php echo($site['racine']);?>">
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