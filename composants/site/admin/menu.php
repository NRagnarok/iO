<?php
function site_menu(){
	if(isset($_POST['renommer'])){
		req("UPDATE __url SET nom = '".res($_POST['nom'])."' WHERE id = '".res($_POST['renommer'])."'");
		echo ('<div class="alert alert-success">Le lien a été renommé !</div>');
	}
	if(isset($_POST['nouveau'])){
		req("INSERT INTO __url (nom, type, lien, menu, principal, ordre) VALUES ('".res($_POST['nouveau'])."', 'url', '".res($_POST['lien'])."', '0', '', '0')");
		echo ('<div class="alert alert-success">Le lien a été ajouté !</div>');
	}
	if(isset($_GET['supprimer_url'])){
		req("DELETE FROM __url WHERE type = 'url' AND id = '".res($_GET['supprimer_url'])."'");
		echo ('<div class="alert alert-warning">Le lien a été supprimé !</div>');
	}
	if(isset($_GET['supprimer'])){
		req("UPDATE __url SET menu = '0' WHERE id = '".$_GET['supprimer']."'");
		echo ('<div class="alert alert-info">Le lien a été supprimé du menu !</div>');
	}
	if(isset($_GET['ajouter'])){
		req("UPDATE __url SET menu = '1', ordre = '999' WHERE id = '".$_GET['ajouter']."'");
		echo ('<div class="alert alert-success">Le lien a été ajouté au menu !</div>');
	}
	if(isset($_POST['ordre'])){
		if($_POST['ordre'] != ""){
			$ordre = str_replace(" ", "", strtr($_POST['ordre'], "menuIt[]l", "         "));			
			$elements = explode("&", $ordre);
			$compte = count($elements);
			for($i = 0; $i <= $compte-1; $i++){
				$elements[$i] = explode("=", $elements[$i]);
				req("UPDATE __url SET principal = '0', affichage = '' WHERE id = '".$elements[$i][0]."'");
			}
			for($i = 0; $i <= $compte-1; $i++){
				req("UPDATE __url SET ordre = '".($i+1)."' WHERE id = '".$elements[$i][0]."'");
				if($elements[$i][1] != ""){
					req("UPDATE __url SET affichage = 'secondaire', principal='".$elements[$i][1]."' WHERE id = '".$elements[$i][0]."'");
					req("UPDATE __url SET affichage = 'principal' WHERE id = '".$elements[$i][1]."'");
				}
			}
			echo ('<div class="alert alert-success">L\'ordre a été sauvegardé !</div>');
		}
	}
?>
<script>
$().ready(function(){
	var ns = $('ol.sortable').nestedSortable({
		forcePlaceholderSize: true,
		handle: 'div',
		helper:	'clone',
		items: 'li',
		opacity: .6,
		placeholder: 'placeholder',
		revert: 250,
		tabSize: 25,
		tolerance: 'pointer',
		toleranceElement: '> div',
		maxLevels: 2,
		isTree: true,
		expandOnHover: 700,
		startCollapsed: false,
		change: function(){
			console.log('Relocated item');
		}
	});
	
	$('.expandEditor').attr('title','Click to show/hide item editor');
	$('.disclose').attr('title','Click to show/hide children');
	$('.deleteMenu').attr('title', 'Click to delete item.');
	$('.disclose').on('click', function() {
		$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
		$(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
	});
	
	$('.expandEditor').click(function(){
		var id = $(this).attr('data-id');
		$('#menuEdit'+id).toggle();
		$(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
	});
		
	$('.deleteMenu').click(function(){
		var id = $(this).attr('data-id');
		$('#menuItem_'+id).remove();
	});
			
	$('#serialize').click(function(){
		serialized = $('ol.sortable').nestedSortable('serialize');		
		$('#ordre').val(serialized);
	});
	$('#serialize2').click(function(){
		serialized = $('ol.sortable').nestedSortable('serialize');		
		$('#ordre2').val(serialized);
	});
});		
</script>


<div class="row">
	<div class="col-sm-6">
    	<div class="panel panel-default">
        	<div class="panel-heading">
            	<h3 class="panel-title">Liens non assignés</h3>
            </div>    
            <div class="panel-body">
<?php 
	$req = req("SELECT * FROM __url WHERE menu='0' ORDER BY type");
	while($d = fetch($req)){
?>
<ul class="list-group">
	<li class="list-group-item">
    	<div class="row">
        	<div class="col-sm-2">
    			<span class="label label-default"><?php echo $d['type'];?></span>
            </div>
            <div class="col-sm-6">
        		<form action="site_menu" method="post" id="formName-<?php echo($d['id']);?>">
        			<input type="hidden" name="renommer" value="<?php echo $d['id'];?>">
            		<div class="form-group input-group" style="border:none;">
           				<input type="text" class="form-control input-sm" name="nom" value="<?php echo $d['nom'];?>" required>
                		<span class="input-group-addon">
                        	<a href="#" onclick="document.getElementById('formName-<?php echo($d['id']);?>').submit();"><i class="fa fa-chevron-right"></i></a>
                        </span>
            		</div>
       			</form>
          	</div>
           	<div class="col-sm-4">
           		<?php if($d['type'] == "url"){?><a class="btn btn-danger" href="?supprimer_url=<?php echo($d['id']);?>">Supprimer</a> <?php } ?><a class="btn btn-default" href="?ajouter=<?php echo($d['id']);?>">Ajouter</a>
          	</div>
    	</div>
    </li>
</ul>
<?php
	}
?>
            </div>
        </div>
<form action="site_menu" method="post">
	<div class="jumbotron">
    <h2><b><span class="label label-default">url</span> Ajouter un lien de menu</b></h2>
   		<div class="form-group">
        	<label>Titre du lien</label>
            <input type="text" class="form-control" name="nouveau" placeholder="Nouveau lien" required>
        </div>
        <div class="form-group">
        	<label>Lien</label>
            <input type="text" class="form-control" name="lien" placeholder="http://" required>
        </div>
        <center><input type="submit" class="btn btn-success" value="Créer un lien"></center>
    </div>
</form>
   	</div>
	<div class="col-sm-6">
    	<div class="panel panel-success">
        	<div class="panel-heading">
            	<h3 class="panel-title">Menu</h3>
            </div>
            <div class="panel-body">
            <form action="site_menu" method="post">
                	<input type="hidden" name="ordre" id="ordre" value="">
                    <input type="submit" id="serialize" class="btn btn-success" value="Enregistrer les positions">
                </form>
   				<ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">
<?php 
	$req = req("SELECT * FROM __url WHERE menu='1' ORDER BY ordre ASC");
	while($d = fetch($req)){
		if($d['affichage'] != "secondaire"){
?>
<li style="display: list-item; margin-bottom:10px;" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded" id="menuItem_<?php echo($d['id']);?>">
	<div class="menuDiv">
		<span title="Développer/Masquer l'arborescence" class="disclose ui-icon ui-icon-minusthick"><span></span></span>
		<span title="Afficher/Masquer l'éditeur" data-id="<?php echo($d['id']);?>" class="expandEditor ui-icon ui-icon-triangle-1-n"></span>
		<span><span data-id="<?php echo($d['id']);?>" class="itemTitle" style="border:none;">
			<form action="site_menu" method="post" id="formName-<?php echo($d['id']);?>">
            	<input type="hidden" name="renommer" value="<?php echo $d['id'];?>">
                <div class="form-group input-group" style="border:none;">
                	<input type="text" class="form-control input-sm" name="nom" value="<?php echo $d['nom'];?>" required>
                    <span class="input-group-addon"><a href="#" onclick="document.getElementById('formName-<?php echo($d['id']);?>').submit();"><i class="fa fa-chevron-right"></i></a></span>
                </div>
            </form>
        </span></span></span></span>
		<div id="menuEdit<?php echo($d['id']);?>" class="menuEdit row" style="border:none;">
            <div class="col-sm-6" style="border:none;">
				<span class="label label-default"><?php echo $d['type'];?></span>
            </div>
            <div class="col-sm-6" style="border:none; text-align:right;">
               	<a class="btn btn-warning btn-xs" href="?supprimer=<?php echo($d['id']);?>">Retirer</a>
            </div>
		</div>
	</div>
<?php
		if($d['affichage'] == "principal"){
			$req2 = req("SELECT * FROM __url WHERE menu='1' AND principal='".$d['id']."' AND affichage='secondaire' ORDER BY ordre ASC");
			while($s = fetch($req2)){
?>
<ol>
	<li style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded" id="menuItem_<?php echo($s['id']);?>" data-foo="baz">
		<div class="menuDiv">
			<span title="Click to show/hide item editor" data-id="<?php echo($s['id']);?>" class="expandEditor ui-icon ui-icon-triangle-1-n"><span></span></span>
			<span>
            	<span data-id="<?php echo($s['id']);?>" class="itemTitle" style="border:none;">
					<form action="site_menu" method="post" id="formName-<?php echo($s['id']);?>">
            			<input type="hidden" name="renommer" value="<?php echo $s['id'];?>">
                		<div class="form-group input-group" style="border:none;">
                			<input type="text" class="form-control input-sm" name="nom" value="<?php echo $s['nom'];?>" required>
                    		<span class="input-group-addon">
                            	<a href="#" onclick="document.getElementById('formName-<?php echo($s['id']);?>').submit();"><i class="fa fa-chevron-right"></i></a>
                            </span>
                		</div>
            		</form>
        		</span>
            </span>
			<div id="menuEdit<?php echo($s['id']);?>" class="menuEdit row" style="border:none;">
            	<div class="col-sm-6" style="border:none;">
					<span class="label label-default"><?php echo $s['type'];?></span>
                </div>
                <div class="col-sm-6" style="border:none; text-align:right;">
                	<a class="btn btn-warning btn-xs" href="?supprimer=<?php echo($s['id']);?>">Retirer</a>
                </div>
			</div>
		</div>
	</li>
</ol>
<?php
			}
		}
?>
</li>
<?php 
		}
	}
?>           
   				</ol>
   				<form action="site_menu" method="post">
                	<input type="hidden" name="ordre" id="ordre2" value="">
                    <input type="submit" id="serialize2" class="btn btn-success" value="Enregistrer les positions">
                </form>   
            </div>
        </div>
   	</div>
</div> 
    
<?php
}
?>