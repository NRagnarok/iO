 <?php
function texte_resume($texte, $nbreCar)
{
        $LongueurTexteBrutSansHtml = strlen(strip_tags($texte));

        if($LongueurTexteBrutSansHtml < $nbreCar) return $texte;

        $MasqueHtmlSplit = '#</?([a-zA-Z1-6]+)(?: +[a-zA-Z]+="[^"]*")*( ?/)?>#';
        $MasqueHtmlMatch = '#<(?:/([a-zA-Z1-6]+)|([a-zA-Z1-6]+)(?: +[a-zA-Z]+="[^"]*")*( ?/)?)>#';

        $texte .= ' ';

        $BoutsTexte = preg_split($MasqueHtmlSplit, $texte, -1,  PREG_SPLIT_OFFSET_CAPTURE | PREG_SPLIT_NO_EMPTY);

        $NombreBouts = count($BoutsTexte);

        if( $NombreBouts == 1 )
        {
                $longueur = strlen($texte);

                return substr($texte, 0, strpos($texte, ' ', $longueur > $nbreCar ? $nbreCar : $longueur));
        }

        $longueur = 0;

        $indexDernierBout = $NombreBouts - 1;

        $position = $BoutsTexte[$indexDernierBout][1] + strlen($BoutsTexte[$indexDernierBout][0]) - 1;

        $indexBout = $indexDernierBout;
        $rechercheEspace = true;

        foreach( $BoutsTexte as $index => $bout )
        {
                $longueur += strlen($bout[0]);

                if( $longueur >= $nbreCar )
                {
                        $position_fin_bout = $bout[1] + strlen($bout[0]) - 1;

                        $position = $position_fin_bout - ($longueur - $nbreCar);

                        if( ($positionEspace = strpos($bout[0], ' ', $position - $bout[1])) !== false  )
                        {
                                $position = $bout[1] + $positionEspace;
                                $rechercheEspace = false;
                        }

                        if( $index != $indexDernierBout )
                                $indexBout = $index + 1;
                        break;
                }
        }

        if( $rechercheEspace === true )
        {
                for( $i=$indexBout; $i<=$indexDernierBout; $i++ )
                {
                        $position = $BoutsTexte[$i][1];
                        if( ($positionEspace = strpos($BoutsTexte[$i][0], ' ')) !== false )
                        {
                                $position += $positionEspace;
                                break;
                        }
                }
        }

        $texte = substr($texte, 0, $position);

        preg_match_all($MasqueHtmlMatch, $texte, $retour, PREG_OFFSET_CAPTURE);

        $BoutsTag = array();

        foreach( $retour[0] as $index => $tag )
        {
                if( isset($retour[3][$index][0]) )
                {
                        continue;
                }

                if( $retour[0][$index][0][1] != '/' )
                {
                        array_unshift($BoutsTag, $retour[2][$index][0]);
                }

                else
                {
                        array_shift($BoutsTag);
                }
        }

        if( !empty($BoutsTag) )
        {
                foreach( $BoutsTag as $tag )
                {
                        $texte .= '</' . $tag . '>';
                }
        }

        if ($LongueurTexteBrutSansHtml > $nbreCar)
        {
                $texte .= ' [......]';

                $texte =  str_replace('</p> [......]', '... </p>', $texte);
                $texte =  str_replace('</ul> [......]', '... </ul>', $texte);
                $texte =  str_replace('</div> [......]', '... </div>', $texte);
        }

        return $texte;
}
function chaine2url($chaine) {
    $chaine = trim(utf8_decode($chaine));
    $chaine = strtr($chaine,
"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
    $chaine = strtr($chaine,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz");
    $chaine = preg_replace('#([^.a-z0-9]+)#i', '-', $chaine);
    $chaine = preg_replace('#-{2,}#','-',$chaine);
    $chaine = preg_replace('#-$#','',$chaine);
    $chaine = preg_replace('#^-#','',$chaine);
    return utf8_encode($chaine);
}
function rmDossier($path) {
    $path = realpath($path);
    if(!file_exists($path))
        throw new RuntimeException('Fichier ou dossier non-trouvé');
    if(is_dir($path)) {
        $dir = scandir($path, SCANDIR_SORT_DESCENDING);
        foreach($dir as $file_in_dir){
            if($file_in_dir == '.' or $file_in_dir == '..')
                break; // on sort de boucle : il n'y aura rien d'autre
            rmDossier("$path/$file_in_dir");
        }
    }
    unlink($path);
}
function cryptage($data, $key = "7D5Fez9G") {
    $data = serialize($data);
    $td = mcrypt_module_open(MCRYPT_DES,"",MCRYPT_MODE_ECB,"");
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td,$key,$iv);
    $data = base64_encode(mcrypt_generic($td, '!'.$data));
    mcrypt_generic_deinit($td);
    return $data;
}
 
function decryptage($data, $key = "7D5Fez9G") {
    $td = mcrypt_module_open(MCRYPT_DES,"",MCRYPT_MODE_ECB,"");
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td,$key,$iv);
    $data = mdecrypt_generic($td, base64_decode($data));
    mcrypt_generic_deinit($td);
 
    if (substr($data,0,1) != '!')
        return false;
 
    $data = substr($data,1,strlen($data)-1);
    return unserialize($data);
}
function miseajourConfiguration($type, $variable, $valeur){
	global $site, $mysql;
	switch($type){
	case 'mysql':
		$contenuVar = $mysql[$variable];
		break;
	case 'site':
		$contenuVar = $site[$variable];
		break;
	}
	$racine = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']); //on enlève le index.php du lien complet système vers le fichier principal php

	$lecture_conf = file($racine."configuration.php"); // on lit le fichier de conf
	$contenu_conf = ""; 
	foreach($lecture_conf as $ligne){
		$contenu_conf .= $ligne; //On met chaque ligne du fichier dans une même variable
	}
	$nouveau_contenu = str_replace('$'.$type.'[\''.$variable.'\'] = "'.$contenuVar.'";', '$'.$type.'[\''.$variable.'\'] = "'.$valeur.'";', $contenu_conf); //on met à jour la ligne

	$reecriture_conf = fopen($racine.'configuration.php', 'w+'); //On réécrit le fichier
	fwrite($reecriture_conf, $nouveau_contenu);
	fclose($reecriture_conf);
	return true;
}
?>  