<?php

	require_once("../inclusions/layout/haut.php");
		
	if(isset($_GET[pagenews])) {
		$pagenews = $_GET[pagenews]-1;	
	} else {
		$pagenews = 0;	
	}
	
	$news = getThisNew($pagenews);
	
	$maxnews = getNombreNews();
	
?>
 		
 	<div id="contenu">

 		<h1><?php echo $news->news_titre; ?></h1>
     
    	
    	<?php echo $news->news_contenu; ?>

		<p class="finnews">De : <strong><a href="../etudiants/etudiants.php?idbooster=<?php echo $news->news_auteur->getIdbooster() ?>"><?php echo $news->news_auteur->getPrenom() . " " . $news->news_auteur->getNom(); ?></a></strong> - Posté le : <strong><?php echo $news->news_date; ?></strong></p>
        <p><?php if(isset($_GET[pagenews]) && $_GET[pagenews] !=1) {  if ($_GET[pagenews] <= $maxnews) { ?>
        <a href="?pagenews=<?php echo $_GET[pagenews] + 1; ?>"> <img src="../images/gauche.png" alt="précédent" style="float:left;margin-top:-15px;" /> News précédente</a> <?php } ?>
        <span style="float:right;"><a href="?pagenews=<?php echo $pagenews; ?>"><img src="../images/droite.png" alt="suivant" style="float:right;margin-top:-15px;" /> News suivante </a></span> 
		<?php } else { ?>
        <a href="?pagenews=2"><img src="../images/gauche.png" alt="précédent" style="float:left; margin-top:-15px;" /> News précédente</a><?php } ?>
        </p>
    
    </div>    
    
    <div class="encart" id="encart_compte" onclick="location.href='../moncompte/moncompte.php'"><div class="encart" id="encart_compte2"></div></div>
    <div class="encart" id="encart_cafeteria" onclick="location.href='../cafeteria/cafeteria.php'"><div class="encart" id="encart_cafeteria2"></div></div>
    <div class="encart" id="encart_document" onclick="location.href='../documents/documents.php'">   <div class="encart" id="encart_document2"></div></div>
    <div class="encart" id="encart_etudiant" onclick="location.href='../etudiants/etudiants.php'"><div class="encart" id="encart_etudiant2"></div></div>
    <div class="encart" id="encart_event" onclick="location.href='../evenements/evenements.php'"><div class="encart" id="encart_event2"></div></div>
    <div class="encart" id="encart_sondage" onclick="location.href='../sondages/sondages.php'"><div class="encart" id="encart_sondage2"></div></div>
    <div class="encart" id="encart_sbn" onclick="location.href='../sbn/'"><div class="encart" id="encart_sbn2"></div></div>
    <div class="encart" id="encart_entraide" onclick="location.href='../entraide/entraide.php'"><div class="encart" id="encart_entraide2"></div></div>
    <div class="encart" id="encart_community" onclick="location.href='../projets/projets.php'"><div class="encart" id="encart_community2"></div></div>

	<?php
		$nb_entraides = getNbEntraidesEnCours();
		if($nb_entraides > 0){
	?>	
	
		<div id="notification_entraide">
			<span>
				<?php echo $nb_entraides; ?>
			</span> 
			<img src="../images/badge.png" title="Notification"/>
   	 	</div>
	
	<?php	
		}
	?>
   		<div style="clear:both"></div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>

