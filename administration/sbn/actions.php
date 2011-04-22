<?php
	if(!isset($_POST['type']) || !isset($_POST['action']) || empty($_POST['type']) || empty($_POST['action'])){
		header('location: index.php?erreur=Type ou action absent');
	}
	
	require_once('../inclusions/initialisation.php');
	
	switch ($_POST['type']) {
		case "entreprise":
			if(isset($_POST['entreprise_id']) && !empty($_POST['entreprise_id']) || isset($_POST['entreprise_id']) && $_POST['entreprise_id'] == 0){
				switch ($_POST['action']){
					case "ajouter":
						if(
							isset($_POST['entreprise_nom']) && !empty($_POST['entreprise_nom']) && 
							isset($_POST['entreprise_adresse']) && 
							isset($_POST['entreprise_cp']) && 
							isset($_POST['entreprise_ville']) && 
							isset($_POST['entreprise_site']) && 
							isset($_POST['entreprise_thematique']) && 
							isset($_POST['entreprise_infos'])
						){
							$id = 
							creerEntreprise(
								$_POST['entreprise_nom'], 
								$_POST['entreprise_adresse'], 
								$_POST['entreprise_cp'], 
								$_POST['entreprise_ville'], 
								$_POST['entreprise_site'], 
								$_POST['entreprise_thematique'], 
								$_POST['entreprise_infos']
							);
							header('location: entreprise.php?id='.$id);
						} else {
							header('location: index.php?erreur=Informations manquante pour creer l entreprise');
						}
						break;
					case "modifier":
						if(
							isset($_POST['entreprise_nom']) && !empty($_POST['entreprise_nom']) && 
							isset($_POST['entreprise_adresse']) && 
							isset($_POST['entreprise_cp']) && 
							isset($_POST['entreprise_ville']) && 
							isset($_POST['entreprise_site']) && 
							isset($_POST['entreprise_thematique']) && 
							isset($_POST['entreprise_infos'])
						){
							modifierEntreprise(
								$_POST['entreprise_id'], 
								$_POST['entreprise_nom'], 
								$_POST['entreprise_adresse'], 
								$_POST['entreprise_cp'], 
								$_POST['entreprise_ville'], 
								$_POST['entreprise_site'], 
								$_POST['entreprise_thematique'], 
								$_POST['entreprise_infos']
							);
							header('location: entreprise.php?id='.$_POST['entreprise_id']);
						} else {
							header('location: index.php?erreur=Informations manquante pour modifier l entreprise');
						}
						break;
					case "supprimer":
						supprimerEntreprise($_POST['entreprise_id']);
						header('location: index.php');
						break;
					default:
						header('location: index.php?erreur=Action incorrecte');
						break;
				}
			} else {
				header('location: index.php?erreur=Entreprise id incorrect');
			}
			break;
		case "contact":
			if(
				isset($_POST['contact_entreprise']) && !empty($_POST['contact_entreprise']) && 
				(isset($_POST['contact_id']) && !empty($_POST['contact_id']) || isset($_POST['contact_id']) && $_POST['contact_id'] == 0)
			){
				$e = new Entreprise($BDD, $_POST['contact_entreprise']);
				switch ($_POST['action']){
					case "ajouter":
						if(
							isset($_POST['contact_nom']) && 
							isset($_POST['contact_role']) && 
							isset($_POST['contact_telephone']) && 
							isset($_POST['contact_fax']) && 
							isset($_POST['contact_email'])
						){
							$e->creerContact(
									$_POST['contact_nom'], 
									$_POST['contact_role'], 
									$_POST['contact_telephone'], 
									$_POST['contact_fax'], 
									$_POST['contact_email']
								);
							header('location: entreprise.php?id='.$_POST['contact_entreprise']);
						} else {
							header('location: index.php?erreur=Informations manquante pour creer le contact');
						}
						break;
					case "modifier":
						if(
							isset($_POST['contact_nom']) && 
							isset($_POST['contact_role']) && 
							isset($_POST['contact_telephone']) && 
							isset($_POST['contact_fax']) && 
							isset($_POST['contact_email'])
						){
							$e->modifierContact(
									$_POST['contact_id'],
									$_POST['contact_nom'], 
									$_POST['contact_role'], 
									$_POST['contact_telephone'], 
									$_POST['contact_fax'], 
									$_POST['contact_email']
								);
							header('location: entreprise.php?id='.$_POST['contact_entreprise']);
						} else {
							header('location: index.php?erreur=Informations manquante pour modifier le contact');
						}
						break;
					case "supprimer":
						$e->supprimerContact($_POST['contact_id']);
						header('location: entreprise.php?id='.$_POST['contact_entreprise']);
						break;
					default:
						header('location: index.php?erreur=Action incorrecte');
						break;
				}
			} else {
				header('location: index.php?erreur=Contact entreprise incorrect');
			}
			break;
		case "stage":
			if(
				isset($_POST['stage_entreprise']) && !empty($_POST['stage_entreprise']) && 
				(isset($_POST['stage_id']) && !empty($_POST['stage_id']) || isset($_POST['stage_id']) && $_POST['stage_id'] == 0)
			){
				$e = new Entreprise($BDD, $_POST['stage_entreprise']);
				switch ($_POST['action']){
					case "ajouter":
						if(
							isset($_POST['stage_description']) && 
							isset($_POST['stage_date']) && 
							isset($_FILES['stage_fichier'])
						){
							$file = uploadFile($_FILES['stage_fichier'], $e->getId()."_".$e->getNom()."_Stage_".rand("11111","99999"));
							
							$e->creerStage(
									$_POST['stage_description'], 
									convertToMySQLDate($_POST['stage_date']), 
									$file
								);
							header('location: entreprise.php?id='.$_POST['stage_entreprise']);
						} else {
							echo "Up : ".$_SESSION['uploadDone'];
							header('location: index.php?erreur=Informations manquante pour ajouter le stage');
						}
						break;
					case "modifier":
						if(
							isset($_POST['stage_description']) && 
							isset($_POST['stage_date']) && 
							isset($_FILES['stage_fichier'])
						){
							$file = uploadFile($_FILES['stage_fichier'], $e->getId()."_".$e->getNom()."_Stage_".rand("11111","99999"));
							
							$e->modifierStage(
									$_POST['stage_id'],
									$_POST['stage_description'], 
									convertToMySQLDate($_POST['stage_date']), 
									$file
								);
							header('location: entreprise.php?id='.$_POST['stage_entreprise']);
						} else {
							header('location: index.php?erreur=Informations manquante pour modifier le stage');
						}
						break;
					case "supprimer":
						$e->supprimerStage($_POST['stage_id']);
						header('location: entreprise.php?id='.$_POST['stage_entreprise']);
						break;
					default:
						header('location: index.php?erreur=Action incorrecte');
						break;
				}
			} else {
				header('location: index.php?erreur=Stage entreprise incorrect');
			}
			break;
		default:
			header('location: index.php?erreur=Type incorrect');
			break;
	}
?>