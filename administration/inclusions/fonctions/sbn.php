<?php

	require_once("../../inclusions/fonctions/sbn.php");
	
/* ########## Avoir le nombre de contacts ########## */

	function getNombreContacts(){
		
		global $BDD;
		
		$result = $BDD->select("COUNT(*) AS NB", "SBN_CONTACTS");
		return $result[0]->NB;
	}
	
/* ########## Avoir la date a mettre dans la bdd ########## */

	function convertToMySQLDate($p_date){
		$date = explode("/", $p_date);
		return $date[2].$date[1].$date[0];
	}
	
/* ########## Avoir le lien de modification ########## */

	function getModifLink($p_id){
		return '<a href="entreprise.php?id='.$p_id.'">Modifier</a>';
	}
	
/* ########## Creer entreprise ########## */

	function creerEntreprise($p_nom = "", $p_adresse = "", $p_cp = "", $p_ville = "", $p_site = "", $p_thematique = "", $p_infos = ""){
		
		global $BDD;
		
		$e = new Entreprise($BDD, "0", $p_nom, $p_adresse, $p_cp, $p_ville, $p_site, $p_thematique, $p_infos);
		$e->save();
		return $e->getId();
	}
	
/* ########## Modifier entreprise ########## */

	function modifierEntreprise($p_id, $p_nom = "", $p_adresse = "", $p_cp = "", $p_ville = "", $p_site = "", $p_thematique = "", $p_infos = ""){
		
		global $BDD;
		
		if($p_id != 0){
			$e = new Entreprise($BDD, $p_id, $p_nom, $p_adresse, $p_cp, $p_ville, $p_site, $p_thematique, $p_infos);
			$e->save();
		}
	}
	
/* ########## Supprimer entreprise ########## */

	function supprimerEntreprise($p_id){
		
		global $BDD;

		if($p_id != 0){
			$e = new Entreprise($BDD, $p_id);
			$e->delete();
		}
	}
	
/* ########## Uploader un fichier ########## */
	
	function uploadFile($file, $name){
		if (($file['error'] == 0) && ($file['size'] <= 2097152)) {
			$fileName = explode('.', $file['name']);
			$ext = $fileName[count($fileName) - 1];
			$name = preg_replace('# #', '_', StringOperation::sansAccent(StringOperation::noBackslash($name))).'.'.$ext;
			move_uploaded_file($file['tmp_name'], '../../sbn/fichiers/'.$name);
			return $name;
		}
		return "";
	}
	
/* ########## Avoir le nombre de doublons ########## */
	
	function getNombreDoublons(){
		
		global $BDD;
		
		$results = $BDD->select(
					"COUNT(*) AS NB", 
					"SBN_DOUBLONS"
				);
		return $results[0]->NB;
	}
	
/* ########## Avoir les entreprises en doublons ########## */
	
	function getEntreprisesDoublons($p_min = "0", $p_max = "30"){
		
		global $BDD;
		
		$results = $BDD->select(
					"*", 
					"SBN_VW_DOUBLONS",
					"LIMIT ".$p_min.",".$p_max
				);
		$entreprises = array();
		foreach($results as $r){
			array_push(
				$entreprises, 
				new Entreprise(
					$BDD, 
					$r->entreprise_id, 
					$r->entreprise_nom, 
					$r->entreprise_adresse, 
					$r->entreprise_cp, 
					$r->entreprise_ville, 
					$r->entreprise_site, 
					$r->entreprise_thematique, 
					$r->entreprise_infos
				)
			);
		}
		return $entreprises;
	}
	
/* ########## Supprimer un doublon ########## */
	
	function supprimerDoublon($p_id){
		
		global $BDD;
		
		$BDD->delete(
			"SBN_DOUBLONS",
			"doublon_entreprise = :id",
			array("id" => $p_id)
		);
	}
	
/* ########## Couper une chaine ########## */
	
	function couper($p_chaine, $p_nombre){
		if(strlen($p_chaine) > $p_nombre){
			$chaine = substr($p_chaine, 0, $p_nombre) . "<br />" . couper(substr($p_chaine, 40, strlen($p_chaine)), $p_nombre);
			return $chaine;
		}
		return $p_chaine;
	}

?>