<?php
ini_set('display_errors',1);
date_default_timezone_set('Europe/Paris');
if(isset($_SERVER['HTTPS'])){$site['HTTP'] = "https://";}else{$site['HTTP'] = "http://";}

include("recuperation.php");
if(!@include(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME'])."/configuration.php"))recuperation("configuration");
include("fonctions.php");
include("mysql.php");

if(!@include($site['racine']."/composants/site/site.php")){include("reparation.php");exit();}
InitComposants();

global $mysql;
	if(isset($_GET['lien'])){
		$req = req('SELECT * FROM '.$mysql['prefixe'].'url WHERE lien="'.$_GET['lien'].'"');
		$data = fetch($req);
		$num_rows = mysqli_num_rows($req);
			if($num_rows == 1){
				if($data['extra'] == "noBody"){
					$data['type']($_GET['lien']);
				}else{
					include("html.php");
				}
			}else{
				include("html.php");
			}
	}else{
		include("html.php");
	}






?>