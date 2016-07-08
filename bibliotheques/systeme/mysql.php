<?php

function MySqlConnexion(){
	global $mysql;
	global $mysql_connexion;
	if(!@$mysql_connexion = mysqli_connect($mysql['serveur'], $mysql['utilisateur'], $mysql['motdepasse'], $mysql['base']))recuperation();
	
}

MySqlConnexion();

function alertMySql($sql, $data){
	die('Erreur SQL !<br />'.$sql.'<br />'.$data);
}
function utf8_decode_array($array){
    @array_walk_recursive($array, function(&$item, $key){
		$item = utf8_decode($item);
    });
    return $array;
}

function req($sql){
	global $mysql, $mysql_connexion;
	$sql = str_replace("__", $mysql['prefixe'], $sql);
	$req = mysqli_query($mysql_connexion, $sql) or alertMySql($sql, mysqli_error($mysql_connexion));
	return $req;
}

function fetch($req){
	return utf8_decode_array(mysqli_fetch_array($req));
}

function res($chaine){
	global $mysql_connexion;
	return mysqli_real_escape_string($mysql_connexion, utf8_encode($chaine));
}
?>