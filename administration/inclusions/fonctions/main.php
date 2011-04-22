<?php

	require_once("../../inclusions/fonctions/main.php");
	require_once("../../inclusions/fonctions/moncompte.php");
	require_once("../../inclusions/fonctions/projets.php");

/* ************ publierSurTwitter() ************
 * 
 * Publie les infos passé en paramètres sur Twitter
 * 
 */

	function publierSurTwitter($p_texte, $p_url, $p_callback_url){
		
		$_SESSION['tweet']['texte'] = $p_texte;
		$_SESSION['tweet']['url'] = "http://" . $_SERVER['HTTP_HOST'] . $p_url;
		$_SESSION['redirect'] = "http://" . $_SERVER['HTTP_HOST'] . $p_callback_url;
	
		header('location: publierSurTwitter.php');
					
	}
	
/* ************ getMeilleursDocumentsTelechargements() ************
 * 
 * Renvoit la liste des documents les plus telecharger
 * 
 * @return array listes documents
 *
 */

	function getMeilleursDocumentsTelechargements($p_nb){
		
		global $BDD;
	
		$documents = $BDD->select(
			"d.document_nom, d.document_telechargements, m.matiere_nom, m.matiere_cursus",
			"TB_DOCUMENTS d JOIN TB_MATIERES m ON (d.matiere_id = m.matiere_id)",
			"ORDER BY d.document_telechargements DESC, m.matiere_cursus, m.matiere_nom, d.document_nom
			 LIMIT 0,".$p_nb
		);
		
		return $documents;
	
	}

/* ************ getMeilleursStudentsVisites() ************
 * 
 * Renvoit la liste des etudiants venus le plus souvent
 * 
 * @return array listes students
 *
 */

	function getMeilleursStudentsVisites($p_nb){
		
		global $BDD;
	
		$students = $BDD->select(
			"student_idbooster, student_nom, student_prenom, student_visites",
			"TB_STUDENTS",
			"ORDER BY student_visites DESC LIMIT 0,".$p_nb
		);
		
		return $students;
	
	}

/* ************ getStudentsVisiteAujourdhui() ************
 * 
 * Renvoit la liste des etudiants venus aujourd'hui
 * 
 * @return array listes students
 *
 */

	function getStudentsVisiteAujourdhui(){
		
		global $BDD;
	
		$students = $BDD->select(
			"student_idbooster, student_nom, student_prenom",
			"TB_STUDENTS",
			"WHERE student_derniere_visite = CURDATE()"
		);
		
		return $students;
	
	}
	
?>