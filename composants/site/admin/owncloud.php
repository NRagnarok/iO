<?php
function owncloudAdduser($utilisateur, $motdepasse, $groupe){
	$ownAdminname = 'adm_systeme';
 	$ownAdminpassword = 'fd165IKJKGE5486rdgr';
	$url = 'http://' . $ownAdminname . ':' . $ownAdminpassword . '@cloud.penn-ar-rock.fr/ocs/v1.php/cloud/users';
	$ownCloudPOSTArray = array('userid' => $utilisateur, 'password' => $motdepasse);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $ownCloudPOSTArray);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	$groupUrl = $url . '/' . $utilisateur . '/' . 'groups';
	$ownCloudPOSTArrayGroup = array('groupid' => $groupe);
	$ch = curl_init($groupUrl);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $ownCloudPOSTArrayGroup);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);	
}

function owncloudChangePass($utilisateur, $motdepasse){
 	$ownAdminname = 'adm_systeme';
 	$ownAdminpassword = 'fd165IKJKGE5486rdgr';
	$url = 'http://' . $ownAdminname . ':' . $ownAdminpassword . '@cloud.penn-ar-rock.fr/ocs/v1.php/cloud/users';
	$userUrl = $url . '/' . $utilisateur;
    $url =$userUrl;
	$curl = curl_init($url);
	$data = array('key' => 'password', 'value' => $motdepasse);
	//curl_setopt($curl, CURLOPT_URL,$url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);	
	curl_close($curl);
}

function owncloudChangeGroupe($utilisateur, $groupe){
 	$ownAdminname = 'adm_systeme';
 	$ownAdminpassword = 'fd165IKJKGE5486rdgr';
	$url = 'http://' . $ownAdminname . ':' . $ownAdminpassword . '@cloud.penn-ar-rock.fr/ocs/v1.php/cloud/users';
	$groupUrl = $url . '/' . $utilisateur . '/groups';
    $url =$groupUrl;
	
	
	$curl = curl_init($url);
	$data = array('groupid' => 'Artistes');
	//curl_setopt($curl, CURLOPT_URL,$url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);	
	curl_close($curl);
	
	$curl = curl_init($url);
	$data = array('groupid' => 'Bénévoles');
	//curl_setopt($curl, CURLOPT_URL,$url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);	
	curl_close($curl);
	
	$curl = curl_init($url);
	$data = array('groupid' => 'Conseil d\'Administration');
	//curl_setopt($curl, CURLOPT_URL,$url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);	
	curl_close($curl);
	
	$ownCloudPOSTArrayGroup = array('groupid' => $groupe);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $ownCloudPOSTArrayGroup);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
}

function owncloudChangeNom($utilisateur, $nom){
 	$ownAdminname = 'adm_systeme';
 	$ownAdminpassword = 'fd165IKJKGE5486rdgr';
	$url = 'http://' . $ownAdminname . ':' . $ownAdminpassword . '@cloud.penn-ar-rock.fr/ocs/v1.php/cloud/users';
	$userUrl = $url . '/' . $utilisateur;
    $url =$userUrl;
	$curl = curl_init($url);
	$data = array('key' => 'display', 'value' => $nom);
	//curl_setopt($curl, CURLOPT_URL,$url);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);	
	curl_close($curl);
}

function owncloudRemoveuser($utilisateur){
 	$ownAdminname = 'adm_systeme';
 	$ownAdminpassword = 'fd165IKJKGE5486rdgr';
	$url = 'http://' . $ownAdminname . ':' . $ownAdminpassword . '@cloud.penn-ar-rock.fr/ocs/v1.php/cloud/users';
	$delUrl = $url . '/' . $utilisateur;
    $url =$delUrl;
    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $result = curl_exec($ch);
    curl_close($ch);
}
?>