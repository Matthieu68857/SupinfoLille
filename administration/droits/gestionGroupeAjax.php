<?php

	require('../inclusions/initialisation.php');
	
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'nouveau_groupe':
				if(isset($_POST['nom']) && !empty($_POST['nom'])){
					$BDD->insert(
						'TB_GROUPES', 
						array('groupe_nom'),
						array('?'),
						array($_POST['nom'])
					);
				}
				break;
			case 'ancien_groupe':
				if(isset($_POST['id']) && !empty($_POST['id'])){
					$BDD->delete(
						'TB_STUDENTS_has_GROUPES',
						'groupe_id = ?', 
						array($_POST['id'])
					);
					$BDD->delete(
						'TB_GROUPES_has_CATEGORIES',
						'groupe_id = ?', 
						array($_POST['id'])
					);
					$BDD->delete(
						'TB_GROUPES',
						'groupe_id = ?', 
						array($_POST['id'])
					);
				}
				break;
			case 'get_categories':
				if(isset($_POST['id']) && !empty($_POST['id'])){
					$categories = $BDD->select(
						'c.categorie_nom, c.categorie_admin',
						'TB_CATEGORIES c ' . 
						'JOIN TB_GROUPES_has_CATEGORIES gc ' . 
						'ON c.categorie_id = gc.categorie_id', 
						'WHERE gc.groupe_id = ?',
						array($_POST['id'])
					);
					
					foreach($categories as $categorie){
						if($categorie->categorie_admin == "1"){
							$admin = "admin";
						} else {
							$admin = "normale";
						}
						echo "- " . $categorie->categorie_nom . " (Catégorie " . $admin . ")<br />";
					}
				}
				break;
			case 'get_membres':
				if(isset($_POST['id']) && !empty($_POST['id'])){
					$membres = $BDD->select(
						's.student_idbooster, s.student_prenom, s.student_nom',
						'TB_STUDENTS s ' . 
						'JOIN TB_STUDENTS_has_GROUPES sg ' . 
						'ON s.student_idbooster = sg.student_idbooster', 
						'WHERE sg.groupe_id = ?',
						array($_POST['id'])
					);
					
					foreach($membres as $membre){
						echo "- " . $membre->student_prenom. " " . $membre->student_nom . " (" . $membre->student_idbooster . ")<br />";
					}
				}
				break;
			case 'ajouter_categorie_bouton':
				if(isset($_POST['idGroupe']) && !empty($_POST['idGroupe']) && isset($_POST['id']) && !empty($_POST['id'])){
					$BDD->insert(
						'TB_GROUPES_has_CATEGORIES', 
						array('groupe_id', 'categorie_id'),
						array('?', '?'),
						array($_POST['idGroupe'], $_POST['id'])
					);
				}
				break;
			case 'retirer_categorie_bouton':
				if(isset($_POST['idGroupe']) && !empty($_POST['idGroupe']) && isset($_POST['id']) && !empty($_POST['id'])){
					$BDD->delete(
						'TB_GROUPES_has_CATEGORIES',
						'groupe_id = ? AND categorie_id = ?', 
						array($_POST['idGroupe'], $_POST['id'])
					);
				}
				break;
			case 'ajouter_membre_bouton':
				if(isset($_POST['idGroupe']) && !empty($_POST['idGroupe']) && isset($_POST['id']) && !empty($_POST['id'])){
					$BDD->insert(
						'TB_STUDENTS_has_GROUPES', 
						array('student_idbooster', 'groupe_id'),
						array('?', '?'),
						array($_POST['id'], $_POST['idGroupe'])
					);
				}
				break;
			case 'retirer_membre_bouton':
				if(isset($_POST['idGroupe']) && !empty($_POST['idGroupe']) && isset($_POST['id']) && !empty($_POST['id'])){
					$BDD->delete(
						'TB_STUDENTS_has_GROUPES',
						'groupe_id = ? AND student_idbooster = ?', 
						array($_POST['idGroupe'], $_POST['id'])
					);
				}
				break;
			default:
				echo "FAIL";
				break;
		}
	}
?>