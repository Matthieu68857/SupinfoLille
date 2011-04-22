<?php

	require_once('../inclusions/initialisation.php');

	if(isset($_GET['action']) && !empty($_GET['action'])){
		switch ($_GET['action']){
			case "import":
				showImport();
				break;
			case "importer":
				if(
					isset($_POST['col1']) && 
					isset($_POST['col2']) && 
					isset($_POST['col3']) && 
					isset($_POST['col4']) && 
					isset($_POST['col5']) && 
					isset($_POST['col6']) && 
					isset($_POST['col7']) && 
					isset($_POST['col8']) && 
					isset($_POST['col9']) && 
					isset($_POST['col10']) && 
					isset($_POST['col11']) && 
					isset($_POST['col12']) && 
					isset($_POST['col13'])
				){
					importer();
				}
				break;
			case "export":
				exporter();
				break;
			default:
				header('location: index.php?erreur=Mauvaise action');
				break;
		}
	} else {
		header('location: index.php?erreur=Mauvaise action');
	}
	
function showImport(){

	global $BDD;

	require_once('../inclusions/layout/haut.php');
?>
<div id="sbn">
	<div id="menuSBN">
		<div class="separateur"></div>
		<div class="choix" title="Entreprises"><a href="index.php">Entreprises</a></div>
		<div class="separateur"></div>
		<div class="choix selected" title="Importer des entreprises et contacts avec un fichier .csv"><a href="gerer.php?action=import">Importer</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Exporter les <?php echo getNombreEntreprises(); ?> entreprises et les <?php echo getNombreContacts(); ?> contacts dans un fichier .csv"><a href="gerer.php?action=export">Exporter</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Afficher les <?php echo getNombreEntreprises(); ?> entreprises et les <?php echo getNombreContacts(); ?> contacts dans un même tableau"><a href="base.php">Afficher toutes les données</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Afficher les <?php echo getNombreDoublons(); ?> doublon(s)"><a href="doublons.php">Afficher les doublons</a></div>
		<div class="separateur"></div>
	</div>
	<div id="contenuSBN">
		<p class="center" style="color: red; font-size: 20px;">
	    	La colonne avec le nom et pr&eacute;nom du contact peut &ecirc;tre remplac&eacute; par une colonne avec le nom du contact ET une colonne avec le pr&eacute;nom du contact.<br />Toutes les autres colonnes sont obligatoires.<br />Utiliser la colonne 13 seulement si il y a une colonne avec le nom du contact et une colonne avec le pr&eacute;nom du contact.
		</p>
	    <form action="gerer.php?action=importer" method="post" enctype="multipart/form-data" id="importer">
			<label for="separateur">Séparateur : </label>
			<input type="text" id="separateur" value=";" /><br />
	<?php
		for($i = 1; $i <= 13; $i++){
	?>
			<label for="col<?php echo $i; ?>">Colonne <?php echo $i; ?> : </label>
			<select name="col<?php echo $i; ?>" id="col<?php echo $i; ?>">
				<option value="0" selected="selected">Colonne vide</option>
				<option value="entreprise">Nom de l&apos;entreprise</option>
				<option value="contact">Nom et pr&eacute;nom du contact</option>
				<option value="nom">Nom du contact</option>
				<option value="prenom">Pr&eacute;nom du contact</option>
				<option value="role">Role du contact</option>
				<option value="adresse">Adresse</option>
				<option value="cp">Code postal</option>
				<option value="ville">Ville</option>
				<option value="telephone">T&eacute;l&eacute;phone</option>
				<option value="fax">Fax</option>
				<option value="email">Email</option>
				<option value="site">Site</option>
				<option value="thematique">Thematique</option>
				<option value="infos">Infos</option>
			</select>
			<br />
	<?php
		}
	?>
			<label for="csv">Fichier .CSV (Encod&eacute; en UTF-8): </label>
			<input type="file" name="csv" id="csv" />
			<br />
			<input type="submit" value="Importer" />
		</form>
	</div>
	<div style="clear:both;"></div>
</div>
<?php
	require_once('../inclusions/layout/bas.php');
}

