<?php
echo("\n".'<head>');

//****************************
//Déclaration des métadonnées*
//****************************
echo("\n".'<meta http-equiv="content-type" content="text/html; charset='.$site['charset'].'" />');
echo("\n".'<meta name="keywords" content="'.$site['meta'].'">');
echo("\n".'<meta name="author" lang="fr" content="Nicolas Vuillermet">');
echo("\n".'<meta name="reply-to" content="nicovuillermet@gmail.com">');
echo("\n".'<meta name="robots" content="index">');
echo("\n".'<meta name="generator" content="Io">');
echo("\n".'<meta name="description" content="'.$site['description'].'">');
echo("\n".'<meta name="viewport" content="width=device-width, user-scalable=yes" />');
echo("\n".'<link rel="icon" href="'.$site['url'].'themes/'.$site['theme'].'/favicon.ico" />');
echo("\n".'<title>'.$site['nom'].'</title>');

//*************
// GESTION CSS*
//*************
$xml = simplexml_load_file('themes/'.$site['theme'].'/initialisation.xml');
foreach($xml as $theme_infos){
	$header_infos = $theme_infos->header_infos;
	$css = $theme_infos->css;	
}
echo($header_infos);
$css = explode(";", $css);
foreach($css as $feuille){
	$feuille = str_replace("{", "", str_replace("}", "", $feuille));
	$feuille = explode("|", $feuille);
	if(array_key_exists(1, $feuille)){
		echo ("\n".'<link rel="stylesheet" type="text/css" href="themes/'.$site['theme'].'/css/'.$feuille[0].'" '.$feuille[1].' />');
	}else{
		echo ("\n".'<link rel="stylesheet" type="text/css" href="themes/'.$site['theme'].'/css/'.$feuille[0].'" />');
	}
}
$nombrelignecss = count($theme_css)-1;
for($i = 1; $i <= $nombrelignecss+1; $i++){
	echo ("\n".'<link rel="stylesheet" type="text/css" href="'.$theme_css[$i-1].'" />');
}


//***********
//GESTION JS*
//***********
$xml = simplexml_load_file('themes/'.$site['theme'].'/initialisation.xml');
	foreach($xml as $theme_infos){
		$pre_contenu = $theme_infos->pre_contenu;
		$post_contenu = $theme_infos->post_contenu;
		$js = $theme_infos->js;	
		$footer_infos = $theme_infos->footer_infos;
	}
$js = explode(";", $js);
foreach($js as $script){
	$script = str_replace("{", "", str_replace("}", "", $script));
		echo ("\n".'<script src="themes/'.$site['theme'].'/js/'.$script.'" type="text/javascript"></script>');
}
$nombrelignejs = count($theme_js)-1;
for($i = 1; $i <= $nombrelignejs+1; $i++){
	echo ("\n".'<script src="'.$theme_js[$i-1].'" type="text/javascript"></script>');
}


//*****
// FIN*
//*****
echo("\n".'</head>');
?>