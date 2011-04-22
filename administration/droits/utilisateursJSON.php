<?php
	require('../inclusions/initialisation.php');
	
	if($_GET['term'] == "all"){
		$utilisateursBDD = getUtilisateurs("");
	} else {
		$utilisateursBDD = getUtilisateurs($_GET['term']);
	}
	
	$utilisateurs = array();
	
	foreach($utilisateursBDD as $utilisateur){
		array_push(
			$utilisateurs, 
			array(
				'value' => $utilisateur['idbooster'],
				'label' => $utilisateur['prenom'] . " " . $utilisateur['nom'] . " (" . $utilisateur['idbooster'] . ")"
			)
		);
	}	
	
	echo json_encode($utilisateurs);
?>