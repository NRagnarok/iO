<?php
function composants(){
	global $site;
	if ($dir = opendir($site['racine']."/composants/")) {
?>
<div id="row">
	<div id="col_lg_12">
    	<div class="table-responsive">
        	<table class="table table-bordered table-hover table-striped">
            	<thead>
                	<tr>
    					<th>Nom</th>
    					<th>Version</th>
    					<th>État</th>
   						<th>Outils</th>
          			</tr>
          		</thead>
				<tbody>
<?php
    	while (($file = readdir($dir)) !== false) {
        	if ($file != ".." && $file != ".") {
				if(@$xml = simplexml_load_file($site['racine']."/composants/".$file."/initialisation.xml")){
					foreach($xml as $composant_xml){
						$nom = $composant_xml->nom;
						$version = $composant_xml->version;	
						$desactivable = $composant_xml->desactivable;
						$table = $composant_xml->table;
					}
?>
<tr>
    <td><?php echo $nom; ?></td>
    <td><span class="label label-info"><?php echo $version; ?></span></td>
    <td></td>
    <td>
    	<a class="btn btn-xs btn-success" href=""><i class="fa fa-check"></i> Activer</a>&nbsp;
        <a class="btn btn-xs btn-default" href=""><i class="fa fa-chevron-down"></i> Désactiver</a>&nbsp;
        <a class="btn btn-xs btn-warning" href=""><i class="fa fa-circle-o-notch"></i> Réinitialiser</a>&nbsp;
        <a class="btn btn-xs btn-danger" href=""><i class="fa fa-times"></i> Supprimer</a>&nbsp;
    </td>
</tr>
<?php
				}else{
?>
<tr>
    <td><?php echo $file; ?></td>
    <td><span class="label label-danger">Inconnue</span></td>
    <td><span class="label label-warning">Actif</span></td>
    <td></td>
</tr>
<?php
				}
            }
        }
?>
				</tbody>
   			</table>
      	</div>
	</div>
</div>
<?php
    }
}
?>