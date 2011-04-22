<?php

/* ************ getInfosBadgesStudent() ************
 * 
 * Renvoit des infos pour la validation des badges
 * 
 */
 
	function getInfosBadgesStudent($p_student){
	
		global $BDD;
		
		$infos = $BDD->select(
			"*",
			"VW_INFOS_CONSOS",
			"WHERE student_idbooster = ?",
			array($p_student)
		);
		
		return $infos[0];
	}

/* ************ getNbBadgesGagnes() ************
 * 
 * Renvoit le nombre de badges gagnes
 * 
 */
 
	function getNbBadgesGagnes(){
	
		global $BDD;
		
		$badges = $BDD->select(
			"COUNT(*) AS NB",
			"TB_STUDENTS_has_BADGES"
		);
		
		return $badges[0]->NB;
	}

/* ************ getLastStudentBadge() ************
 * 
 * Renvoit le dernier badge d'un student
 * 
 */
   
	function getLastStudentBadge($p_student){
	
		global $BDD;
		
		$last = $BDD->select(
			"b.badge_nom",
			"TB_STUDENTS_has_BADGES s JOIN TB_BADGES b ON s.badge_id = b.badge_id",
			"WHERE s.student_idbooster = ? ORDER BY s.date_obtention DESC LIMIT 0,1",
			array($p_student)
		);
		
		return $last[0]->badge_nom;
	}

/* ************ getTopPossesseursBadges() ************
 * 
 * Renvoit le top des possesseurs de badges
 * 
 */
  
	function getTopPossesseursBadges($p_limit){
	
		global $BDD;
		
		$topPossesseurs = $BDD->select(
			"COUNT(*) AS total, b.student_idbooster, s.student_nom, s.student_prenom",
			"TB_STUDENTS_has_BADGES b JOIN TB_STUDENTS s ON b.student_idbooster = s.student_idbooster",
			"GROUP BY student_idbooster ORDER BY total DESC LIMIT 0,".$p_limit
		);
		
		return $topPossesseurs;
	}

/* ************ getPossesseursBadge() ************
 * 
 * Renvoit la liste des possesseurs d'un badge
 * 
 */
  
	function getPossesseursBadge($p_badge){
	
		global $BDD;
		
		$possesseurs = $BDD->select(
			"b.badge_id, b.student_idbooster, s.student_nom, s.student_prenom",
			"TB_STUDENTS_has_BADGES b JOIN TB_STUDENTS s ON b.student_idbooster = s.student_idbooster",
			"WHERE b.badge_id = ? ORDER BY b.date_obtention DESC",
			array($p_badge)
		);
		
		return $possesseurs;
	}

/* ************ getListeBadgesStudent() ************
 * 
 * Renvoit la liste des badges
 * 
 */
 
	function getListeBadgesStudent($p_student){
	
		global $BDD;
				
		$badges = $BDD->select(
			"b.badge_id, b.badge_nom, b.badge_validation, b.badge_date_creation, IF(b.badge_date_fin < CURDATE() AND b.badge_date_fin != '0000-00-00', 0, 1) valide, IF(b.badge_date_fin != '0000-00-00', 1, 0) limited, (SELECT student_idbooster FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = ? AND badge_id = b.badge_id) AS student_idbooster",
			"TB_BADGES b",
			"ORDER BY b.badge_date_creation",
			array($p_student)
		);
		
		return $badges;
	}

/* ************ getListeBadges() ************
 * 
 * Renvoit la liste des badges
 * 
 */
 
	function getListeBadges(){
	
		global $BDD;
		
		$badges = $BDD->select(
			"*",
			"TB_BADGES",
			"ORDER BY badge_nom"
		);
		
		return $badges;
	}

/* ************ getMeilleurClientParProduit() ************
 * 
 * Renvoit la liste des students qui ont consommé le plus en fonction de chaque produit
 * 
 */
 
	function getMeilleurClientParProduit(){
	
		global $BDD;
		
		$masters = $BDD->select(
			"p.produit_nom, s.student_nom, s.student_prenom",
			"TB_CAFETERIA_PRODUITS p
				JOIN TB_STUDENTS s",
			"WHERE s.student_idbooster = 
				(
					SELECT ss.student_idbooster
					FROM `TB_CAFETERIA_HISTORIQUE` hh 
					JOIN TB_CAFETERIA_PRODUITS pp ON hh.produit_id = pp.produit_id
					JOIN TB_STUDENTS ss ON hh.student_idbooster = ss.student_idbooster
					WHERE hh.produit_id = p.produit_id
					GROUP BY ss.student_idbooster
					ORDER BY COUNT(*) DESC LIMIT 0,1
				)
			ORDER BY p.produit_nom
			"
		);
		
		return $masters;
	}

