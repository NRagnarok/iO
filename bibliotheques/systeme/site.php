<?php
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