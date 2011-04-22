<?php

	require_once('../inclusions/initialisation.php');

	if(isset($_GET['id']) && isset($_GET['student'])){
	
		$BDD->update(
			"TB_CAFETERIA_PRODUITS",
			array("produit_quantite = produit_quantite - 1"),
			"produit_id = ?",
			array($_GET['id'])
		);
		
		
		$BDD->insert(
			"TB_CAFETERIA_HISTORIQUE",
			array("student_idbooster","produit_id","historique_date"),
			array("?","?", "NOW()"),
			array($_GET['student'], $_GET['id'])
		);
		
	}
?>