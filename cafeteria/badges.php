<?php

	require_once("../inclusions/layout/haut.php");
	
	$allBadges = getListeBadgesStudent($_SESSION['user']['idbooster']);
	
	function belongsToMe($badge){
		if($badge->student_idbooster != ""){
			return true;
		} else {
			return false;
		}
	}
	
	$badges = $allBadges;
	$nbBadges = count($badges);
	$badgesStudent = array_filter($allBadges, "belongsToMe");
	$nbBadgesStudent = count($badgesStudent);
	$nbBadgesGagnes = getNbBadgesGagnes();
	
	
	$infosValidation = getInfosBadgesStudent($_SESSION['user']['idbooster']);
		
	$potentiels = array();
	
	/* ########################### Américain ########################### */
	if($infosValidation->nb_coca>20){$infosValidation->nb_coca = 20;}
	if($infosValidation->nb_cheese>3){$infosValidation->nb_cheese = 3;}
	$potentiels[1] = array(
		((($infosValidation->nb_cheese/3)/2 + ($infosValidation->nb_coca/20)/2))*100, 
		"Vous avez dévoré  " . $infosValidation->nb_cheese . " cheeseburger(s) et " . $infosValidation->nb_coca . " coca(s)"
	);
	
	/* ######################## Bonjour les riches ####################### */
	$potentiels[2] = array(
		(($infosValidation->nb_produit)/getNbProduits())*100, 
		"Vous avez acheté " . $infosValidation->nb_produit . " produit(s) différent(s)"
	);
	
	/* ########################### Kinder Lover ########################### */
	if($infosValidation->nb_kinderbueno>15){$infosValidation->nb_kinderbueno = 15;}
	if($infosValidation->nb_kinderchocolat>20){$infosValidation->nb_kinderchocolat = 20;}
	$potentiels[3] = array(
		((($infosValidation->nb_kinderbueno/15)/2 + ($infosValidation->nb_kinderchocolat/20)/2))*100, 
		"Vous avez dévoré  " . $infosValidation->nb_kinderbueno . " Kinder Bueno et " . $infosValidation->nb_kinderchocolat . " Kinder Chocolat"
	);
	
	/* ########################### Fanboy ########################### */
	$potentiels[4] = array(0, "Essayez de rester sur le même produit pendant un moment ;-)");
	
	/* ########################### Caddie complet ########################### */
	$potentiels[5] = array(0, "Il vous faut acheter 10 produits en un coup ! Si la caissière oublie de valider votre badge, réclamez !");
	
	/* ########################### Italien ########################### */
	$potentiels[6] = array(
		($infosValidation->nb_cafe/25)*100, 
		"Vous avez savouré  " . $infosValidation->nb_cafe . " Cappuccino, Latte Macchiato, Expresso, Mocha"
	);
	
	/* ########################### Chanceux ########################### */
	$potentiels[7] = array(0, "Astuce : surveillez bien les stocks sur la page cafétéria");
	
	/* ########################### Barré ########################### */
	$potentiels[8] = array(
		($infosValidation->nb_barre/40)*100, 
		"Vous avez englouti  " . $infosValidation->nb_barre . " Twix, Mars, Lion, Snickers"
	);
	
	/* ########################### Martien ########################### */
	$potentiels[9] = array(
		($infosValidation->nb_mars/15)*100, 
		"Vous avez mystérieusement mangé  " . $infosValidation->nb_mars . " Mars"
	);
	
	/* ########################### Maitre ########################### */
	$potentiels[10] = array(
		($infosValidation->nb_maitre/2)*100, 
		"Vous êtes Maître de " . $infosValidation->nb_maitre . " Produit(s)"
	);
	
	/* ########################### Puit sans fond ########################### */
	$potentiels[11] = array(
		($infosValidation->nb_canette/30)*100, 
		"Vous avez absorbé " . $infosValidation->nb_canette . " canette(s)"
	);
	
	/* ########################### Grand Maitre ########################### */
	$potentiels[12] = array(
		($infosValidation->nb_maitre/4)*100, 
		"Vous êtes Maître de " . $infosValidation->nb_maitre . " Produit(s)"
	);
	
	/* ########################### Stomatophobie ########################### */
	$potentiels[13] = array(
		($infosValidation->nb_bonbon/20)*100, 
		"Vous avez apprécié " . $infosValidation->nb_bonbon . " paquet(s) de Bonbon"
	);
	
	/* ########################### Suceur Certified ########################### */
	$potentiels[15] = array(
		($infosValidation->nb_misterfreez/25)*100, 
		"Vous avez sucé " . $infosValidation->nb_misterfreez . " MisterFreez"
	);
	
	/* ########################### Conquistador ########################### */
	$potentiels[16] = array(
		($infosValidation->nb_badge/5)*100, 
		"Vous avez remporté " . $infosValidation->nb_badge . " Badge(s)"
	);
	
	/* ########################### Pokémaniac ########################### */
	$potentiels[17] = array(
		($infosValidation->nb_badge/8)*100, 
		"Vous avez remporté " . $infosValidation->nb_badge . " Badge(s)"
	);
	
	/* ########################### Indianna Jones ########################### */
	$potentiels[18] = array(
		($infosValidation->nb_badge/15)*100, 
		"Vous avez remporté " . $infosValidation->nb_badge . " Badge(s)"
	);
	
	/* ########################### Gourmand ########################### */
	$potentiels[19] = array(
		($infosValidation->nb_conso/50)*100, 
		"Vous avez consommé " . $infosValidation->nb_conso . " fois à la cafétéria"
	);
	
	/* ########################### Goinfre ########################### */
	$potentiels[20] = array(
		($infosValidation->nb_conso/100)*100, 
		"Vous avez consommé " . $infosValidation->nb_conso . " fois à la cafétéria"
	);
	
	/* ########################### Goinfref ########################### */
	$potentiels[21] = array(
		($infosValidation->nb_conso/200)*100, 
		"Vous avez consommé " . $infosValidation->nb_conso . " fois à la cafétéria"
	);
	
	/* ########################### DG Fan ########################### */
	$potentiels[22] = array(
		($infosValidation->nb_dg/40)*100, 
		"Vous avez consommé " . $infosValidation->nb_dg . " produit(s) de la machine Dolce Gusto"
	);
	
	/* ########################### 1500 ########################### */
	$potentiels[23] = array(0, "Astuce : surveillez bien les stats sur la page cafétéria");
	
	/* ########################### 2000 ########################### */
	$potentiels[24] = array(0, "Astuce : surveillez bien les stats sur la page cafétéria");
	
	/* ########################### PGM ########################### */
	$potentiels[25] = array(
		($infosValidation->nb_badge/($nbBadges-2))*100, 
		"Vous avez remporté  " . $infosValidation->nb_badge . " Badge(s)"
	);
	
