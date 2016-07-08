<?php
function alerte($message = "", $type = "info"){
	global $site;
	$xml = simplexml_load_file('themes/'.$site['theme'].'/modeles/alertes.xml');
	
	switch($type){
		case 'succes':
			foreach($xml as $alerte){
				$alerte = $alerte->succes;
			}
			break;
		case 'info':
			foreach($xml as $alerte){
				$alerte = $alerte->info;
			}
			break;
		case 'attention':
			foreach($xml as $alerte){
				$alerte = $alerte->attention;
			}
			break;
		case 'danger':
			foreach($xml as $alerte){
				$alerte = $alerte->danger;
			}
			break;
	}
$message = str_replace("{MESSAGE}", $message, $alerte);

echo $message;
}
?>