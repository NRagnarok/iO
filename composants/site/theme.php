<?php
function theme(){
global $site;
global $theme;
global $theme_css, $theme_js;

$theme_css = new ArrayObject();
$theme_js = new ArrayObject();

	//CHARGEMENT DE TOUS LES COMPOSANTS PRESENTS DANS LE DOSSIER
    if ($dir = opendir($site['racine']."/themes/".$site['theme']."/modules/")) {
    while (($file = readdir($dir)) !== false) {
        if ($file != ".." && $file != "." && $file != "site") {
			include($site['racine']."/themes/".$site['theme']."/modules/".$file."/".$file.".php");
            }
        }
    }
$xml = simplexml_load_file('themes/'.$site['theme'].'/modeles/pages.xml');
	foreach($xml as $page){
		$page_entete = str_replace("{INDEX}", "Accueil", $page->entete);
		$page_pied = $page->pied;		
	}
	$theme['page_entete'] = $page_entete;
	$theme['page_pied'] = $page_pied;
}
theme();
function theme_css($ajout){
	global $theme_css;
	$theme_css->append($ajout);
}
function theme_js($ajout){
	global $theme_js;
	$theme_js->append($ajout);
}
?>