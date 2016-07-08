<?php
function contact($parametre = ""){
	global $mysql, $site;
	global $theme;
	
	if($parametre != "minimal"){
	echo str_replace("{TITRE}", "Nous contacter", $theme['page_entete']);
	}
	if(isset($_POST['message'])){
		if(!$_POST['g-recaptcha-response']){
          alerte('Vous devez valider le captcha !', 'danger'); 
		echo('<center><a href="javascript:history.back()" class="btn btn-danger">Revenir en arri&egrave;re</a></center>');
        }
        $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeMGx0TAAAAAKoSdkLlGvIDHg4yiNksBq_E2m-u&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
        if($response['success'] == false)
        {
         alerte('Nous n\'avons pas pu valider votre demande.', 'danger'); 
		echo('<center><a href="javascript:history.back()" class="btn btn-danger">Revenir en arri&egrave;re</a></center>');
        }
        else
        {
          		
		$sujet = $site['nom'].' un message a été reçu ! - '.$_POST['nom'].' <'.$_POST['mail'].'>';
$message = $_POST['message'];
$headers = "From: \"".$_POST['nom']."\"<".$_POST['mail'].">\n";
$headers .= "Reply-To: ".$_POST['mail']."\n";
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
mail(decryptage($_POST['destinataire']),$sujet,$message,$headers);

        alerte('Nous avons re&ccedil;u votre message, et nous vous recontacterons au plus vite !', 'succes'); 
		echo('<center><a href="." class="btn btn-success">Revenir &agrave; l\'accueil</a></center>'); 
        }
		
		}else{
			if($parametre != "minimal"){
		alerte('Nous sommes &agrave; votre disposition par  mail &agrave; contact@penn-ar-rock.fr, ou par le formulaire de contact ci-dessous', 'info'); 	
			}
	?>
    <script src="bibliotheques/3rd-party/js/ckeditor/ckeditor.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <form action="" method="post">


  <div class="form-group">
        	<label>Qui voulez-vous contacter ?</label>

    <select class="form-control" name="destinataire">
    <?php
    $req = req('SELECT * FROM '.$mysql['prefixe'].'contact');
	while($data = fetch($req)){
		echo ('<option value="'.cryptage($data['destinataire']).'">'.$data['nom'].'</option>');
	}
	?>
    </select>
    </div>
  
  <div class="form-group">
            <input class="form-control" id="nom" type="text" name="nom" placeholder="Votre nom" size="50" required>
        </div>
  
  
<div class="form-group">
<input class="form-control input-lg" id="email" type="text" name="mail" placeholder="Votre adresse email" size="50" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
</div>

 <div class="form-group">
  <label>Votre message</label>
    <textarea class="form-control" name="message" cols="50" rows="20" required></textarea>
    </div>
    <?php if($parametre != "minimal"){?>
	<script>

	CKEDITOR.replace('message',
{
toolbar : [
{ name: 'document',   items: [  'Preview', ] },
{ name: 'clipboard',   items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
{ name: 'editing',   items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker',  'Scayt' ] },
'/',
{ name: 'basicstyles',   items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
{ name: 'paragraph',   items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
{ name: 'links',   items: [ 'Link', 'Unlink' ] },
'/',
{ name: 'styles',   items: [ 'Styles', 'Format', 'Font', 'FontSize'] },
{ name: 'colors',   items: [ 'TextColor', 'BGColor', 'Image', 'SpecialChar'] },
{ name: 'insert',  items: ['Table','HorizontalRule' ] }
]
});
		</script>
        <?php } ?>
        
        <div class="g-recaptcha" data-sitekey="6LeMGx0TAAAAAMFCVrHgvySS8LES4ilKMM7zYXIm"></div>
<br /><input type="submit" value="Nous envoyer un message" class="btn btn-success"></form><br />
    <?php
	}
	if($parametre != "minimal"){
	echo $theme['page_pied'];
	}
}
?>

