<?php

/* ************ getCategories() ************
 * 
 * Renvoie toutes les catégories
 *
 */
 
	function getCategories($p_nom){
		
		global $BDD;
		
		if(!empty($p_nom)){
			$where = "WHERE LOWER(categorie_nom) LIKE LOWER(:nom)";
		} else {
			$where = "";
		}
		$categoriesReq = $BDD->select(
			"categorie_id, categorie_nom, categorie_admin",
			"TB_CATEGORIES",
			$where,
			array('nom' => "%".$p_nom."%")
		);
		$categories = array();
		foreach($categoriesReq as $categorie){
			if($categorie->categorie_admin == "1"){
				$admin = "Catégorie admin";
			} else {
				$admin = "Catégorie normale";
			}
			array_push($categories, array('id' => $categorie->categorie_id, 'nom' => $categorie->categorie_nom, 'type' => $admin));
		}
		return $categories;
	}

/* ************ getGroupes() ************
 * 
 * Renvoie tous les groupes
 *
 */
 
	function getGroupes($p_nom){
		
		global $BDD;
		
		if(!empty($p_nom)){
			$where = "WHERE LOWER(groupe_nom) LIKE LOWER(:nom)";
		} else {
			$where = "";
		}
		$groupesReq = $BDD->select(
			"groupe_id, groupe_nom",
			"TB_GROUPES",
			$where,
			array('nom' => "%".$p_nom."%")
		);
		$groupes = array();
		foreach($groupesReq as $groupe){
			array_push($groupes, array('id' => $groupe->groupe_id, 'nom' => $groupe->groupe_nom));
		}
		return $groupes;
	}

/* ************ getUtilisateurs() ************
 * 
 * Renvoie tous les utilisateurs
 *
 */
 
	function getUtilisateurs($p_nom){
		
		global $BDD;
		
		if(!empty($p_nom)){
			$where = "WHERE LOWER(student_prenom) LIKE LOWER(:nom) OR LOWER(student_nom) LIKE LOWER(:nom) OR LOWER(student_idbooster) LIKE LOWER(:nom)";
		} else {
			$where = "";
		}
		$utilisateursReq = $BDD->select(
			"student_idbooster, student_prenom, student_nom",
			"TB_STUDENTS",
			$where,
			array('nom' => "%".$p_nom."%")
		);
		$utilisateurs = array();
		foreach($utilisateursReq as $utilisateur){
			array_push($utilisateurs, array('idbooster' => $utilisateur->student_idbooster, 'prenom' => $utilisateur->student_prenom, 'nom' => $utilisateur->student_nom));
		}
		return $utilisateurs;
	}
?>