<?php

	require_once("../inclusions/layout/haut.php");
	
?>

<div id="cafeteria_stats">

	<div id="cafeteria_top_clients">

		<h2>Top 5 des meilleurs clients</h2>

		<table>
			<tr><th>TOP</th><th>Étudiant</th><th>Nombre d'achat</th><th>Dépenses</th></tr>

		<?php

		$clients = getTopClients(5);
		$top = 1;
	
		foreach($clients as $client){
		
			echo "<tr>
					<td>" . $top++ . "</td>
					<td>" . $client->student_prenom . " " . $client->student_nom . "</td>
					<td>" . $client->achats . "</td>
					<td>" . $client->depenses . "</td>
				</tr>";
					
		}
	
		?>

		</table>
		
		<h2>Top 5 des possesseurs de badge</h2>

		<table>
			<tr><th>TOP</th><th>Étudiant</th><th>Nombre de badge</th><th>Dernier Badge</th></tr>

		<?php

		$badges = getTopPossesseursBadges(5);
		$top = 1;
	
		foreach($badges as $badge){
		
			echo "<tr>
					<td>" . $top++ . "</td>
					<td>" . $badge->student_prenom . " " . $badge->student_nom . "</td>
					<td>" . $badge->total . "</td>
					<td>" . utf8_encode(getLastStudentBadge($badge->student_idbooster)) . "</td>
				</tr>";
					
		}
	
		?>

		</table>
	
	</div>

	<div id="cafeteria_stats_diverses">

		<h2>Classement par Promo</h2>

		<table>
			<tr><th>TOP</th><th>Promotion</th><th>Nombre d'achat</th><th>Dépenses</th></tr>

		<?php

		$promos = getTopPromoCafeteria();
		$top = 1;
		$totalAchats = 0;
		$totalDepenses = 0;
	
		foreach($promos as $promo){
		
		$totalAchats = $totalAchats + $promo->achats;
		$totalDepenses = $totalDepenses + $promo->depenses;
		
			echo "<tr>
					<td>" . $top++ . "</td>
					<td>" . $promo->student_promo . "</td>
					<td>" . $promo->achats . "</td>
					<td>" . $promo->depenses . "</td>
				</tr>";
						
		}
	
		?>
		
			<tr><th colspan="2">Total</th><th><?php echo $totalAchats ?></th><th><?php echo $totalDepenses ?></th></tr>

		</table>
		
		<h2>Produits les plus vendus</h2>

		<table>
			<tr><th>TOP</th><th>Produit</th><th>Nombre d'achat</th><th>Dépenses</th></tr>

		<?php

		$produits = getTopProduitsCafeteria(5);
		$top = 1;
	
		foreach($produits as $produit){
		
			echo "<tr>
					<td>" . $top++ . "</td>
					<td>" . $produit->produit_nom . "</td>
					<td>" . $produit->achats . "</td>
					<td>" . $produit->depenses . "</td>
				</tr>";
						
		}
	
		?>

		</table>
	
	</div>

	<div style="clear:both"></div> <br/>
	
	<div id="cafeteria_stats_produit">
	
		<h2>Les meilleurs consommateurs de chaque produit</h2>
		
		<?php

		$masters = getMeilleurClientParProduit();
	
		foreach($masters as $master){
		
			echo "<div style='float:left; margin:10px;'>
			<table>
				<tr><th>" . $master->produit_nom . "</th></tr>
				<tr><td>" . $master->student_prenom . " " . $master->student_nom . "</td></tr>
			</table></div>";
						
		}
	
		?>
		
	<div style="clear:both"></div>
		
	</div>

</div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>

