<?php
function article($lien){
	global $mysql, $site;
	$req = req('SELECT * FROM '.$mysql['prefixe'].'article WHERE nom="'.$lien.'"');
	$data = fetch($req);
	
	$xml = simplexml_load_file('themes/'.$site['theme'].'/modeles/articles.xml');
	foreach($xml as $article){
		$entete = $article->entete;		
		$pied = $article->pied;
	}
	
	echo str_replace("{INDEX}", "Accueil", str_replace("{TITRE}", $data['titre'], $entete));
	
	if($data['exec'] == "oui"){
	tagcode($data['contenu']);
	}else {
	echo tagcode($data['contenu']);
	}
	
	echo $pied;
}
?>