<?php

/* ########## Chercher les entreprises ########## */

	function getEntreprises($p_min = "0", $p_max = "30", $p_id = 0, $p_nom = "", $p_adresse = "", $p_cp = "", $p_ville = "", $p_site = "", $p_thematique = "", $p_infos = ""){
		
		global $BDD;
		
		$where = "WHERE ";
		$params = array();
		if($p_id != 0){
			$where .= "entreprise_id LIKE :id AND ";
			$params['id'] = '%'.$p_id.'%';
		}
		if($p_nom != ""){
			$where .= "entreprise_nom LIKE :nom AND ";
			$params['nom'] = '%'.$p_nom.'%';
		}
		if($p_adresse != ""){
			$where .= "entreprise_adresse LIKE :adresse AND ";
			$params['adresse'] = '%'.$p_adresse.'%';
		}
		if($p_cp != ""){
			$where .= "entreprise_cp LIKE :cp AND ";
			$params['cp'] = '%'.$p_cp.'%';
		}
		if($p_ville != ""){
			$where .= "entreprise_ville LIKE :ville AND ";
			$params['ville'] = '%'.$p_ville.'%';
		}
		if($p_site != ""){
			$where .= "entreprise_site LIKE :site AND ";
			$params['site'] = '%'.$p_site.'%';
		}
		if($p_thematique != ""){
			$where .= "entreprise_thematique LIKE :thematique AND ";
			$params['thematique'] = '%'.$p_thematique.'%';
		}
		if($p_infos != ""){
			$where .= "entreprise_infos LIKE :infos AND ";
			$params['infos'] = '%'.$p_infos.'%';
		}
		$where .= " 1 = 1";
		
		$results = $BDD->select(
						"*",
						"SBN_ENTREPRISES",
						$where." ORDER BY entreprise_nom ASC LIMIT ".$p_min.",".$p_max,
						$params
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

/* ########## Avoir le nombre d'entreprises ########## */

	function getNombreEntreprises($p_id = 0, $p_nom = "", $p_adresse = "", $p_cp = "", $p_ville = "", $p_site = "", $p_thematique = "", $p_infos = ""){
		
		global $BDD;
		
		$where = "WHERE ";
		$params = array();
		if($p_id != 0){
			$where .= "entreprise_id LIKE :id AND ";
			$params['id'] = '%'.$p_id.'%';
		}
		if($p_nom != ""){
			$where .= "entreprise_nom LIKE :nom AND ";
			$params['nom'] = '%'.$p_nom.'%';
		}
		if($p_adresse != ""){
			$where .= "entreprise_adresse LIKE :adresse AND ";
			$params['adresse'] = '%'.$p_adresse.'%';
		}
		if($p_cp != ""){
			$where .= "entreprise_cp LIKE :cp AND ";
			$params['cp'] = '%'.$p_cp.'%';
		}
		if($p_ville != ""){
			$where .= "entreprise_ville LIKE :ville AND ";
			$params['ville'] = '%'.$p_ville.'%';
		}
		if($p_site != ""){
			$where .= "entreprise_site LIKE :site AND ";
			$params['site'] = '%'.$p_site.'%';
		}
		if($p_thematique != ""){
			$where .= "entreprise_thematique LIKE :thematique AND ";
			$params['thematique'] = '%'.$p_thematique.'%';
		}
		if($p_infos != ""){
			$where .= "entreprise_infos LIKE :infos AND ";
			$params['infos'] = '%'.$p_infos.'%';
		}
		$where .= " 1 = 1";
		
		$result = $BDD->select(
							"COUNT(*) AS NB", 
							"SBN_ENTREPRISES",
							$where,
							$params
						);
		return $result[0]->NB;
	}

/* ########## Chercher les stages ########## */

	function getStages($p_min = "0", $p_max = "30"){
		
		global $BDD;
		
		$results = $BDD->select(
						"*",
						"SBN_STAGES",
						"ORDER BY stage_date DESC LIMIT ".$p_min.",".$p_max
					);
		$stages = array();
		foreach($results as $r){
			array_push(
				$stages, 
				new Stage(
					$BDD, 
					$r->stage_id, 
					false, 
					$r->stage_description, 
					$r->stage_date, 
					$r->stage_fichier, 
					$r->stage_entreprise
				)
			);
		}
		return $stages;
	}

/* ########## Avoir le nombre de stages ########## */

	function getNombreStages(){
		
		global $BDD;
		
		$result = $BDD->select("COUNT(*) AS NB", "SBN_STAGES");
		return $result[0]->NB;
	}
	
/* ########## Avoir la date a afficher ########## */

	function convertToDisplayDate($p_date){
		return substr($p_date, 6, 2)."/".substr($p_date, 4, 2)."/".substr($p_date, 0, 4);
	}
	
/* ########## Limiter la taille d'une chaine ########## */

	function limit($p_text, $p_limite){
		if(strlen($p_text) > $p_limite){
			return $description = substr($p_text, 0, $p_limite)."...";
		} else {
			return $description = $p_text;
		}
	}
	
/* ########## Changer les caractères \n en <br /> ########## */

	function makeReturn($p_text){
		return preg_replace("#\n#", "<br />", $p_text);
	}
	
/* ########## Avoir le lien de details ########## */

	function getDetailLink($p_type, $p_id, $full = true){
		if($full){
			return '<a href="details.php?type='.$p_type.'&amp;id='.$p_id.'">Plus d&apos;infos</a>';
		} else {
			return 'details.php?type='.$p_type.'&amp;id='.$p_id;
		}
	}

/* ########## Avoir le lien ########## */

	function getLink($p_link, $p_texte = ''){
		$p_link = strtolower($p_link);
		$link_url = $p_link;
		if(preg_match("#non renseigne#i", $link_url)){
			return '';
		} else {
			if(preg_match("#http://#", $link_url) || preg_match("#[?=]+#", $link_url) || !preg_match("#[@]#", $link_url)){
				if(preg_match("#^http://#", $link_url)){
				} else if(preg_match("#http://#", $link_url)){
					$link_url = explode("http://", $link_url);
					$link_url = "http://".$link_url[1];
				} else {
					$link_url = "http://".$link_url;
				}
				$link = $link_url;
				$link = preg_replace("#http://#", "", $link);
			} else {
				if(preg_match("#^mailto:#", $link_url)){
				} else if(preg_match("#mailto:#", $link_url)){
					$link_url = explode("mailto:", $link_url);
					$link_url = "mailto:".$link_url[1];
				} else {
					$link_url = "mailto:".$link_url;
				}
				$link = $link_url;
				$link = preg_replace("#mailto:#", "", $link);
			}
			$link = explode('?', $link);
			$link = explode('/', $link[0]);
			if(empty($p_texte)){
				return '<a href="'.$link_url.'"' . ( preg_match("#http://#", $link_url) ? ' class="lien"' : '' ) . '>'.$link[0].'</a>';
			} else {
				return '<a href="'.$link_url.'"' . ( preg_match("#http://#", $link_url) ? ' class="lien"' : '' ) . '>'.$p_texte.'</a>';
			}
		}
	}
	
/* ########## Avoir les thematiques ########## */
	
	function getThematiques(){
		
		global $BDD;
		
		$results = $BDD->select(
					"entreprise_thematique", 
					"SBN_ENTREPRISES", 
					"GROUP BY entreprise_thematique"
				);
		return $results;
	}

?>