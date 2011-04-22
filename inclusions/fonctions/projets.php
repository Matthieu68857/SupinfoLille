<?php

/* ************ modifierProjet() ************
 * 
 * Modifie un projet
 * 
 */
 
 	function modifierProjet($p_nom, $p_nb_membres, $p_competences, $p_icone, 
 							$p_description, $p_categorie, $p_idbooster, $p_difficulte, $p_id){
 	
 		global $BDD;
		
		$BDD->update(
			"TB_PROJETS",
			array("projet_nom = ?","projet_nb_membres = ?","projet_icone = ?","projet_categorie = ?",
					"projet_description = ?","projet_competences = ?","projet_auteur = ?","projet_difficulte = ?"),
			"projet_id = ?",
			array(htmlspecialchars(stripslashes($p_nom)), $p_nb_membres, htmlspecialchars(stripslashes($p_icone)), $p_categorie, 
				htmlspecialchars(stripslashes($p_description)), htmlspecialchars(stripslashes($p_competences)), $p_idbooster, $p_difficulte, $p_id)
		);
 	
 	}

/* ************ virerStudentProjet() ************
 * 
 * Supprime un étudiant d'un projet
 * 
 */

	function virerStudentProjet($p_projet, $p_idbooster){
	
		global $BDD;
		
		$projet = getProjetDetails($p_projet);
		
		if(estInscritAuProjet($p_idbooster, $p_projet)){	
			$BDD->delete(
				"TB_PROJETS_PARTICIPATIONS",
				"projet_id = ? AND student_idbooster = ?",
				array($p_projet, $p_idbooster)
			);
		
			$message = "Le créateur du projet " . $projet->projet_nom . " a décidé d'annuler votre participation à son projet.";
			mail($p_idbooster."@supinfo.com", 
				"Portail SUPINFO Lille : Participation annulee au projet", $message, 'From: SupinfoLille');
		}
	}

/* ************ supprimerProjet() ************
 * 
 * Supprime un projet si le demandeur est bien l'auteur
 * 
 */

	function supprimerProjet($p_projet, $p_idbooster, $p_pass){
	
		global $BDD;
	
		$projet = getProjetDetails($p_projet);
	
		$auteur = $BDD->select(
			"student_nom, student_prenom, student_pass",
			"TB_STUDENTS",
			"WHERE student_idbooster = ?",
			array($projet->projet_auteur)
		);
			
		if(md5(GBL_SEL).$auteur[0]->student_pass == $p_pass && $projet->projet_auteur == $p_idbooster){
			$inscrits = getAllInscritsProjet($p_projet);
			
			foreach($inscrits as $inscrit){
				$message = "Le projet " . $projet->projet_nom . " vient d'être supprimé par son créateur (".$auteur[0]->student_nom." ".$auteur[0]->student_prenom.")";
				mail($inscrit->student_idbooster."@supinfo.com", 
				"Portail SUPINFO Lille : Suppression du projet", $message, 'From: SupinfoLille');
			}
		
			$BDD->delete(
				"TB_PROJETS",
				"projet_id = ?",
				array($p_projet)
			);
			
			$BDD->delete(
				"TB_PROJETS_PARTICIPATIONS",
				"projet_id = ?",
				array($p_projet)
			);
		} 
	}

/* ************ desinscriptionProjet() ************
 * 
 * Desinscrit un student à un projet
 * 
 */
 
 	function desinscriptionProjet($p_student, $p_projet){
 	
 		global $BDD;
 	
 		if(estInscritAuProjet($p_student, $p_projet)){
			$student = new Student($p_student);
 			
 			$BDD->delete(
				"TB_PROJETS_PARTICIPATIONS",
				"projet_id = ? AND student_idbooster = ?",
				array($p_projet, $p_student)
			);
			
			$projet = getProjetDetails($p_projet);
			$message = $student->getPrenom()." ".$student->getNom()." vient de se désinscrire de votre projet : " . $projet->projet_nom;
			mail($projet->projet_auteur."@supinfo.com", 
				"Portail SUPINFO Lille : Desinscription de votre projet", $message, 'From: SupinfoLille');
 		}	
	}

