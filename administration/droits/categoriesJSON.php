<?php
	require('../inclusions/initialisation.php');
	
	if($_GET['term'] == "all"){
		$categoriesBDD = getCategories("");
	} else {
		$categoriesBDD = getCategories($_GET['term']);
	}
	
	$categories = array();
	
	foreach($categoriesBDD as $categorie){
		array_push(
			$categories, 
			array(
				'value' => $categorie['id'],
				'label' => ucfirst($categorie['nom']) . ' (' . $categorie['type'] . ')'
			)
		);
	}	
	
	echo json_encode($categories);
?>