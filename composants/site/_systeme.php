<?php
function redirection($lien, $temps = '0', $type = 'html'){
	switch($type){
		case 'php':
			header('Location:'.$lien);
			exit();
			break;
		case 'js':
			$temps = $temps*1000;
			echo('<script language="JavaScript">window.setTimeout("location=(\''.$lien.'\');",'.$temps.');</script>');
			break;
		default:
			echo('<meta http-equiv="refresh" content="'.$temps.'; URL='.$lien.'">');
			break;
	}
}

?>