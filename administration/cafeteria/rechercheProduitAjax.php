<?php

	require_once('../inclusions/initialisation.php');
			
	$products = $BDD->select(
		"*",
		"TB_CAFETERIA_PRODUITS",
		"WHERE produit_id = ?",
		array($_GET[id])
	);
	
	foreach($products as $product) {
		$result = $product->produit_prix . "_" . $product->produit_quantite . "_" . $product->produit_nom . "_" . $product->produit_id;
	}
		
	echo $result;

?>