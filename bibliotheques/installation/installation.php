<?php
function installation($action = "installation"){
	global $mysql;
	if(($action == "reinstallation") && isset($_POST['serveur'])){
		miseajourConfiguration("mysql", "serveur", $_POST['serveur']);
		miseajourConfiguration("mysql", "utilisateur", $_POST['utilisateur']);
		miseajourConfiguration("mysql", "motdepasse", $_POST['motdepasse']);
		miseajourConfiguration("mysql", "base", $_POST['base']);
		miseajourConfiguration("mysql", "prefixe", $_POST['prefixe']);
		header('Location:index.php');
		exit();
	}else if(($action == "installation") && isset($_POST['serveur'])){
	}
	?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>iO - Récupération</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="themes/defaut/css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<style>
			html,body {
 				height:100%;
			}

			h1 {
  				font-family: Arial,sans-serif
  				font-size:80px;
  				color:#0054FF;
			}

			.lead {
				color:#DDCCEE;
			}


			/* Custom container */
			.container-full {
 				margin: 0 auto;
  				width: 100%;
  				min-height:100%;
  				background-color:#004CFF;
  				color:#3D3D3D;
  				overflow:hidden;
			}

			.v-center {
  				margin-top:1%;
			}
		</style>
	</head>
	<body>
<div class="container-full">

      <div class="row">
       
        <div class="col-lg-12 text-center v-center">
          
        <center><div class="alert alert-info" style="width:90%">
        <?php if($action == "reinstallation"){?>
        <h1><strong>Réparation</strong> Vous êtes sur le point de réparer iO</h1>
        <?php }else{ ?>
        <h1><strong>Installation</strong> Vous êtes sur le point d'installer iO</h1>
        <?php } ?>
		</div></center>
          
          <br><br><br>
          
          <div class="col-lg-2"></div>
          <div class="col-lg-8">
          	<?php if($action == "reinstallation"){?>
            <div class="panel panel-default">
  				<div class="panel-body">
                	<h1>Base de donnée</h1>
                    <br /><br /><br />
    				<form action="?<?php echo $action;?>" method="post">
                    	<div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Serveur</span>
 							<input type="text" class="form-control" placeholder="local.host" name="serveur" value="<?php echo $mysql['serveur'];?>">
						</div>
                        <br />
                    	<div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Utilisateur</span>
 							<input type="text" class="form-control" placeholder="root" name="utilisateur" value="<?php echo $mysql['utilisateur'];?>">
						</div>  
                        <br />
                        <div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Mot de passe</span>
 							<input type="password" class="form-control" placeholder="********" name="motdepasse" value="<?php echo $mysql['motdepasse'];?>">
						</div>
                        <br />
                        <div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Base</span>
 							<input type="text" class="form-control" placeholder="database_1" name="base" value="<?php echo $mysql['base'];?>">
						</div>
                        <br />
                        <div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Préfixe</span>
 							<input type="text" class="form-control" placeholder="prfx_" name="prefixe" value="<?php echo $mysql['prefixe'];?>">
						</div>
                        <br /><br />
                        <div class="row">
                        <div class="col-lg-6"><a href="?" class="btn btn-warning">Annuler</a></div>
                        <div class="col-lg-6"><input type="submit" value="Reconfigurer les accès" class="btn btn-success"></div>
                        </div>
                    </form>
  				</div>
			</div>
            <?php }else{?>
            <div class="panel panel-default">
  				<div class="panel-body">
                	<h1>Configuration du site</h1>
                    <br /><br /><br />
    				<form action="?<?php echo $action;?>" method="post">
                    	<h2>Base de donnée</h2>
                    	<div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Serveur</span>
 							<input type="text" class="form-control" placeholder="local.host" name="serveur" value="<?php echo $mysql['serveur'];?>">
						</div>
                        <br />
                    	<div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Utilisateur</span>
 							<input type="text" class="form-control" placeholder="root" name="utilisateur" value="<?php echo $mysql['utilisateur'];?>">
						</div>  
                        <br />
                        <div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Mot de passe</span>
 							<input type="password" class="form-control" placeholder="********" name="motdepasse" value="<?php echo $mysql['motdepasse'];?>">
						</div>
                        <br />
                        <div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Base</span>
 							<input type="text" class="form-control" placeholder="database_1" name="base" value="<?php echo $mysql['base'];?>">
						</div>
                        <br />
                        <div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Préfixe</span>
 							<input type="text" class="form-control" placeholder="prfx_" name="prefixe" value="<?php echo $mysql['prefixe'];?>">
						</div>
                        <br />
                        <h2>Site</h2>
                        <div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Nom du site</span>
 							<input type="text" class="form-control" placeholder="Mon site" name="nom" value="<?php echo $mysql['prefixe'];?>">
						</div>
                        <br />
                        <div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Description du site</span>
 							<input type="text" class="form-control" placeholder="Mon nouveau site créé avec iO !" name="description" value="<?php echo $mysql['prefixe'];?>">
						</div>
                        <br />
                        <div class="input-group">
  							<span class="input-group-addon" id="basic-addon1">Méthode de gestion des url des pages</span>
 							<select class="form-control" name="apache"><option value="htaccess">htaccess (Serveur Apache, URL de la forme monsite.tld/page)</option></select>
						</div>
                        <br /><br />
                        <div class="row">
                        <div class="col-lg-6"><a href="?" class="btn btn-warning">Annuler</a></div>
                        <div class="col-lg-6"><input type="submit" value="Installer iO" class="btn btn-success"></div>
                        </div>
                    </form>
  				</div>
			</div>      

        	<?php } ?>
          	
          </div>
          <div class="col-lg-2"></div>
        </div>
      </div> <!-- /row -->
</div> <!-- /container full -->

	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="themes/defaut/js/bootstrap.min.js"></script>
	</body>
</html> 
 <?php
	exit();
}
?>