function exporter(){
	
	global $BDD;

	header("Pragma: public"); 
	header("Expires: 0"); 
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Content-Type: application/force-download"); 
	header("Content-Type: application/octet-stream"); 
	header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=base_SBN.csv;"); 
	header("Content-Transfer-Encoding: binary");
	
	$lines = array();
	$entreprises = getEntreprises(0, getNombreEntreprises());
	
	foreach($entreprises as $e){
		$contacts = $e->getContacts();
		
		if(preg_match("#;jsession#i", $e->getSite())){
			$e->setSite('"'.$e->getSite().'"');
		}
		
		if(count($contacts) > 0){
			foreach($contacts as $c){
				$lines[] = 
				$e->getNom() . ";" . 
				$c->getNom() . ";" . 
				$c->getRole() . ";" . 
				$e->getAdresse() . ";" . 
				$e->getCP() . ";" . 
				$e->getVille() . ";" . 
				$c->getTelephone() . ";" . 
				$c->getFax() . ";" . 
				$c->getEmail() . ";" . 
				$e->getSite() . ";" . 
				$e->getThematique() . ";" . 
				$e->getInfos();
			}
		} else {
			$lines[] = 
			$e->getNom() . ";;;" . 
			$e->getAdresse() . ";" . 
			$e->getCP() . ";" . 
			$e->getVille() . ";;;;" . 
			$e->getSite() . ";" . 
			$e->getThematique() . ";" . 
			$e->getInfos();
		}
	}
	
	foreach($lines as $line){
    	echo preg_replace("#&apos;#", "'", preg_replace("#\n#", "", utf8_decode(html_entity_decode($line)))."\n");
    }
}

