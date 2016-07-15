<?php
function InitAdminSite(){
	global $site;
	//CHARGEMENT DE TOUS LES FICHIERS PRESENTS DANS LE DOSSIER "SITE"
	if ($dir = opendir($site['racine']."/composants/site/admin/")) {
		while (($file = readdir($dir)) !== false) {
        	if ($file != ".." && $file != "." && $file != "site.php") {
				include($file);
        	}
   		}
	}
}
function e404(){
	echo('<div class="alert alert-danger"><strong>Erreur 404</strong> La page demandée n\'a pas été trouvée.</div>');
}
InitAdminSite();
?>