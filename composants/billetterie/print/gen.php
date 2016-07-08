<?php    
    include "qrlib.php";
	$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'temp/';
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
         $filename = $PNG_TEMP_DIR.md5('http://192.168.0.40/qr.php|H|10').'.png';
        QRcode::png("http://192.168.0.40/qr.php", $filename, "H", "10", 2);    
        echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';
    