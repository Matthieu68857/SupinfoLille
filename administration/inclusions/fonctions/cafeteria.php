<?php

	require_once("../../inclusions/fonctions/cafeteria.php");

	function getHistoriqueConsommationsJourAt($date){
	
		global $BDD;
		
		$date = explode("H", $date);
		
		$date = date("Y-m-d") . $date[0] . ":" . $date[1] . ":00";
		
		$histo = $BDD->select(
			"*",
			"VW_CAFETERIA_HISTORIQUE",
			"WHERE historique_date >= ? ORDER BY historique_date DESC",
			array($date)
		);
		
		return($histo);
	
	}


/* ************ addBadgeToStudent() ************
 * 
 * Ajoute un badge à un student
 *
 */

	function addBadgeToStudent($p_student, $p_badge){
		
		global $BDD;
	
		$BDD->callStoredProcedure("addBadge", array($p_student, $p_badge));
		
	}

/* ************ printAllProducts() ************
 * 
 * Affiche tous les produits
 *
 */

	function printAllProducts() {
	
		global $BDD;
	
		$products = $BDD->select(
			"*",
			"TB_CAFETERIA_PRODUITS"
		);
	
		foreach($products as $product) {
			if($product->produit_quantite != 0 && $product->produit_quantite >= 0) {
			
			echo '<li class="product"><img src="../../images/cafeteria/'.$product->produit_id.'.jpg" alt="'.$product->produit_nom.'" title="'.$product->produit_id.'" /><br /><p>'.$product->produit_nom.'</p><span>'.$product->produit_quantite.'</span></li>';
			}
		}
			
	}


/* ************ updateProduit() ************
 * 
 * Met à jour le produit
 *
 */

	function updateProduit($p_id, $p_nom, $p_categorie, $p_prix, $p_stock){
	
		global $BDD;
	
		$BDD->update(
			"TB_CAFETERIA_PRODUITS",
			array("produit_nom = ?", "produit_prix = ?", "produit_quantite = ?", "produit_type = ?"),
			"produit_id = ?",
			array($p_nom, $p_prix, $p_stock, $p_categorie, $p_id)
		);
	
	}

/* ************ getProduitInfos() ************
 * 
 * Retourne les infos d'un produit
 * 
 * @return array produit
 *
 */

	function getProduitInfos($p_produit){
		
		global $BDD;
	
		$produit = $BDD->select(
			"*",
			"TB_CAFETERIA_PRODUITS",
			"WHERE produit_id = ?",
			array($p_produit)
		);
		
		return $produit[0];
	
	}

/* ************ printGestionProduits() ************
 * 
 * Affiche la page d'edition d'un produit
 * 
 */

	function printGestionProduits($p_produit){
	
		$produit = getProduitInfos($p_produit);
		
		echo "<form method='post'>";
	
		echo "<p>Produit : <input type='text' name='nom' value='".$produit->produit_nom."'/></p>";
		
		echo "<p>Catégorie : ";
			echo "<select name='categorie'>";
				if($produit->produit_type == "Boissons chaudes"){
					echo "<option selected='selected' value='Boissons chaudes'>Boissons Chaudes</option>";
				} else {
					echo "<option value='Boissons chaudes'>Boissons Chaudes</option>";
				}
				if($produit->produit_type == "Boissons froides"){
					echo "<option selected='selected' value='Boissons froides'>Boissons Froides</option>";
				} else {
					echo "<option value='Boissons froides'>Boissons Froides</option>";
				}
				if($produit->produit_type == "Sucreries"){
					echo "<option selected='selected' value='Sucreries'>Sucreries</option>";
				} else {
					echo "<option value='Sucreries'>Sucreries</option>";
				}
			echo "</select>";
		echo "</p>";
		
		echo "<p>Prix : <input type='text' name='prix' value='".$produit->produit_prix."'/></p>";
		
		echo "<p>Stock : ";
			echo "<select name='stock'>";
			for($i=0; $i<=100; $i++){
				if($i == $produit->produit_quantite){
					echo "<option selected='selected' value='".$i."'>".$i."</option>";
				} else {
					echo "<option value='".$i."'>".$i."</option>";
				}
			}
			echo "</select>";
		echo "</p>";
		
		echo "<p style='text-align:center;'><input type='submit' value='Modifier'/></p>";
		
		echo "<input type='hidden' name='id' value='".$produit->produit_id."'/>";
		
		echo "</form>";
	
	}

/* ************ printProduitsAdmin() ************
 * 
 * Affiche la liste des produits d'une categorie
 * 
 */

	function printProduitsAdmin($p_categories){
	
		echo " 
		<table>
			<tr><th>ID</th><th>Nom</th><th>Prix</th><th>Stock</th><th></th></tr>";
			
			foreach(getProduits($p_categories) as $produit){
				echo "
				<tr>
					<td>" . $produit->produit_id . "</td>
					<td>" . $produit->produit_nom . "</td>
					<td>" . $produit->produit_prix . "</td>
					<td>" . $produit->produit_quantite . "</td>
					<td>" . "<img class='editer' src='../images/modifier.png' title='".$produit->produit_id."'/>" . "</td>
				</tr>";
			}
		
		echo "</table>";
	
	}

/* ************ modifierSolde() ************
 * 
 * Modifie le solde d'un student
 * 
 */

	function modifierSolde($p_student, $p_new_solde){
	
		global $BDD;
	
		$BDD->update(
			"TB_STUDENTS",
			array("student_solde_cafeteria = ?"),
			"student_idbooster = ?",
			array($p_new_solde, $p_student)
		);
	
	}


?>