<?php
function InitComposants(){
	global $site;
	//CHARGEMENT DE TOUS LES FICHIERS PRESENTS DANS LE DOSSIER "SITE"
	if ($dir = opendir($site['racine']."/composants/site/")) {
    while (($file = readdir($dir)) !== false) {
        if ($file != ".." && $file != "." && $file != "site.php" && $file != "admin") {
			include($file);
            }
        }
    }
	//CHARGEMENT DE TOUS LES COMPOSANTS PRESENTS DANS LE DOSSIER
    if ($dir = opendir($site['racine']."/composants/")) {
    while (($file = readdir($dir)) !== false) {
        if ($file != ".." && $file != "." && $file != "site") {
			include($site['racine']."/composants/".$file."/".$file.".php");
            }
        }
    }
}
?>