?>

<div id="badges">

	<div id="menuListeBadges">
		<div class="separateur"></div>
		<div class="choix selected" title="Tous les badges">Tous les badges <div class="count"><?php echo $nbBadges; ?></div></div>
		<div class="separateur"></div>
		<div class="choix" title="Mes badges">Mes badges <div class="count"><?php echo $nbBadgesStudent; ?></div></div>
		<div class="separateur"></div>
		<div class="choix" title="Mon potentiel">Mon potentiel</div>
		<div class="separateur"></div>
		<div class="choix" title="Statistiques">Statistiques <div class="count"><?php echo $nbBadgesGagnes; ?></div></div>
		<div class="separateur"></div>
	</div>

	<div id="listeBadges">
		<div id="affichageBadges">
			<?php
	
			foreach($badges as $badge){
				echo "
				<div class='badge" . ($badge->student_idbooster != "" ? " belongs" : " defaut") . "'> 
					" . ( $badge->valide == 0 ? "<img class='banner' src='../images/badges/expired.png'/>" : "")
					  . ( $badge->limited == 1 ? "<img class='banner' src='../images/badges/limited.png'/>" : "") . 
					"<img class='badgeImage' title='".utf8_encode($badge->badge_nom)."' alt='".$badge->badge_id."' src='../images/badges/".$badge->badge_id.".png'/> 
					<span class='contentValidation'>". utf8_encode($badge->badge_validation) ."</span>
					<br/> <span>".utf8_encode($badge->badge_nom)."</span> 
				</div>";
			}
	
			?>
		</div>
		
		<div id="affichageStats">
			<?php
	
			foreach($badges as $badge){
			
				$possesseurs = getPossesseursBadge($badge->badge_id);
				
				$nbPossesseurs = count($possesseurs);
				if($nbPossesseurs == 0){
					$nbPossesseurs = "Aucun gagnant";
					$classeOpacity = "class='badgeImage aucunGagnant'";
				} elseif ($nbPossesseurs == 1) {
					$nbPossesseurs = "1 seul gagnant";
					$classeOpacity = "class='badgeImage unGagnant'";
				} else {
					$nbPossesseurs = $nbPossesseurs . " gagnants";
					$classeOpacity = "class='badgeImage'";
				}
				
				if($nbPossesseurs == "Aucun gagnant"){
					$derniersPossesseurs = "Personne n'a encore remporté ce badge";
				} else {
					$derniersPossesseurs = "";
				}
				
				foreach($possesseurs as $possesseur){
					if($derniersPossesseurs == ""){
						$derniersPossesseurs = $possesseur->student_prenom . " " . $possesseur->student_nom;
					} else {
						$derniersPossesseurs .= ", " . $possesseur->student_prenom . " " . $possesseur->student_nom;
					}
				}
			
				echo "
				<div class='badge'> 
					" . ( $badge->valide == 0 ? "<img class='banner' src='../images/badges/special_banner.png'/>" : "")
					  . ( $badge->limited == 1 ? "<img class='banner' src='../images/badges/limited.png'/>" : "") . "
					<img 
						" . $classeOpacity . "
						title='".utf8_encode($badge->badge_nom)."' 
						alt='".$badge->badge_id."' 
						src='../images/badges/".$badge->badge_id.".png'/> 
					<span class='contentWinners'>". $derniersPossesseurs ."</span>
					<br/> <span>".$nbPossesseurs."</span> 
				</div>";
				
			}
	
			?>
		</div>
		
		<div id="affichagePotentiel">
			<?php
	
			foreach($badges as $badge){
				echo "
				<div class='badge'> 
					" . ( $badge->valide == 0 ? "<img class='banner' src='../images/badges/expired.png'/>" : "")
					  . ( $badge->limited == 1 ? "<img class='banner' src='../images/badges/limited.png'/>" : "") . 
					"<img class='badgeImage' title='".utf8_encode($badge->badge_nom)."' alt='".$badge->badge_id."' src='../images/badges/".$badge->badge_id.".png'/> 
					<span class='contentPotentiel'>".$potentiels[$badge->badge_id][1]."</span>
					<br/> <div class='progressbar' title='".($badge->student_idbooster != "" ? "100" : $potentiels[$badge->badge_id][0])."'></div> 
				</div>";
			}
	
			?>
		</div>
		
	</div>
	
	<div style="clear:both;"></div>

</div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>