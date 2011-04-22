<?php

	require('../inclusions/initialisation.php');

	if(isset($_POST['action']) && $_POST['action'] == "nouvelle_categorie" && isset($_POST['admin']) && isset($_POST['nom']) && !empty($_POST['nom'])){
		$BDD->insert(
			'TB_CATEGORIES', 
			array('categorie_nom', 'categorie_admin'),
			array('?', '?'),
			array($_POST['nom'], $_POST['admin'])
		);
	} else if(isset($_POST['action']) && $_POST['action'] == "ancienne_categorie" && isset($_POST['id']) && !empty($_POST['id'])){
		$BDD->delete(
			'TB_GROUPES_has_CATEGORIES',
			'categorie_id = ?', 
			array($_POST['id'])
		);
		$BDD->delete(
			'TB_CATEGORIES',
			'categorie_id = ?', 
			array($_POST['id'])
		);
	}
?>