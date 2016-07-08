<?php
function contenu(){
	global $mysql;
	if(!isset($_GET['lien'])){
		$req = req('SELECT type, lien FROM '.$mysql['prefixe'].'url WHERE extra="accueil"');
	$data = fetch($req);
	$data['type']($data['lien']);
	
	}else{
	$req = req('SELECT * FROM '.$mysql['prefixe'].'url WHERE lien="'.$_GET['lien'].'"');
	$data = fetch($req);
	$num_rows = mysqli_num_rows($req);
	if($num_rows == 1){
	$data['type']($_GET['lien']);
	}else{
	article("404");
	}
	}
	
}
?>