<?php
if(isset($_SERVER['HTTPS'])){
	$url = "https://";
	if($_SERVER['SERVER_PORT'] == "443"){
		$port = "";
	}else{
		$port = ":".$_SERVER['SERVER_PORT'];
	}
}else{
	$url = "http://";
	if($_SERVER['SERVER_PORT'] == "80"){
		$port = "";
	}else{
		$port = ":".$_SERVER['SERVER_PORT'];
	}
}

$url = 	str_replace($site['HTTP'].$_SERVER['SERVER_NAME'].$port, '',
		str_replace('index.php', '', 
		str_replace(':/', '://', 
		str_replace('//', '/', $url.$_SERVER['SERVER_NAME'].$port."/".$_SERVER['PHP_SELF']))));
$racine = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);

$lecture_conf = file($racine."configuration.php");
$contenu_conf = "";
foreach($lecture_conf as $ligne){
$contenu_conf .= $ligne;
}
$nouveau_contenu = str_replace(str_replace($site['HTTP'].$_SERVER['SERVER_NAME'].$port, '', $site['url']), $url, str_replace($site['racine'], $racine, $contenu_conf));

$reecriture_conf = fopen($racine.'configuration.php', 'w+');
fwrite($reecriture_conf, $nouveau_contenu);
fclose($reecriture_conf);
header('Location:index.php');
exit();
?>