<?php

/* ************ getDerniersDocuments() ************
 * 
 * Renvoit les derniers documents
 * 
 * @return array tous les documents
 *
 */

	function getDerniersDocuments(){

		global $BDD;
	
		$documents = $BDD->select(
			"document_nom",
			"TB_DOCUMENTS",
			"ORDER BY document_id DESC LIMIT 0,10"
		);
		
		return $documents;
	}

/* ************ ajouterDocument() ************
 * 
 * Ajoute un document dans la BDD et envoie une notification
 * 
 */

	function ajouterDocument($p_nom, $p_chemin, $p_ext, $p_student_id, $p_matiere_id){
	
		global $BDD;
		
		if($p_nom == ""){
			$p_nom = $p_chemin;
		}
	
		$BDD->insert(
			"TB_DOCUMENTS",
			array("document_nom","document_chemin","document_extension","document_date","student_id","matiere_id"),
			array("?","?","?","CURRENT_TIMESTAMP()","?","?"),
			array($p_nom, $p_chemin, $p_ext, $p_student_id, $p_matiere_id)
		);
		
		mail(GBL_EMAIL_ADMIN, $_SESSION['user']['prenom'] . "." . $_SESSION['user']['nom'] . "@" . GBL_NDD, "Notification : Nouveau Document");
	
		return $matieres;
	
	}


/* ************ getAllMatieres() ************
 * 
 * Renvoit toutes les matieres disponnibles
 * 
 * @return array toutes les matieres
 *
 */

	function getAllMatieres(){
	
		global $BDD;
	
		$matieres = $BDD->select(
			"*",
			"TB_MATIERES",
			"ORDER BY matiere_nom_complet"
		);
	
		return $matieres;
	
	}
	

/* ************ getMatieresDocuments() ************
 * 
 * Renvoit toutes les matieres des documents en parametres
 * 
 * @return array toutes les matieres
 *
 */

	function getMatieresDocuments($p_in){
	
		global $BDD;
	
		$matieres = $BDD->select(
			"m.matiere_nom",
			"TB_MATIERES m JOIN TB_DOCUMENTS d ON d.matiere_id = m.matiere_id",
			"WHERE d.document_id IN(".$p_in.")"
		);
	
		return $matieres;
	
	}


/* ************ majNombreTelechargements() ************
 * 
 * Met à jour le compteur de telechargement des documents
 * 
 */

	function majNombreTelechargements($p_in){
	
		global $BDD;
		
		$BDD->update(
			"TB_DOCUMENTS",
			array("document_telechargements = document_telechargements + 1"),
			"document_id IN (".$p_in.")"
		);
	
	}
	
/* ************ getArchive() ************
 * 
 * Cree l'archive avec tous les documents et renvoit son chemin
 * 
 * @return string chemin de l'archive
 */

	function getArchive($p_documents){
	
		$in = "";
	
		foreach($p_documents as $document){
			$in .= $document . ",";
		}
		
		$in = substr($in, 0, strlen($in)-1);
	
		$sources = getSourcesDocuments($in);
		
		$date = date("YmdHis");
	
		$nom = 'telechargements/' . $_SESSION['user']['idbooster'] . ' - ' . $date . '.zip';
	
 		$archive = new PclZip($nom);
 	
 		$matieres = getMatieresDocuments($in);
 		$i = 0;
 		 		
 		foreach($sources as $source){
 			$archive->add($source, PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, $_SESSION['user']['idbooster']."/".$matieres[$i]->matiere_nom);
 			$i++;
 		}
 		
 		majNombreTelechargements($in);
 		
 		return $nom;
	
	}

/* ************ getSourcesDocuments() ************
 * 
 * Retourne les chemins sources de tous les documents passes en paramètres
 * 
 * @return array tableau avec les chemins de tous les documents
 */

	function getSourcesDocuments($p_in){
		
		global $BDD;
	
		$sources = $BDD->select(
			"d.document_chemin, d.matiere_id, m.matiere_cursus",
			"TB_DOCUMENTS d JOIN TB_MATIERES m ON (d.matiere_id = m.matiere_id)",
			"WHERE d.document_id IN (".$p_in.")"
		);
		
		$chemins = array();
				
		foreach($sources as $source){
			array_push($chemins,"documents/".$source->matiere_cursus."/".$source->matiere_id."/".$source->document_chemin);
		}
		
		return $chemins;
	}

/* ************ printListeDocuments() ************
 * 
 * Affiche la liste des documents pour la matiere
 * 
 */

	function printListeDocuments($p_matiere){
	
		global $BDD;
	
		$documents = $BDD->select(
			"*",
			"TB_DOCUMENTS",
			"WHERE matiere_id = ? AND document_status != 0",
			array($p_matiere)
		);
		
		if(count($documents)==0){
		
			echo "<p id='recherche_vide'>Aucun document pour cette catégorie actuellement.</p>";
		
		} else {
		
			echo "<ul>";

			foreach($documents as $document){
				echo "<div class='document' title='" . $document->document_id . "'>" . 
					"<img src='../images/" . $document->document_extension . ".png' title='" . $document->document_nom . "'/>" .
					"<br/>" . $document->document_nom . "</div>";
			}
		
			echo "</ul>";
		
		}
	
	}


/* ************ printListeMatieres() ************
 * 
 * Affiche la liste des matieres dispos pour la promo
 * 
 */

	function printListeMatieres($p_promo){
	
		global $BDD;
	
		$matieres = $BDD->select(
			"*",
			"TB_MATIERES",
			"WHERE matiere_cursus = ? ORDER BY matiere_nom",
			array($p_promo)
		);
	
		echo "<h3>" . $p_promo . "</h3>";
		
		echo "<ul>";
	
		foreach($matieres as $matiere){
			echo "<li class='matiere' title='" . $matiere->matiere_id . "'>" . $matiere->matiere_nom . "</li>";
		}
		
		echo "</ul>";
	
	}


/* ************ uploadDocument() ************
 * 
 * Upload un document
 * 
 */

	function uploadDocument($p_fichier, $p_nom, $p_matiere){
		
		global $upload;
		
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/documents/uploads/';
		$filePath = time() . "_" . preg_replace("# #","", stripAccents($p_fichier['name']));
		$targetFile =  str_replace('//','/',$targetPath) . $filePath;
		
	    if(empty($p_fichier['name'])){
	        $upload = "Aucun fichier sélectionné.";
	    }

	    if(!is_uploaded_file($p_fichier['tmp_name'])){
	        $upload = "Le fichier n'a pas pu être uploadé.";
	    }
	
	    if($p_fichier['name'] != ".htaccess"){
			if(!move_uploaded_file($p_fichier['tmp_name'], $targetFile)){
		        $upload = "Impossible de copier le fichier.";
		    } else {
		        $upload = "Le fichier a bien été uploadé.";
		    }
		} else {
			$upload = "Non Benjamin ça ne marche pas.";
		}
		
		$ext = explode(".", $filePath);
		$ext = $ext[count($ext)-1];	
		
		if($ext == "php" || $ext == "html" || $ext == "htm" || $ext == "js" || $ext == "css"){
			$ext = "web";
		} elseif($ext != "zip" && $ext != "xls" && $ext != "pdf" && $ext != "doc") {
			$ext = "autre";
		}
			
		if(file_exists($targetFile)){
			ajouterDocument($p_nom, $filePath, $ext, $_SESSION['user']['idbooster'], $p_matiere);
		}
	
	}

?>