function importer(){

	/* Determination de l'emplacement des colonnes */

	GLOBAL $i, $index, $BDD;
	$i = 0;
	checkCol($_POST['col1']);
	checkCol($_POST['col2']);
	checkCol($_POST['col3']);
	checkCol($_POST['col4']);
	checkCol($_POST['col5']);
	checkCol($_POST['col6']);
	checkCol($_POST['col7']);
	checkCol($_POST['col8']);
	checkCol($_POST['col9']);
	checkCol($_POST['col10']);
	checkCol($_POST['col11']);
	checkCol($_POST['col12']);
	checkCol($_POST['col13']);
	
	/* Lecture du fichier */
	
	if ($_FILES['csv']['error']) {   
    	switch ($_FILES['csv']['error']){   
        	case 1: // UPLOAD_ERR_INI_SIZE   
            	echo "Le fichier depasse la limite autorisee par le serveur (fichier php.ini) !";   
                break;   
            case 2: // UPLOAD_ERR_FORM_SIZE   
                echo "Le fichier depasse la limite autorisee dans le formulaire HTML !";   
                break;   
            case 3: // UPLOAD_ERR_PARTIAL   
            	echo "L'envoi du fichier a ete interrompu pendant le transfert !";   
                break;   
            case 4: // UPLOAD_ERR_NO_FILE   
                echo "Le fichier que vous avez envoye a une taille nulle !";   
                break;   
          }   
	} else if(strtolower(substr($_FILES['csv']['name'], -3, 3)) != "csv"){  
		echo "Ce n'est pas un fichier .CSV !";
	} else {
		if(!$fp = fopen($_FILES['csv']['tmp_name'],"r")){
			echo "Erreur lors de la lecture du fichier";
		} else {
			$csv = array();
			while (!feof($fp)) {
  				$csv[] = fgets($fp, 4096);
			}
			fclose($fp);
		}
	}
	
	if(isset($csv) && !empty($csv)){
		foreach($csv as $ligne){
			if(!empty($ligne)){
				$entreprise_id = 0;
				if(isset($_POST['separateur']) && !empty($_POST['separateur'])){
					$separateur = $_POST['separateur'];
				} else {
					$separateur = ";";
				}
				if($separateur = ";"){
					$ligne = preg_replace("#;jsession#i", "#jsession", $ligne);
				}
				$colonne = explode($separateur, $ligne);
				//utf8_encode($colonne);
				
				if($separateur = ";"){
					$colonne = preg_replace("@#jsession@i", ";jsession", $colonne);
					$colonne[$index['site']] = preg_replace('#"#', "", $colonne[$index['site']]);
				}
				
				/* Verifie si l'entreprise existe deja */
				
				$e = new Entreprise(
							$BDD, 
							0, 
							format($colonne[$index['entreprise']]), 
							format($colonne[$index['adresse']]), 
							format($colonne[$index['cp']]), 
							format($colonne[$index['ville']]), 
							format($colonne[$index['site']]), 
							format(StringOperation::sansAccent($colonne[$index['thematique']])), 
							format($colonne[$index['infos']])
						);
				$entreprises = getEntreprises(0, getNombreEntreprises(0, $e->getNom()), 0, $e->getNom());
				if(empty($entreprises)){
					$e->save();
					$entreprise_id = $e->getId();
				} else {
					$save = true;
					foreach($entreprises as $entreprise){
						if($e->compareTo($entreprise)){
							$e->fusionWith($entreprise);
							$entreprise_id = $entreprise->getId();
							$save = false;
						} else {
							if(!$entreprise->isDoublon()){
								$entreprise->setDoublon();
							}
						}
					}
					if($save && $e->getNom() != ""){
						$e->save();
						$e->setDoublon();
						$entreprise_id = $e->getId();
					}
				}
			
				/* Verifie si le contact existe deja */
			
				if(isset($index['contact']) && !empty($index['contact'])){
					$contact = format($colonne[$index['contact']]);
				} else {
					$contact = format($colonne[$index['prenom']])." ".format($colonne[$index['nom']]);
				}
					
				$e = new Entreprise($BDD, $entreprise_id);
				
				if(!preg_match("#(.*@.*|.*[(]at[)].*|.*[(]AT[)].*)#i", $colonne[$index['email']])){
					$e->setInfos($colonne[$index['email']]);
					$e->save();
					$colonne[$index['email']] = "";
				}
				
				$c = new Contact(
							$BDD, 
							0, 
							false, 
							$contact, 
							format($colonne[$index['role']]), 
							format($colonne[$index['telephone']]), 
							format($colonne[$index['fax']]), 
							format($colonne[$index['email']]), 
							$entreprise_id
						);
				
				$contacts = $e->getContacts();
				if(empty($contacts)){
					$c->save();
				} else {
					$save = true;
					foreach($contacts as $contact){
						if($c->compareTo($contact)){
							$c->fusionWith($contact);
							$save = false;
						}
					}
					if($save){
						$c->save();
					}
				}
			}
		}
	}
	
	/* Pour enlever le problème d'accents */
	
	$entreprises = getEntreprises(0, getNombreEntreprises());
	
	foreach($entreprises as $e){
		$e->setNom(utf8_encode($e->getNom()));
		$e->setAdresse(utf8_encode($e->getAdresse()));
		$e->setCP(utf8_encode($e->getCP()));
		$e->setVille(utf8_encode($e->getVille()));
		$e->setSite(utf8_encode($e->getSite()));
		$e->setThematique(utf8_encode($e->getThematique()));
		$e->setInfos(utf8_encode($e->getInfos()));
		$contacts = $e->getContacts();
		foreach($contacts as $c){
			$c->setNom(utf8_encode($c->getNom()));
			$c->setRole(utf8_encode($c->getRole()));
			$c->setTelephone(utf8_encode($c->getTelephone()));
			$c->setFax(utf8_encode($c->getFax()));
			$c->setEmail(utf8_encode($c->getEmail()));
			$c->save();
		}
		$e->save();
	}
	
	header('location: index.php');
}

function format($p_str){
	return preg_replace("#'#", "'", StringOperation::noBackslash(utf8_decode($p_str)));
}

function checkCol($col){
		GLOBAL $i, $index;
		switch ($col) {
			case 'entreprise':
				$index['entreprise'] = $i++;
				break;
			case 'contact':
				$index['contact'] = $i++;
				break;
			case 'nom':
				$index['nom'] = $i++;
				break;
			case 'prenom':
				$index['prenom'] = $i++;
				break;
			case 'role':
				$index['role'] = $i++;
				break;
			case 'adresse':
				$index['adresse'] = $i++;
				break;
			case 'cp':
				$index['cp'] = $i++;
				break;
			case 'ville':
				$index['ville'] = $i++;
				break;
			case 'telephone':
				$index['telephone'] = $i++;
				break;
			case 'fax':
				$index['fax'] = $i++;
				break;
			case 'email':
				$index['email'] = $i++;
				break;
			case 'site':
				$index['site'] = $i++;
				break;
			case 'thematique':
				$index['thematique'] = $i++;
				break;
			case 'infos':
				$index['infos'] = $i++;
				break;
		}
	}

?>