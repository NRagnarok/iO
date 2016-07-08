<?php
function generer_menu($nom, $type, $lien, $extra, $html){
	global $site;
	if($extra == "accueil"){
		echo str_replace("{LIEN}", ".", str_replace("{TITRE}", $nom, $html));
	}else{
		if($site['apache'] == "htaccess"){
			return str_replace("{LIEN}", $lien, str_replace("{TITRE}", $nom, $html));
		}else if($site['apache'] == "php"){
			return str_replace("{LIEN}", "?".$lien, str_replace("{TITRE}", $nom, $html));
		}else if($site['apache'] == "direct"){
			return str_replace("{LIEN}", '?type='.$type.'&lien='.$lien, str_replace("{TITRE}", $nom, $html));
		}
	}
}
function generer_menu_principal($nom, $type, $lien, $extra, $html, $sousmenu){
	global $site, $mysql;
	if($extra == "accueil"){
		echo str_replace("{LIEN}", ".", str_replace("{TITRE}", $nom, str_replace("{LIENS_SECONDAIRES}", $sousmenu, $html)));
	}else{
		if($site['apache'] == "htaccess"){
			return str_replace("{LIEN}", $lien, str_replace("{TITRE}", $nom, str_replace("{LIENS_SECONDAIRES}", $sousmenu, $html)));
		}else if($site['apache'] == "php"){
			return str_replace("{LIEN}", "?".$lien, str_replace("{TITRE}", $nom, str_replace("{LIENS_SECONDAIRES}", $sousmenu, $html)));
		}else if($site['apache'] == "direct"){
			return str_replace("{LIEN}", '?type='.$type.'&lien='.$lien, str_replace("{TITRE}", $nom, str_replace("{LIENS_SECONDAIRES}", $sousmenu, $html)));
		}
	}
}

function menu(){
	global $site, $mysql;
	
	$xml = simplexml_load_file('themes/'.$site['theme'].'/modeles/menus.xml');
	foreach($xml as $menu){
		$entete = $menu->entete;
		$lien_normal = $menu->lien_normal;
		$lien_principal = $menu->lien_principal;
		$lien_secondaire = $menu->lien_secondaire;
		$ligne_secondaire = $menu->ligne_secondaire;
		$pied = $menu->pied;		
	}
	$req1 = req('SELECT id FROM '.$mysql['prefixe'].'menu WHERE principal = "oui"');
	$data1 = fetch($req1);
	$req = req('SELECT id, nom, type, lien, extra, affichage FROM '.$mysql['prefixe'].'url WHERE menu = "'.$data1['id'].'" ORDER BY ordre ASC');

	echo($entete);
	while ($data = fetch($req)){
		if($data['affichage'] == "principal"){
			
			$liens_secondaires = generer_menu($data['nom'], $data['type'], $data['lien'], $data['extra'], $lien_secondaire).'<li role="separator" class="divider"></li>';
			$req_sousmenus = req('SELECT nom, type, lien, extra FROM '.$mysql['prefixe'].'url WHERE menu = "'.$data1['id'].'" AND principal = "'.$data['id'].'" AND affichage="secondaire" ORDER BY ordre ASC');
			while ($data_sousmenus = fetch($req_sousmenus)){
				$html_sousmenus = $lien_secondaire;
				if($data_sousmenus['type'] == "" && $data_sousmenus['extra'] == "style_b"){
					$data_sousmenus['nom'] = '<b>'.$data_sousmenus['nom'].'</b>';
					$html_sousmenus = $ligne_secondaire;
				}
				$liens_secondaires .= generer_menu($data_sousmenus['nom'], $data_sousmenus['type'], $data_sousmenus['lien'], $data_sousmenus['extra'], $html_sousmenus);
			}
			
			echo generer_menu_principal($data['nom'], $data['type'], $data['lien'], $data['extra'], $lien_principal, $liens_secondaires);
			
		}else if($data['affichage'] == ""){
			
			echo generer_menu($data['nom'], $data['type'], $data['lien'], $data['extra'], $lien_normal);
			
		}
	}
	echo($pied);
}
?>                  