<?php
function galerie(){	
}

function galerie_tagcode($attribut){
	$req = req("SELECT * FROM __galerie_images WHERE galerie = '".$attribut."'");
    $contenu = '<div id="galerie_'.$attribut.'">';
	while($d = fetch($req)){
		$contenu .= '<a href="ressources/galerie/'.$d['galerie'].'/'.$d['image'].'"><img alt="'.$d['titre'].'" src="ressources/galerie/'.$d['galerie'].'/thumb/'.$d['image'].'"/></a>';
	}
	$contenu .= '</div><script>$(\'#galerie_'.$attribut.'\').justifiedGallery({lastRow : \'nojustify\', rowHeight : 100, rel : \'gallery2\', margins : 1, sizeRangeSuffixes: {}}).on(\'jg.complete\', function () {$(\'#galerie_'.$attribut.' a\').swipebox();});</script>';
	return $contenu;
}
function galerie_initilisation(){
	theme_css("composants/galerie/css/swipebox.min.css");
	theme_css("composants/galerie/css/justifiedgallery.min.css");
	theme_js("composants/galerie/js/swipebox.min.js");
	theme_js("composants/galerie/js/jquery.justifiedgallery.min.js");
}galerie_initilisation();
?>