/* ************ inscriptionProjet() ************
 * 
 * Inscrit un student à un projet
 * 
 */
 
 	function inscriptionProjet($p_student, $p_projet){
 		
 		global $BDD;
 		
 		if(!estInscritAuProjet($p_student, $p_projet)){
			$student = new Student($p_student);
 	
 			$BDD->insert(
				"TB_PROJETS_PARTICIPATIONS",
				array("projet_id","student_idbooster"),
				array("?","?"),
				array($p_projet, $p_student)
			);
			
			$projet = getProjetDetails($p_projet);
			$message = $student->getPrenom()." ".$student->getNom(). " vient de s'inscrire au projet : " . $projet->projet_nom;
			mail($projet->projet_auteur."@supinfo.com", 
				"Portail SUPINFO Lille : Inscription projet", $message, 'From: SupinfoLille');
 		}	
	}

/* ************ estInscritAuProjet() ************
 * 
 * Renvoit vrai ou faux pour savoir si le student est inscrit au projet
 * 
 * @return bool
 *
 */

	function estInscritAuProjet($p_idbooster, $p_projet){
	
		global $BDD;
	
		$NB = $BDD->select(
			"COUNT(student_idbooster) AS NB",
			"TB_PROJETS_PARTICIPATIONS",
			"WHERE student_idbooster = ? AND projet_id = ?",
			array($p_idbooster, $p_projet)
		);
		
		if($NB[0]->NB > 0){
			return true;
		} else {
			return false;
		}
	
	}

/* ************ getProjetDetails() ************
 * 
 * Renvoit les informations d'un projet
 * 
 * @return array
 *
 */

	function getProjetDetails($p_projet){
	
		global $BDD;
	
		$projet = $BDD->select(
			"*",
			"TB_PROJETS",
			"WHERE projet_id = ?",
			array($p_projet)
		);
		
		return $projet[0];
	
	}

/* ************ ceProjetExiste() ************
 * 
 * Renvoit un bool pour savoir si le projet est dans la BDD ou non
 * 
 * @return bool
 *
 */

	function ceProjetExiste($p_projet){
	
		global $BDD;
	
		$NB = $BDD->select(
			"COUNT(projet_id) AS NB",
			"TB_PROJETS",
			"WHERE projet_id = ?",
			array($p_projet)
		);
		
		if($NB[0]->NB > 0){
			return true;
		} else {
			return false;
		}
	
	}
	
/* ************ printProjetsOf() ************
 * 
 * Affiche la liste des projets d'une catégorie spéciale
 * 
 *
 */

	function printProjetsOf($p_categorie){
	
		global $BDD;
		
		$projets = $BDD->select(
			"*",
			"TB_PROJETS",
			"WHERE projet_categorie LIKE ? ORDER BY projet_id DESC",
			array($p_categorie)
		);
		
		
		echo '<table class="listeProjets">'
				. '<tr><th class="projet_ico">Icone</th>'
				. '<th class="projet_nom">Nom</th>'
				. '<th>Catégorie</th>'
				. '<th class="projet_comp">Compétences</th>'				
				. '<th>Créateur</th>'
				. '<th class="projet_diff"></th>'
				. '<th class="projet_membres">Membres<br />In/Max</th>'
				. '<th></th>'
				. '</tr>';
		
		foreach ($projets as $projet) {
			
			$student = new Student($projet->projet_auteur);
			$nb_inscrits = getNbInscritsProjet($projet->projet_id);
			
		echo	'<tr><td><img style="width:50px; height:50px;" src="' . $projet->projet_icone . '" alt="Icone" /></td>'
				. '<td>' . htmlspecialchars($projet->projet_nom) . '</td>'
				. '<td>' . $projet->projet_categorie . '</td>'
				. '<td style="padding-left:3px; padding-right:3px;">' . htmlspecialchars($projet->projet_competences) . '</td>'
				. '<td><a href="../etudiants/etudiants.php?idbooster='.$student->getIdbooster().'"><img style="width:35px;" 
					src="http://www.campus-booster.net/actorpictures/'. $student->getIdbooster() .'.jpg" title="' . $student->getPrenom() . ' ' . $student->getNom() . '"/></td>'
				. '<td><img src="../images/barre' . $projet->projet_difficulte . '.png" alt="Difficulté ' 
					. $projet->projet_difficulte . '/5" title="Difficulté ' . $projet->projet_difficulte . '/5" /></td>'
				. '<td style="font-size:18px;">' . $nb_inscrits . '/' . $projet->projet_nb_membres . '</td>'
				. '<td style="font-size:15px;"><a href="detailsProjet.php?projet='. $projet->projet_id .'">Informations</a></td>'
				. '</tr>';
		}

				
		echo '</table>';
	
	}

