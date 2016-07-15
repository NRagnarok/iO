<?php
/* GLOBAL FUNCTION */
function authentificationCheck(){
	if(isset($_SESSION['utilisateur']) 
	&& isset($_SESSION['pass']) 
	&& isset($_SESSION['nom']) 
	&& isset($_SESSION['prenom']) 
	&& isset($_SESSION['methodconnex'])){
		$req = req('SELECT motdepasse FROM __utilisateurs WHERE mail = "'.$_SESSION['utilisateur'].'"');
		$utilisateur = fetch($req);
		if($utilisateur['motdepasse'] == $_SESSION['pass']){
			return 1;
		}else{
			return 2;
		}
	}else{
		return 0;
	}
}
function autoAuthCheck(){
	if(authentificationCheck() == 0){
		header('Location:connexion?noconnect');
		exit();
	}else{
		if(authentificationCheck() == 2){
			header('Location:connexion?badpass');
			exit();
		}
	}
}
function utilisateurVarInit(){
	global $utilisateur;
	if(authentificationCheck()){
		$req = req('SELECT * FROM __utilisateurs WHERE mail = "'.$_SESSION['utilisateur'].'"');
		$utilisateur = fetch($req);
	}	
}utilisateurVarInit();


/* INMODULE FUNCTION */
function connexion_check(){
	$req = req('SELECT COUNT(*) AS total FROM __utilisateurs WHERE mail = "'.$_POST['email'].'"');
	$donnees = fetch($req);


		if($donnees['total'] == "0"){
			return "errorid";
		}else{
			$req = req('SELECT * FROM __utilisateurs WHERE mail = "'.$_POST['email'].'"');
			$utilisateur = fetch($req);
					
				if($utilisateur['motdepasse'] == hash('sha512', $_POST['pass'])){
					$_SESSION['utilisateur'] = $utilisateur['mail'];
					$_SESSION['pass'] = $utilisateur['motdepasse'];
					$_SESSION['nom'] = $utilisateur['nom'];
					$_SESSION['prenom'] = $utilisateur['prenom'];
					$_SESSION['grade'] = $utilisateur['grade'];
					$_SESSION['methodconnex'] = "connexion";
					return "";
				}else{
					return "errorpass";
				}
	
		}
}
function connexion($actuel = "", $alerte = ""){
	global $theme;
		if(isset($_POST['email']) && isset($_POST['pass'])){
			$alerte = connexion_check();
		}
	
	
	if(isset($_SESSION['utilisateur']) 
	&& isset($_SESSION['pass']) 
	&& isset($_SESSION['nom']) 
	&& isset($_SESSION['prenom']) 
	&& isset($_SESSION['methodconnex'])){
		$actuel="connecte";
	}else if(isset($_GET['noconnect'])){
		$actuel="deconnecte";
	}else if(isset($_GET['badpass'])){
		$actuel="deconnecte";
	}else if(isset($_GET['limit'])){
		$actuel="deconnecte";
	}
	
	
	echo str_replace("{TITRE}", "Authentification", $theme['page_entete']);

	if($actuel == "connecte"){
		if(!isset($_POST['retour'])){
			$_POST['retour'] = "accueil";
		}else if($_POST['retour'] == "connexion"){
			$_POST['retour'] = "accueil";
		}
	
		alerte('Vous &ecirc;tes &agrave; pr&eacute;sent connect&eacute; ! Redirection en cours...  (<a href="'.$_POST['retour'].'">vous pouvez cliquer ici</a>)<br />
		<center><img src="bibliotheques/3rd-party/ressources/chargement.gif" alt="Chargement en cours..." /></center>', 'info');
	
		redirection($_POST['retour'], '3', 'html');

	}else if($actuel == "deconnexion"){ 
	
		alerte('Vous avez &eacute;t&eacute; d&eacute;connect&eacute; !', 'info');
	
	?>
     <div class="panel panel-default"><div class="panel-body">
   <form action="connexion" method="post" name="authentification">
<input class="form-control" name="email" type="text" id="inputEmail" placeholder="Adresse Email"/><br />
<input class="form-control" name="pass" type="password" placeholder="Mot de passe" id="inputPassword" />
<?php if(isset($_GET['retour'])){?>
	<input type="hidden" name="retour" value="<?php echo $_GET['retour']; ?>">
<?php }else{?>
	<input type="hidden" name="retour" value="connexion">
<?php } ?><br />
    <input name="" type="submit" value="Se connecter" class="btn btn-success"/><?php if(1 != 1){?> ou <a href="inscription" class="btn btn-primary">Cr&eacute;er un compte</a><?php }?></td>
</form>
</div></div>
<?php }else if($actuel == "deconnecte"){alerte("Vous &ecirc;tes d&eacute;connect&eacute; !", "info");?>
<div class="panel panel-default"><div class="panel-body">
<form action="connexion" method="post" name="authentification" style="text-align:center;">
<input class="form-control" name="email" type="text" id="inputEmail" placeholder="Adresse Email"/><br />
<input class="form-control" name="pass" type="password" placeholder="Mot de passe" id="inputPassword" />
<?php if(isset($_GET['retour'])){?>
	<input type="hidden" name="retour" value="<?php echo $_GET['retour']; ?>">
<?php }else{?>
	<input type="hidden" name="retour" value="connexion">
<?php } ?><br />
<input name="" type="submit" value="Se connecter" class="btn btn-success" /><?php if(1 != 1){?> ou <a href="inscription" class="btn btn-primary">Cr&eacute;er un compte</a><?php }?></td>
</form>
</div></div>
<?php
}else{
	if($alerte == "errorid"){
		alerte('Une erreur s\'est gliss&eacute;e dans votre adresse email !', 'danger');
	}else if($alerte == "errorpass"){
		alerte('Votre mot de passe semble incorrect !', 'danger');
    }
?>
<div class="panel panel-default"><div class="panel-body">
<form action="connexion" method="post" name="authentification">
<input class="form-control" name="email" type="text" id="inputEmail" placeholder="Adresse Email"/><br />
<input class="form-control" name="pass" type="password" placeholder="Mot de passe" id="inputPassword" />
<?php if(isset($_GET['retour'])){?>
	<input type="hidden" name="retour" value="<?php echo $_GET['retour']; ?>">
<?php }else{?>
	<input type="hidden" name="retour" value="accueil">
<?php } ?><br />
<input name="" type="submit" value="Se connecter" class="btn btn-success" /><?php if(1 != 1){?> ou <a href="inscription" class="btn btn-primary">Cr&eacute;er un compte</a><?php }?></form> 
</div></div>
<?php } 
echo $theme['page_pied'];
}
function deconnexion(){
	session_unset(); 
	$actuel="deconnexion";
	connexion($actuel);
}
function genererMDP ($longueur = 16){
    $mdp = "";
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
    $longueurMax = strlen($possible);
 
    if ($longueur > $longueurMax) {
        $longueur = $longueurMax;
    }

    $i = 0;
 
    while ($i < $longueur) {
        $caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);

        if (!strstr($mdp, $caractere)) {
            $mdp .= $caractere;
            $i++;
        }
    }
 
    return $mdp;
}
function inscription_check(){
	global $theme;
	global $site;
	echo str_replace("{TITRE}", "Inscription", $theme['page_entete']);


if(isset($_POST['nom']) && $_POST['nom'] != "" && $_POST['nom'] != null){
	
	if(isset($_POST['prenom']) && $_POST['prenom'] != "" && $_POST['prenom'] != null){
		if(isset($_POST['mdp']) && $_POST['mdp'] != "" && $_POST['mdp'] != null){
			if(isset($_POST['mdp2']) && $_POST['mdp2'] != "" && $_POST['mdp2'] != null){
				if(isset($_POST['email']) && $_POST['email'] != "" && $_POST['email'] != null){
					if($_POST['mdp'] == $_POST['mdp2']){
						
						$req = req('SELECT COUNT(*) AS total FROM __utilisateurs WHERE mail = "'.$_POST['email'].'"');
$donnees = fetch($req);

if($donnees['total'] != "0"){
	alert('Erreur lors de l\'inscription : votre adresse email est d&eacute;j&agrave; enregistr&eacute;e !', 'danger');
}else{
	
						
						$req = req('SELECT COUNT(*) AS total FROM __utilisateurs');
					$donnees = fetch($req);
					
$derid = $donnees['total']+1;
		
						$req = req('SELECT COUNT(*) AS total FROM __utilisateurs WHERE id = "'.$derid.'"');
					$donneestest = fetch($req);
					while($donneestest['total'] != 0){
						$derid++;
						$req = req('SELECT COUNT(*) AS total FROM __utilisateurs WHERE id = "'.$derid.'"');
					$donneestest = fetch($req);					
					}
					

$email = $_POST['email'];
$code = genererMDP();
				$req = req('INSERT INTO __utilisateurs(id, nom, prenom, mail, motdepasse, validation) VALUES("'.$derid.'", "'.mb_strtoupper($_POST['nom']).'", "'.ucfirst($_POST['prenom']).'", "'.$_POST['email'].'", "'.hash('sha512', $_POST['mdp']).'", "0")');

	$req = req('INSERT INTO __userverif(iduser, code) VALUES("'.$derid.'", "'.$code.'")');
$sujet = $site['nom'].' - Validation de votre inscription';
$message = '<p style="font-family: Tahoma, Geneva, sans-serif;">Bonjour !</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Pour terminer votre inscription, vous devez cliquer sur lien ci-dessous :</p>
<p><a href="'.siteURL().'inscription?code='.$code.'">'.siteURL().'inscription?code='.$code.'</a></p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Vous pourrez par la suite r&eacute;server vos places depuis notre site avec votre compte. </p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Vous &ecirc;tes susceptible de recevoir d\'autres mails pour vos r&eacute;servations.</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">&nbsp;</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Cordialement,</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">L\'&eacute;quipe '.$site['nom'].'</p>';
$destinataire = $email;
$headers = "From: \"".$site['nom']."\"<site@penn-ar-rock.fr>\n";
$headers .= "Reply-To: contact@penn-ar-rock.fr\n";
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";

if(mail($destinataire,$sujet,$message,$headers)){
	alerte('Votre inscription est termin&eacute;e ! 
	Vous devez confirmer votre inscription en cliquant sur le lien dans le mail que vous allez recevoir pour pouvoir poursuivre votre r&eacute;servation. 
	Si vous n\'avez pas re&ccedil;u notre mail, v&eacute;rifiez votre dossier spams. (Le mail peut mettre jusqu\'&agrave; 20 minutes &agrave; arriver)', 'succes');

}else{
	alerte('Erreur serveur : l\'envoi par email a &eacute;chou&eacute; !', 'danger');
}}
}else{
	alerte('Erreur lors de l\'inscription : les deux mots de passe ne correspondent pas !', 'danger');
	$varerror = "yes";
}
}else{alerte('Erreur lors de l\'inscription : vous devez indiquer votre adresse email', 'danger');
	$varerror = "yes";
}}else{ 
	alerte('Erreur lors de l\'inscription : vous devez confirmer votre mot de passe', 'danger');
	$varerror = "yes";
}}else{
	alerte('Erreur lors de l\'inscription : vous devez indiquer un mot de passe', 'danger');
	$varerror = "yes";
}}else{
	alerte('Erreur lors de l\'inscription : vous devez indiquer votre pr&eacute;nom', 'danger');
	$varerror = "yes";
}}else{
	alerte('Erreur lors de l\'inscription : vous devez indiquer votre nom', 'danger');
}

if(isset($varerror) && $varerror == "yes"){?>
<a href="javascript:history.back()" onClick="history.back()" class="btn btn-info">Retourner au formulaire</a> 
<?php }
echo $theme['page_pied'];
}
function inscription_mailvalidation(){
	global $theme;
echo str_replace("{TITRE}", "Confirmation de votre inscription", $theme['page_entete']);


if(isset($_GET['code'])){
	$req = req('SELECT COUNT(*) AS total FROM __userverif WHERE code = "'.$_GET['code'].'"');
	$donnees = fetch($req);
	
	if($donnees['total'] == "0"){
		alert('Erreur lors de la validation : vous avez d&eacute;j&agrave; confirm&eacute; votre compte !', 'attention');
		alert('Redirection en cours... (<a href="accueil">vous pouvez cliquer ici</a>)', 'info');
?>
<meta http-equiv="refresh" content="3; URL=accueil">
<?php
					}else{
							$req = req('SELECT * FROM __userverif WHERE code = "'.$_GET['code'].'"');
					$donnees = fetch($req);
					$req = req('SELECT * FROM __utilisateurs WHERE id = "'.$donnees['iduser'].'"');
					$utilisateur = fetch($req);
					
					$req = req('UPDATE __utilisateurs SET validation = "1" WHERE id = "'.$donnees['iduser'].'"');
					$req = req('DELETE FROM __userverif WHERE iduser = "'.$donnees['iduser'].'"');
					$_SESSION['utilisateur'] = $utilisateur['mail'];
					$_SESSION['pass'] = $utilisateur['motdepasse'];
					$_SESSION['nom'] = $utilisateur['nom'];
					$_SESSION['prenom'] = $utilisateur['prenom'];
					$_SESSION['grade'] = $utilisateur['grade'];
					$_SESSION['methodconnex'] = "verifmail";
					
					alerte('Votre compte a &eacute;t&eacute; valid&eacute; ! 
					Vous allez &ecirc;tre redirig&eacute; vers la page des r&eacute;servations de votre compte dans quelques instants... 
					(<a href="accueil">vous pouvez cliquer ici</a>)', 'succes');
					?>

<meta http-equiv="refresh" content="3; URL=accueil">
<?php 
}}else{
	alerte('Redirection en cours... (<a href="accueil">vous pouvez cliquer ici</a>)', 'info');
?>
<meta http-equiv="refresh" content="3; URL=accueil">
<?php }
echo $theme['page_pied'];
}
function moncompte(){
	global $theme, $site, $utilisateur;
	echo str_replace("{TITRE}", "Mon Compte", $theme['page_entete']);
if(authentificationCheck() == 1){
					$alerte = "";
					if(isset($_POST['newmail'])){
						if($utilisateur['validation'] == "0"){
						req('UPDATE __utilisateurs SET mail = "'.$_POST['newmail'].'" WHERE id = "'.$utilisateur['id'].'"');
						$_SESSION['utilisateur'] = $_POST['newmail'];
						$code = genererMDP();
						req('DELETE FROM __userverif WHERE iduser = "'.$utilisateur['id'].'"');
						$req = req('INSERT INTO __userverif(iduser, code) VALUES("'.$utilisateur['id'].'", "'.$code.'")');
$sujet = $site['nom'].' - Validation de votre changement d\'email';
$message = '<p style="font-family: Tahoma, Geneva, sans-serif;">Bonjour !</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Pour terminer votre changement d\'email, vous devez cliquer sur lien ci-dessous :</p>
<p><a href="http://'.siteURL().'/inscription?code='.$code.'">http://'.siteURL().'/inscription?code='.$code.'</a></p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Vous pourrez par la suite r&eacute;server vos places depuis notre site avec votre compte. </p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Vous &ecirc;tes susceptible de recevoir d\'autres mails pour vos r&eacute;servations.</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">&nbsp;</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Cordialement,</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">L\'&eacute;quipe '.$site['nom'].'</p>';
$destinataire = $_POST['newmail'];
$headers = "From: \"".$site['nom']."\"<site@penn-ar-rock.fr>\n";
$headers .= "Reply-To: contact@penn-ar-rock.fr\n";
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
if(mail($destinataire,$sujet,$message,$headers)){
	$alerte = "succes";
}else{
	$alerte = "error";
}
	}else{$alerte = "noautorise";}
					}
	}else{header('Location:connexion?noconnect'); exit();}
						?>
<a href="javascript:history.go(-1)" class="btn btn-default"><i class="fa fa-chevron-left"></i> Retour</a>
<?php 
	if($alerte == "succes"){
		alerte('Votre email a bien &eacute;t&eacute; modifi&eacute; ! 
		Vous devez le confirmer en cliquant sur le lien dans le mail que vous venez de recevoir pour pouvoir poursuivre votre r&eacute;servation. 
		Si vous n\'avez pas re&ccedil;u notre mail, v&eacute;rifiez votre dossier spams.', 'succes');
	}
	if($alerte == "error"){
		alerte('Une erreur est survenue !', 'danger');
	}
	 
	if($alerte == "noautorise"){
		alerte('Vous avez d&eacute;j&agrave; confirm&eacute; votre adresse email. De ce fait, vous ne pouvez pas la changer. 
		Si toutefois vous devez absolument modifier votre adresse, <a href="contact">contactez-nous</a>.', 'info');
	}
?><form action="moncompte" method="post">
<table width="100%" class="table table-bordered table-hover">
  <tr>
    <td width="50%" align="center"><strong>Nom*</strong></td>
    <td width="50%" align="center"><input name="" type="text" value="<?php echo $_SESSION['nom'];?>" disabled/></td>
  </tr>
    <tr>
    <td width="50%" align="center"><strong>Pr&eacute;nom*</strong></td>
    <td width="50%" align="center"><input name="" type="text" value="<?php echo $_SESSION['prenom'];?>" disabled/></td>
  </tr>
    <tr>
    <td width="50%" align="center"><strong>Adresse E-mail</strong></td>
    <td width="50%" align="center"><input name="newmail" type="text" value="<?php echo $_SESSION['utilisateur'];?>"/></td>
  </tr></table><p align="center"><input name="" type="submit" value="Modifier mes donn&eacute;es" class="btn btn-warning" /></p></form>
  <p>* Pour modifier votre nom, pr&eacute;nom et mot de passe, vous devez <a href="contact">nous contacter</a>.
<?php
	echo $theme['page_pied']; 
}
function renvoyerCode(){
	global $utilisateur, $site, $theme;
echo str_replace("{TITRE}", "Email de confirmation", $theme['page_entete']);
	if(authentificationCheck() && ($_SESSION['utilisateur'] == $_GET['renvoyermail'])){
		$req = req('DELETE FROM __userverif WHERE iduser = "'.$utilisateur['id'].'"');
		$code = genererMDP();
		$req = req('INSERT INTO __userverif(iduser, code) VALUES("'.$utilisateur['id'].'", "'.$code.'")');
$sujet = $site['nom'].' - Validation de votre inscription';
$message = '<p style="font-family: Tahoma, Geneva, sans-serif;">Bonjour !</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Pour terminer votre inscription, vous devez cliquer sur lien ci-dessous :</p>
<p><a href="'.siteURL().'inscription?code='.$code.'">'.siteURL().'inscription?code='.$code.'</a></p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Vous pourrez par la suite r&eacute;server vos places depuis notre site avec votre compte. </p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Vous &ecirc;tes susceptible de recevoir d\'autres mails pour vos r&eacute;servations.</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">&nbsp;</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">Cordialement,</p>
<p style="font-family: Tahoma, Geneva, sans-serif;">L\'&eacute;quipe '.$site['nom'].'</p>';
$destinataire = $_SESSION['utilisateur'];
$headers = "From: \"".$site['nom']."\"<site@penn-ar-rock.fr>\n";
$headers .= "Reply-To: contact@penn-ar-rock.fr\n";
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";

if(mail($destinataire,$sujet,$message,$headers)){
	alerte('Un nouveau mail a été envoyé ! 
	Vous devez confirmer votre inscription en cliquant sur le lien dans le mail que vous allez recevoir pour pouvoir poursuivre votre r&eacute;servation. 
	Si vous n\'avez pas re&ccedil;u notre mail, v&eacute;rifiez votre dossier spams. (Le mail peut mettre jusqu\'&agrave; 20 minutes &agrave; arriver)', 'succes');
}else{
	alerte('Erreur serveur : l\'envoi par email a &eacute;chou&eacute; !', 'danger');
}
	}else{
	alerte('Bien joué petit malin, mais tu n\'as pas le droit de faire ça !', 'danger');
	}
echo $theme['page_pied']; 
}
function inscription(){
	global $theme;
	if(isset($_POST['nom'])){
		inscription_check();
	}else if(isset($_GET['code'])){
		inscription_mailvalidation();
	}else if(isset($_GET['renvoyermail'])){
		renvoyerCode();
	}else{
		if(authentificationCheck()){header('Location:connexion'); exit();}
		echo str_replace("{TITRE}", "Cr&eacute;ation de compte", $theme['page_entete']);
	?>
    
<div class="panel panel-default"><div class="panel-body">
<form action="inscription" method="post" class="form-horizontal">

<div class="form-group"><label for="nom" title="Saisissez votre nom" class="col-lg-2 control-label">Nom</label>
<div class="col-lg-10"><input type="text" name="nom" id="nom" class="form-control"/></div></div>

<div class="form-group"><label for="prenom" title="Saisissez votre pr&eacute;nom" class="col-lg-2 control-label">Pr&eacute;nom</label>
<div class="col-lg-10"><input type="text" name="prenom" class="form-control"/></div></div>

<div class="form-group"><label for="mdp" title="Saisissez un mot de passe de votre choix" class="col-lg-2 control-label">Mot de passe</label>
<div class="col-lg-10"><input type="password" name="mdp" autocomplete="off" class="form-control"/></div></div>

<div class="form-group"><label for="mdp2" title="Confirmez le mot de passe" class="col-lg-2 control-label">Confirmation du mot de passe</label>
<div class="col-lg-10"><input type="password" name="mdp2" autocomplete="off" class="form-control"/></div></div>

<div class="form-group"><label for="email" title="Saisissez votre adresse e-mail" class="col-lg-2 control-label">Adresse e-mail</label>
<div class="col-lg-10"><input type="text" name="email" class="form-control"/></div></div>

<button type="submit" class="btn btn-success">S'inscrire</button> ou <a href="" title="Annuler" class="btn btn-danger">Annuler</a>
</form></div></div><?php
	echo $theme['page_pied'];
	}
}
function identification($lien){
	switch($lien){
		case "deconnexion":
			deconnexion();
			break;
		case "inscription":
			inscription();
			break;
		case "moncompte":
			moncompte();
			break;
		default:
			connexion();
			break;
	}
}
?>