/* ************ getTopProduitsCafeteria() ************
 * 
 * Renvoit le top des produits
 * 
 */
 
	function getTopProduitsCafeteria($p_limit){
	
		global $BDD;
		
		$produits = $BDD->select(
			"p.produit_nom, ROUND(SUM(p.produit_prix),2) depenses, COUNT(p.produit_prix) achats",
			"TB_CAFETERIA_HISTORIQUE h 
				JOIN TB_CAFETERIA_PRODUITS p ON h.produit_id = p.produit_id 
				JOIN TB_STUDENTS s ON h.student_idbooster = s.student_idbooster",
			"GROUP BY p.produit_nom ORDER BY depenses DESC LIMIT 0,".$p_limit
		);
		
		return $produits;
	}

/* ************ getTopPromoCafeteria() ************
 * 
 * Renvoit le top des promos
 * 
 */
 
	function getTopPromoCafeteria(){
	
		global $BDD;
		
		$promos = $BDD->select(
			"s.student_promo, ROUND(SUM(p.produit_prix),2) depenses, COUNT(p.produit_prix) achats",
			"TB_CAFETERIA_HISTORIQUE h 
				JOIN TB_CAFETERIA_PRODUITS p ON h.produit_id = p.produit_id 
				JOIN TB_STUDENTS s ON h.student_idbooster = s.student_idbooster",
			"GROUP BY s.student_promo ORDER BY depenses DESC"
		);
		
		return $promos;
	}

/* ************ getTopClients() ************
 * 
 * Renvoit le top des meilleurs clients
 * 
 */
 
	function getTopClients($p_limit){
	
		global $BDD;
		
		$clients = $BDD->select(
			"s.student_nom, s.student_prenom, h.student_idbooster, ROUND(SUM(p.produit_prix),2) depenses, COUNT(p.produit_prix) achats",
			"TB_CAFETERIA_HISTORIQUE h 
				JOIN TB_CAFETERIA_PRODUITS p ON h.produit_id = p.produit_id 
				JOIN TB_STUDENTS s ON h.student_idbooster = s.student_idbooster",
			"GROUP BY h.student_idbooster ORDER BY depenses DESC LIMIT 0,".$p_limit
		);
		
		return $clients;
	}

/* ************ printProduits() ************
 * 
 * Affiche la liste des produits d'une categorie
 * 
 */

	function printProduits($p_categories){
	
		echo " 
		<table>
			<tr><th id='th_produits'></th><th>Nom</th><th>Prix</th><th>Stock</th></tr>";
			
			foreach(getProduits($p_categories) as $produit){
				echo "
				<tr>
					<td>" . "<img class='produit' title='".$produit->produit_nom."' src='../images/cafeteria/".$produit->produit_id.".jpg' />" . "</td>
					<td>" . $produit->produit_nom . "</td>
					<td>" . $produit->produit_prix . "</td>
					<td>" . $produit->produit_quantite . "</td>
				</tr>";
			}
		
		echo "</table>";
	
	}

/* ************ getHistoriqueConsommations() ************
 * 
 * Retourne la liste des consommations d'un student
 * 
 */

	function getHistoriqueConsommations($p_student){
		
		global $BDD;
		
		$historique = $BDD->select(
			"h.historique_id, h.student_idbooster, h.produit_id, 
			DATE_FORMAT(h.historique_date, '%d/%m/%Y') AS historique_date, p.produit_nom",
			"TB_CAFETERIA_HISTORIQUE h JOIN TB_CAFETERIA_PRODUITS p ON h.produit_id = p.produit_id",
			"WHERE student_idbooster = ? ORDER BY h.historique_date DESC LIMIT 0,5",
			array($p_student)
		);
		
		return $historique;
	}
	
/* ************ getNbProduits() ************
 * 
 * Retourne le NB de produits
 * 
 */

	function getNbProduits(){
		
		global $BDD;
		
		$produits = $BDD->select(
			"COUNT(*) AS NB",
			"TB_CAFETERIA_PRODUITS"
		);
		
		return $produits[0]->NB;
	}

/* ************ getProduits() ************
 * 
 * Retourne les produits en vente
 * 
 */

	function getProduits($p_categories){
		
		global $BDD;
		
		$produits = $BDD->select(
			"*",
			"TB_CAFETERIA_PRODUITS",
			"WHERE produit_type = ? ORDER BY produit_quantite DESC, produit_nom, produit_prix",
			array($p_categories)
		);
		
		return $produits;
	}

/* ************ getSolde() ************
 * 
 * Retourne le solde du student en paramètre
 * 
 */

	function getSolde($p_student){
		
		global $BDD;
		
		$solde = $BDD->select(
			"student_solde_cafeteria",
			"TB_STUDENTS",
			"WHERE student_idbooster = ?",
			array($p_student)
		);
		
		if($solde[0]->student_solde_cafeteria > 0){
			$formated_solde = "<span style='color:#A1C117'>" . $solde[0]->student_solde_cafeteria . " €</span>";
		} elseif($solde[0]->student_solde_cafeteria <= 0){
			$formated_solde = "<span style='color:red'>" . $solde[0]->student_solde_cafeteria . " €</span>";
		}
		
		return $formated_solde;
	}

?>