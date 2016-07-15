<?php
function galerie_photo_editeur(){
	global $site;
	if(isset($_GET['editer'])){
		$req = req("SELECT * FROM __galerie_images WHERE id = '".res($_GET['editer'])."'");
		$d = fetch($req);
	?>
 <form action="galerie_editeur" method="post">
	<div class="jumbotron">
    	<center><img src="<?php echo siteURL().'/ressources/galerie/'.$d['galerie'].'/thumb/'.$d['image']; ?>"></center>
   		<div class="form-group">
        	<label>Titre de l'image</label>
            <input type="hidden" name="id" value="<?php echo $d['id'];?>">
            <input type="text" class="form-control input-lg" name="editer_image" placeholder="Nouveau nom" value="<?php echo $d['titre'];?>" autofocus required>
        </div>
        <center><input type="submit" class="btn btn-success" value="Modifier l'image">&nbsp;<a class="btn btn-warning" href="galerie_editeur?editer=<?php echo $d['galerie'];?>">Annuler</a></center>
    </div>
</form>
    
    
    
    
    
    
    <?php
	}
	if(isset($_GET['galerie'])){

$_SESSION['UPLOADFolder'] = $site['racine']."/ressources/galerie/".$_GET['galerie']."/";
?>
<style>
.fileinput-button {
  position: relative;
  overflow: hidden;
  display: inline-block;
}
.fileinput-button input {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  opacity: 0;
  -ms-filter: 'alpha(opacity=0)';
  font-size: 200px !important;
  direction: ltr;
  cursor: pointer;
}

/* Fixes for IE < 8 */
@media screen\9 {
  .fileinput-button input {
    filter: alpha(opacity=0);
    font-size: 100%;
    height: 100%;
  }
}
</style>



    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Ajouter des fichiers</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
    <br>




<script src="<?php echo siteURL();?>/composants/galerie/admin/js/jquery.ui.widget.js"></script>

<script src="<?php echo siteURL();?>/composants/galerie/admin/js/jquery.iframe-transport.js"></script>

<script src="<?php echo siteURL();?>/composants/galerie/admin/js/jquery.fileupload.js"></script>

<script>
function ordre(nomdeFichier){
var req = new XMLHttpRequest();
req.open('GET', 'galerie_photo_editeur?envoi=<?php echo $_GET['galerie'];?>&fichier='+nomdeFichier, false); 
req.send(null);
}

/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '<?php echo siteURL();?>/composants/galerie/admin/upload/';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
				ordre(file.name);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>   
    <center><a class="btn btn-default" href="galerie">Retour</a></center>
	
	<?php
	}
	if(isset($_GET['envoi'])){
		req("INSERT INTO __galerie_images (galerie, titre, image, description) VALUES ('".res($_GET['envoi'])."', '', '".res($_GET['fichier'])."', '')");
	}
}
function galerie_editeur(){
	global $site;
	
	if(isset($_POST['nouveau'])){	
		req("INSERT INTO __galerie (titre) VALUES ('".res($_POST['nouveau'])."')");
		$req = req("SELECT id FROM __galerie WHERE titre = '".res($_POST['nouveau'])."'");
		$d = fetch($req);
		mkdir($site['racine']."/ressources/galerie/".$d['id']."/");
		mkdir($site['racine']."/ressources/galerie/".$d['id']."/thumb/");
		$_GET['editer'] = $d['id'];
		echo('<div class="alert alert-success">La galerie a été crée !</div>');
	}
	if(isset($_POST['editer_image'])){	
		req('UPDATE __galerie_images SET titre="'.res($_POST['editer_image']).'" WHERE id="'.res($_POST['id']).'"');
		$req = req("SELECT galerie FROM __galerie_images WHERE id = '".res($_POST['id'])."'");
		$d = fetch($req);
		$_GET['editer'] = $d['galerie'];
		echo('<div class="alert alert-success">L\'image a été éditée !</div>');
	}
	if(isset($_GET['supprimer'])){	
		$req = req("SELECT * FROM __galerie_images WHERE id = '".res($_GET['supprimer'])."'");
		$d = fetch($req);
		req("DELETE FROM __galerie_images WHERE id = '".res($_GET['supprimer'])."'");
		unlink($site['racine']."/ressources/galerie/".$d['galerie']."/".$d['image']);
		unlink($site['racine']."/ressources/galerie/".$d['galerie']."/thumb/".$d['image']);
		$_GET['editer'] = $d['galerie'];
		echo('<div class="alert alert-info">L\'image a été supprimée !</div>');
	}
	
	if(isset($_GET['editer'])){
?>
<div id="row">
	<div id="col_lg_12">
    	<div class="table-responsive">
        	<table class="table table-bordered table-hover table-striped">
            	<thead>
                	<tr>
    					<th>Image</th>
    					<th>Titre</th>
   						<th>Outils</th>
          			</tr>
          		</thead>
				<tbody>
<?php
	$req = req("SELECT * FROM __galerie_images WHERE galerie = '".res($_GET['editer'])."'");
		while ($d = fetch($req)) {
?>
<tr>
    <td><img src="<?php echo siteURL().'/ressources/galerie/'.$d['galerie'].'/thumb/'.$d['image']; ?>"></td>
    <td><?php echo $d['titre']; ?></td>
    <td>
    	<a class="btn btn-xs btn-primary" href="galerie_photo_editeur?editer=<?php echo $d['id'];?>"><i class="fa fa-wrench"></i> Modifier</a>&nbsp;
        <a class="btn btn-xs btn-danger" href="galerie_editeur?supprimer=<?php echo $d['id'];?>"><i class="fa fa-times"></i> Supprimer</a>
    </td>
</tr>
<?php 
		}
?>
				</tbody>
   			</table>
    		<center><a class="btn btn-success" href="galerie_photo_editeur?galerie=<?php echo $_GET['editer'];?>">Ajouter des images</a> <a class="btn btn-default" href="galerie">Retour</a></center>
      	</div>
	</div>
</div>




























<?php
		
	}else{		
?>
<form action="galerie_editeur" method="post">
	<div class="jumbotron">
   		<div class="form-group">
        	<label>Titre de la galerie</label>
            <input type="text" class="form-control input-lg" name="nouveau" placeholder="Nouvelle galerie" autofocus required>
        </div>
        <center><input type="submit" class="btn btn-success" value="Créer une galerie">&nbsp;<a class="btn btn-warning" href="galerie">Annuler</a></center>
    </div>
</form>
<?php
	}
}
function galerie(){
	global $site;	
	if(isset($_GET['supprimer'])){
    	@rmDossier($site['racine']."ressources/galerie/".$_GET['supprimer']."/");
		$req = req("SELECT id FROM __galerie_images WHERE galerie = '".$_GET['supprimer']."'");
			while($d = fetch($req)) {
				req("DELETE FROM __galerie_images WHERE id = '".$d['id']."'");
			}
		req("DELETE FROM __galerie WHERE id = '".res($_GET['supprimer'])."'");
		echo ('<div class="alert alert-info">Galerie supprimée !</div>');
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
   						<th>Outils</th>
          			</tr>
          		</thead>
				<tbody>
<?php
	$req = req("SELECT * FROM __galerie");
		while ($d = fetch($req)) {
?>
<tr>
    <td>{[galerie:<?php echo $d['id']; ?>]}</td>
    <td><?php echo $d['titre']; ?></td>
    <td>
    	<a class="btn btn-xs btn-primary" href="galerie_editeur?editer=<?php echo $d['id'];?>"><i class="fa fa-wrench"></i> Modifier</a>&nbsp;
        <a class="btn btn-xs btn-danger" href="?supprimer=<?php echo $d['id'];?>"><i class="fa fa-times"></i> Supprimer</a>
    </td>
</tr>
<?php 
		}
?>
				</tbody>
   			</table>
    		<center><a class="btn btn-success" href="galerie_editeur">Ajouter une galerie</a></center>
      	</div>
	</div>
</div>
<?php
}
?>