<?php

	require_once("../inclusions/layout/haut.php");
		
?>

<div id="detailsProjet">


	<!-- On teste d'abord si le projet en GET existe ou non... Histoire de pas fail. -->

	<?php
	
	if(!isset($_GET['projet']) || !ceProjetExiste($_GET['projet'])){
		
		echo "<p id='fail_details_projet'>
			Ce projet n'existe pas. Si c'est une erreur de notre part, merci de nous contacter ! Sinon, arrétez de faire vos malins :D
		</p>";
		
	} else {
	
	?>
	
	<?php
	
	// Gestion des inscriptions/désinscriptions
	
	if(isset($_GET['inscription'])){
		inscriptionProjet($_SESSION['user']['idbooster'], $_GET['inscription']);
	}
	
	if(isset($_GET['desinscription'])){
		desinscriptionProjet($_SESSION['user']['idbooster'], $_GET['desinscription']);
	}	
	
	?>
	
	<!-- Affichage des détail de l'événement ici -->
	
	<?php 
	
	$projet = getProjetDetails($_GET['projet']); 
	$inscrits = getAllInscritsProjet($_GET['projet']); 
	$auteur = new Student($projet->projet_auteur);
	
	?>
    
    
    
    <div class="project">	
		<div class="project_header"> 
			<span class="dateproject"><img src="../images/barre<?php echo $projet->projet_difficulte; ?>.png" alt="Difficulté <?php echo  $projet->projet_difficulte; ?>/5" title="Difficulté <?php echo  $projet->projet_difficulte; ?>/5" /></span> 
			<h2><img class="imagep" src="<?php echo $projet->projet_icone; ?>" title="Logo Projet"/>
            <?php echo $projet->projet_nom; ?></h2> 
			<span class="participantsp"><?php echo count($inscrits); ?> inscrits / <?php echo $projet->projet_nb_membres; ?> max</span> 
			<p> <span class="imgbooster"><span style="float:left;">A<br />U<br />T<br />E<br />U<br />R</span><?php echo '<a href="../etudiants/etudiants.php?idbooster='.$projet->projet_auteur.'"><img style="height:43px;" src="http://www.campus-booster.net/actorpictures/'.$projet->projet_auteur.'.jpg" title=""/></a>'; ?>
        	</span>
        
        	<strong>Catégorie : </strong><?php echo $projet->projet_categorie; ?><br />
            <strong>Compétences : </strong><?php echo $projet->projet_competences; ?></p> 
            
		</div>
        
        <div style="clear: both"></div>
        
		<p class="projet_description"><?php echo $projet->projet_description; ?></p>
		<h3>Participants<?php 
		if($auteur->getIdbooster() != $_SESSION['user']['idbooster']){
			if(estInscritAuProjet($_SESSION['user']['idbooster'], $projet->projet_id)){
				echo "<a class='lieninscription' href='detailsProjet.php?
					projet=".$projet->projet_id."&desinscription=".$projet->projet_id."'>Se désinscrire</a>";
			} elseif(count($inscrits)>=$projet->projet_nb_membres){
				echo "<span class='lieninscription'>Inscriptions fermées</span>";
			} else {
				echo "<a class='lieninscription' href='detailsProjet.php?
					projet=".$projet->projet_id."&inscription=".$projet->projet_id."'>S'inscrire</a>";
			}
			echo "<br/>";
		}		
	?> </span></h3> 
		<p class="ilsparticipent">		
			<?php
            
            foreach($inscrits as $inscrit){
                echo '<a href="../etudiants/etudiants.php?idbooster='.$inscrit->student_idbooster.'"><img style="width:35px;" src="http://www.campus-booster.net/actorpictures/'.$inscrit->student_idbooster.'.jpg" title=""/></a>';
	}
	
	?></p>
    <!-- Affichage du lien pour modifier le projet si le student est le créateur -->
	
	<?php
	
		if($auteur->getIdbooster() == $_SESSION['user']['idbooster']){
			echo "<a href='administrerProjet.php?projet=".$projet->projet_id."'>Modifier mon projet</a> - ";	
		}
	
	?>
	<a href="projets.php">Retour à la liste des projets</a>
	</div>
    

		
	<?php
	
	}
		
	?>

</div>

<?php		

	require_once("../inclusions/layout/bas.php"); 

?>

