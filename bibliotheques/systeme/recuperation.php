<?php
function recuperation(){
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
  				color:#C94345;
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
  				color:#eee;
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
          
        <center><div class="alert alert-danger" style="width:90%">
        <h1><strong>Erreur</strong> La connexion à la base de donnée ne s'est pas établie correctement !</h1>
		</div></center>
          
          <br><br><br>
          
       <center><div class="alert alert-warning" style="width:75%">
  			<strong>Attention</strong> La configuration n'autorise pas une réparation de votre part.
		</div></center>
          
          <div class="col-lg-4">
         		<a href="#" class="btn btn-warning btn-block btn-lg">Reconfigurer l'accès à la base de donnée</a>
          </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-4">
         		<a href="#" class="btn btn-lg btn-block btn-danger">Réinstaller iO</a>
          </div>
        </div>
      </div> <!-- /row -->
</div> <!-- /container full -->

	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="themes/defaut/js/bootstrap.min.js"></script>
	</body>
</html>
    <?php
	die();
}
?>