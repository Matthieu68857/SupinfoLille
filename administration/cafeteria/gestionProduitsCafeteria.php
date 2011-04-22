<?php

	require_once("../inclusions/layout/haut.php");
	
	if(isset($_POST['id'])){
		updateProduit($_POST['id'], $_POST['nom'], $_POST['categorie'], $_POST['prix'], $_POST['stock']);
	}

?>

	<div id="liste_produits">
		<h2>Liste des produits</h2>
		
		<div class="type_produit type_produit_selected" title="Boissons chaudes">Boissons Chaudes</div>
		<div class="type_produit" title="Boissons froides">Boissons Froides</div>
		<div class="type_produit" title="Sucreries">Sucreries</div>
	
		<div id="affichage_produits">
	
			<?php printProduitsAdmin("Boissons chaudes"); ?>
		
		</div>
	
	</div>
	
	<div id="gestion_produits">
		<h2>Gérer le produit</h2>
		
		<div id="gestionProduit">
			<p style="color:red; font-weight:bold; text-align:center;">Choisissez le produit à éditer dans la liste à gauche.</p>
		</div>
		
	</div>

	<div style="clear:both"></div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>