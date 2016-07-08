<?php
function tagcode($texte){
	$contenu = explode("]}", $texte);
	$nombre_tag = count($contenu)-1;

	for ($i = 1; $i <= $nombre_tag; $i++) {
		$tagcode = explode("{[", $contenu[$i-1]);
		$tagcode = $tagcode[1];
		$tagcode = explode(":", $tagcode);
	
		$fonction = "";
		$attribut = "";
	
		@$fonction = $tagcode[0];
		@$attribut = $tagcode[1];
		//traitement
		$req = req("SELECT fonction FROM __tagcode WHERE tag = '".$fonction."'");
        $d = fetch($req);
	
		//reconstitution
		$tagcode_rewrited = "{[".$fonction.":".$attribut."]}";
		//remplacement $d['fonction']($attribut)
		if(function_exists($d['fonction'])){$valeur = $d['fonction']($attribut);}else{$valeur='<span style="background-color:red; color:white;">Une erreur est présente dans le tagCode</span>';}
		$texte = str_replace($tagcode_rewrited, $valeur, $texte);
	}
	return $texte;
}
?>