<?php

	require_once("../inclusions/layout/haut.php");
	
?>

<div id="solde_historique_cafeteria">
	<h2>Cafétéria : Mon solde</h2>
		<p>Il vous reste actuellement : <strong id="solde"><?php echo getSolde($_SESSION['user']['idbooster']); ?></strong></p>
		<br/>
	<h2>Vos dernières consommations</h2>
		<?php
		
		$transactions = getHistoriqueConsommations($_SESSION['user']['idbooster']);
		
		if(count($transactions) == 0){
			echo "<strong style='color:red'>Aucune consommation pour le moment.</strong>";
		} else {
		
		?>
		
		<table>
			<tr><th>Date</th><th>Consommation</th></tr>
			
		<?php
		
			foreach($transactions as $transaction){
				echo "<tr><td>" . $transaction->historique_date . "</td><td>" . $transaction->produit_nom . "</td></tr>";
			}
		
		?>	
			
		</table>
		
		<?php
		
		}
		
		?>
		
		<br/>
		
		<p style="text-align:center;"><a href="cafeteriaStats.php">Voir les statistiques de la Cafétéria</a></p>
		<p style="text-align:center;">
			<img style="width:50px;" src="../images/badges/1.png" title="Badge"/>
			<img style="width:50px;" src="../images/badges/2.png" title="Badge"/>
			<img style="width:50px;" src="../images/badges/3.png" title="Badge"/>
			<img style="width:50px;" src="../images/badges/4.png" title="Badge"/>
			<img style="width:50px;" src="../images/badges/5.png" title="Badge"/>
		</p>
		<p style="text-align:center;"><a href="badges.php">Voir les Badges de la Cafétéria</a></p>
		
</div>
	
<div id="cafeteria">
	<h2>Actuellement en vente</h2>
	
	<div class="type_produit type_produit_selected" title="Boissons chaudes">Boissons Chaudes</div>
	<div class="type_produit" title="Boissons froides">Boissons Froides</div>
	<div class="type_produit" title="Sucreries">Sucreries</div>
	
	<div id="affichage_produits">
	
		<?php printProduits("Boissons chaudes"); ?>
		
	</div>
	
</div>

<div style="clear:both"></div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>

