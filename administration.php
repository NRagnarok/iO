<?php
session_start();

require('configuration.php');
require('bibliotheques/systeme/mysql.php');
require('bibliotheques/systeme/fonctions.php');

if(!isset($_SESSION['utilisateur']) 
&& !isset($_SESSION['pass']) 
&& !isset($_SESSION['nom']) 
&& !isset($_SESSION['prenom']) 
&& !isset($_SESSION['methodconnex'])){
	header('Location:'.siteURL().'connexion?noconnect'); 
	exit();
}else{
	if($_SESSION['grade'] != "admin"){
		header('Location:'.siteURL().'connexion?limit'); 
		exit();
	}
	
	$req = req('SELECT id, motdepasse, validation FROM __utilisateurs WHERE mail = "'.$_SESSION['utilisateur'].'"');
	$utilisateur = fetch($req);
	if($utilisateur['motdepasse'] != $_SESSION['pass']){
		header('Location:'.siteURL().'connexion?badpass'); 
		exit();
	}
}
function debut_admin(){
	global $site;
?>
<?php
//CHARGEMENT DE TOUS LES COMPOSANTS PRESENTS DANS LE DOSSIER COMPOSANTS
	$menu_data = "";
	if ($dir = opendir($site['racine']."/composants/")) {
   		while(($file = readdir($dir)) !== false) {
        	if($file != ".." && $file != "."){
				include($site['racine']."/composants/".$file."/admin/".$file.".php");
				
				if($file != "site"){
					$xml = simplexml_load_file($site['racine']."/composants/".$file."/".$file.".xml");
					foreach($xml as $theme_infos){
						$menu_data .= $theme_infos->nom."|";
						$menu_data .= $theme_infos->fonctions_principales."|";
					}
				}
        	}
    	}	
	}
	$menu_data = substr($menu_data,0,-1);
	$menu_data = explode("|", $menu_data);
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Nicolas Vuillermet">

    <title><?php echo $site['nom'];?> - Administration</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo siteURL();?>themes/SBAdmin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo siteURL();?>themes/SBAdmin/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo siteURL();?>themes/SBAdmin/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo siteURL();?>themes/SBAdmin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link href="<?php echo siteURL();?>themes/SBAdmin/css/bootstrap-tagsinput.css" rel="stylesheet" />
    
    <link href="<?php echo siteURL();?>themes/SBAdmin/css/material.css" rel="stylesheet">
    
    <link href="<?php echo siteURL();?>bibliotheques/3rd-party/js/jqueryUI/jquery-ui.min.css" rel="stylesheet">
    
    <link href="<?php echo siteURL();?>bibliotheques/3rd-party/js/nestedSortable/nestedSortable.css" rel="stylesheet">
    
    <link href="<?php echo siteURL();?>bibliotheques/3rd-party/js/datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet">


    <!-- jQuery -->
    <script src="<?php echo siteURL();?>themes/SBAdmin/js/jquery.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo siteURL();?>themes/SBAdmin/js/bootstrap.min.js"></script>

	<script src="<?php echo siteURL();?>themes/SBAdmin/js/bootstrap-tagsinput.min.js"></script>
    
    <!-- MomentJS -->
    <script src="<?php echo siteURL();?>themes/SBAdmin/js/moment-with-locales.js"></script> 
    
    <script src="<?php echo siteURL();?>bibliotheques/3rd-party/js/datetimepicker/bootstrap-datetimepicker.js"></script>
    
    <script src="<?php echo siteURL();?>bibliotheques/3rd-party/js/jqueryUI/jquery-ui.min.js"></script> 
    
    <script src="<?php echo siteURL();?>bibliotheques/3rd-party/js/nestedSortable/nestedSortable.js"></script>  
    
    <script src="<?php echo siteURL();?>bibliotheques/3rd-party/js/ckeditor/ckeditor.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">Administration</a>
            </div>
            <ul class="nav navbar-nav">
        		<li><a href="<?php echo siteURL();?>"><?php echo $site['nom'];?></a></li>
        	</ul>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo(strtoupper($_SESSION['nom'])." ".ucfirst($_SESSION['prenom']));?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="../deconnexion"><i class="fa fa-fw fa-power-off"></i> Déconnexion</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="."><i class="fa fa-fw fa-dashboard"></i> Tableau de bord</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-cog"></i> Site <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="site_parametres">Paramètres</a>
                            </li>
                            <li>
                                <a href="site_utilisateurs">Utilisateurs</a>
                            </li>
                            <li>
                                <a href="site_menu">Menu</a>
                            </li>
                            <li>
                                <a href="composants">Composants</a>
                            </li>
                        </ul>
                    </li>
                    <?php
					$i = 0;
					while(count($menu_data) > $i){
						$nom_menu = $menu_data[$i];
						$i++;
						$lien_menu = $menu_data[$i];
						$i++;
					echo('<li><a href="'.$lien_menu.'"><i class="fa fa-fw fa-wrench"></i> '.$nom_menu.'</a></li>'); 
					}
					?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
			<?php
			$pages_liste = $menu_data;
			$nombre_pages_liste = count($pages_liste);
			$pages_liste[$nombre_pages_liste] = "Paramètres";
			$pages_liste[$nombre_pages_liste+1] = "site_parametres";
			$pages_liste[$nombre_pages_liste+2] = "Utilisateurs";
			$pages_liste[$nombre_pages_liste+3] = "site_utilisateurs";
			
			
			$sous_entete = "Tableau de bord";
			if(isset($_GET['lien'])){
				$i=1;
				while(count($pages_liste) > $i){
					if($_GET['lien'] == $pages_liste[$i]){
						$sous_entete = $pages_liste[$i-1];
					}
					$i=$i+2;
				}
			}
			?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Administration <small><?php echo $sous_entete; ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
<?php
}
function fin_admin(){
	global $site;
?>
                

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper --> 
    
    <!-- Morris Charts JavaScript -->
    <script src="<?php echo siteURL();?>themes/SBAdmin/js/plugins/morris/raphael.min.js"></script>
    <script src="<?php echo siteURL();?>themes/SBAdmin/js/plugins/morris/morris.min.js"></script>
    <script src="<?php echo siteURL();?>themes/SBAdmin/js/plugins/morris/morris-data.js"></script>

</body>

</html>
<?php
}
?>
<?php 	
debut_admin();
			
if(!isset($_GET['lien'])){?>

<?php	
}else{
	if(function_exists($_GET['lien'])){
		$_GET['lien']();
	}else{
		e404();
	}
} 
fin_admin();
?>