/* ************ printAllProjets() ************
 * 
 * Affiche la liste des projets
 * 
 *
 */

	function printAllProjets(){
		printProjetsOf("%");
	}
	

/* ************ getAllInscritsProjet() ************
 * 
 * Retourne la liste des inscrits d'un projet
 * 
 * @return array liste inscrits
 */

	function getAllInscritsProjet($projet_id){
	
		global $BDD;
	
		$projets = $BDD->select(
			"*",
			"TB_PROJETS_PARTICIPATIONS",
			"WHERE projet_id = ? ORDER BY student_idbooster",
			array($projet_id)
		);
		
		return $projets;
	
	}
	

/* ************ getNbInscritsProjet() ************
 * 
 * Retourne le nb des inscrits d'un projet
 * 
 * @return array nb inscrits
 */

	function getNbInscritsProjet($projet_id){
	
		global $BDD;
	
		$projets = $BDD->select(
			"COUNT(*) AS NB",
			"TB_PROJETS_PARTICIPATIONS",
			"WHERE projet_id = ?",
			array($projet_id)
		);
		
		return $projets[0]->NB;
	
	}


/* ************ getAllProjets() ************
 * 
 * Retourne la liste des projets
 * 
 * @return array liste projets
 *
 */

	function getAllProjets(){
	
		global $BDD;
	
		$projets = $BDD->select(
			"*",
			"TB_PROJETS",
			"ORDER BY projet_categorie, projet_nom"
		);
		
		return $projets;
	
	}
	
/* ************ getLastProjet() ************
 * 
 * Retourne le dernier projet
 * 
 * @return dernier projet
 *
 */

	function getLastProjet(){
	
		global $BDD;
	
		$projets = $BDD->select(
			"projet_id",
			"TB_PROJETS",
			"ORDER BY projet_id DESC"
		);
		
		return $projets[0]->projet_id;
	
}

/* ************ ajouterProjet() ************
 * 
 * Ajoute un projet
 * 
 */
 
 	function ajouterProjet($p_nom, $p_nb_membres, $p_competences, $p_icone, $p_description, $p_categorie, $p_idbooster, $p_difficulte){
 	
 		global $BDD;
 	
 		if(!is_numeric($p_nb_membres)){
 			$p_nb_membres = 1;
 		}
 	
 		$BDD->insert(
			"TB_PROJETS",
			array("projet_nom","projet_nb_membres","projet_icone","projet_categorie",
					"projet_description","projet_competences","projet_auteur","projet_difficulte"),
			array("?","?","?","?","?","?","?","?"),
			array(htmlspecialchars(stripslashes($p_nom)), $p_nb_membres, htmlspecialchars(stripslashes($p_icone)), $p_categorie, 
				htmlspecialchars(stripslashes($p_description)), htmlspecialchars(stripslashes($p_competences)), $p_idbooster, $p_difficulte)
		);
		
		 $BDD->insert(
			"TB_PROJETS_PARTICIPATIONS",
			array("projet_id","student_idbooster"),
			array("?","?"),
			array(getLastProjet(), $p_idbooster)
		);
 	
 	}

?>