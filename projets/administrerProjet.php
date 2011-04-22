<?php

	require_once("../inclusions/layout/haut.php");
		
?>

<div id="administrerProjet">


	<!-- On teste d'abord si le projet en GET existe ou non... Histoire de pas fail. -->

	<?php
	
	if(!isset($_GET['projet']) || !ceProjetExiste($_GET['projet'])){
		
		echo "<p id='fail_details_projet'>
			Ce projet n'existe pas. Si c'est une erreur de notre part, merci de nous contacter ! Sinon, arrétez de faire vos malins :D
		</p>";
		
	} else {
	
		$projet = getProjetDetails($_GET['projet']); 
	
		if($projet->projet_auteur != $_SESSION['user']['idbooster']){
			echo "<p id='fail_details_projet'>Vous n'êtes pas administrateur de ce projet.</p>";
		} else {
		
			// ********** Virer les students d'un projet
	
			if(isset($_GET['virer'])){
				virerStudentProjet($_GET['projet'], $_GET['virer']);
			}
			
			// ********** Modifier un projet
	
			if(isset($_POST['projet_nom']) && isset($_POST['projet_nb_membres']) && isset($_POST['projet_competences']) 
				&& isset($_POST['projet_icone']) && isset($_POST['projet_categorie']) && isset($_POST['projet_description'])){
	
				// si tous les champs obligatoires sont remplis, on ajoute le projet
				if($_POST['projet_nom']!="" && $_POST['projet_nb_membres']!="" && $_POST['projet_competences']!="" 
					&& $_POST['projet_icone']!="" && $_POST['projet_description']!="" && $_POST['projet_categorie']!=""){
			
					modifierProjet($_POST['projet_nom'], $_POST['projet_nb_membres'], $_POST['projet_competences'], 
						$_POST['projet_icone'], $_POST['projet_description'], $_POST['projet_categorie'], 
						$_SESSION['user']['idbooster'], $_POST['projet_difficulte'], $_POST['projet_id']);
				
					$fail_ajout = false;
					$succeed_ajout = true;
			
					unset($_POST);
							
				} else {
					$fail_ajout = true;
					$succeed_ajout = false;
				}
		
			}
			
			$projet = getProjetDetails($_GET['projet']);
			$inscrits = getAllInscritsProjet($_GET['projet']);
	
	?>
	
	<!-- Affichage de l'administration ici -->
	
	<h2>Modifier les informations<div><a href="projets.php">Retour aux projets</a></div></h2>
	
	<div id="modifierProjet">
	
	<?php
	
		if($fail_ajout){
			echo "<p id='fail_ajout_projet'>Merci de remplir tous les champs obligatoires pour modifier votre projet :-)</p>";
		} elseif($succeed_ajout) {
			echo "<p id='succeed_ajout_projet'>Votre projet a bien été modifié :-)</p>";
		}
	
	?>
	
		<form method="post" action="administrerProjet.php?projet=<?php echo $_GET['projet']; ?>">
		
			<input type="hidden" name="projet_id" value="<?php echo $projet->projet_id ?>"/>
	
		<div id="modifierProjet_etape1">
			Nom de votre projet : <br/>
			<input type="text" name="projet_nom" value="<?php echo stripcslashes($projet->projet_nom) ?>"/> <br/><br/>
			Icône pour votre projet (50x50) : <br/>
			<input type="text" name="projet_icone" value="<?php echo $projet->projet_icone ?>"/> <br/><br/>
			Catégorie : <br/>
			<select name="projet_categorie">
				<option 
					<?php if($projet->projet_categorie=="Laboratoires"){echo "selected='selected'";} ?> 
					value="Laboratoires">Laboratoires</option>
				<option 
					<?php if($projet->projet_categorie=="Campus Tools"){echo "selected='selected'";} ?> 
					value="Campus Tools">Campus Tools</option>
				<option 
					<?php if($projet->projet_categorie=="Campus Life"){echo "selected='selected'";} ?> 
					value="Campus Life">Campus Life</option>
				<option 
					<?php if($projet->projet_categorie=="Accomplissement personnel"){echo "selected='selected'";} ?> 
					value="Accomplissement personnel">Accomplissement personnel</option>
			</select>
		</div>
		
		<div id="modifierProjet_etape2">
			Nombre de membres :
			<select name="projet_nb_membres">
            	<?php 
            		for($i=1; $i<=50; $i++){
            			if($i == $projet->projet_nb_membres){
            				echo "<option selected='selected' value='".$i."'>".$i."</option>";
            			} else {
            				echo "<option value='".$i."'>".$i."</option>";
            			}
            		}
            	?>
            </select><br/><br/>
			Difficulté du projet : 
			<select name="projet_difficulte">
            	<?php 
            		for($i=1; $i<=5; $i++){
            			if($i == $projet->projet_difficulte){
            				echo "<option selected='selected' value='".$i."'>".$i."</option>";
            			} else {
            				echo "<option value='".$i."'>".$i."</option>";
            			}
            		}
            	?>
            </select> / 5 <br/><br/>
            Compétences requises : <br/>
			<input type="text" name="projet_competences" value="<?php echo stripcslashes($projet->projet_competences) ?>"/>
		</div>
		
		<div id="modifierProjet_etape3">
			Description : <br/><br/>
			<textarea name="projet_description"><?php echo stripcslashes($projet->projet_description) ?></textarea>
		</div>
		
		<div id="modifierProjet_submit">
			<input type="submit" value="Modifier mon projet"/>
		</div>
	
	</div>
	
	<h2>Gérer les participants</h2>
	
	<div id="gererParticipants">
	
		<?php
		
		if(count($inscrits)==1){
			echo "<em>Aucun participant pour le moment</em>";
		} else {
			foreach($inscrits as $inscrit){
				if($inscrit->student_idbooster != $projet->projet_auteur){
					echo "
						<div class='participant'>
							<a target='_BLANK' href='../etudiants/etudiants.php?idbooster=".$inscrit->student_idbooster."'>
								<img src='http://www.campus-booster.net/actorpictures/".$inscrit->student_idbooster.".jpg' 
								title='".$inscrit->student_idbooster."'/>
							</a> <br/>
							<a href='administrerProjet.php?projet=".$_GET['projet']."&virer=".$inscrit->student_idbooster."'>Virer</a>
						</div>
					";
				}
			}
		}
		
		?>
		
		<div style="clear:both"></div>
	
	</div>
	
	<h2>Supprimer mon projet</h2>
	
	<p><em>Attention, si vous décidez de supprimer votre projet, vous ne pourrez plus récupérer ses informations. Tous les membres du projet recevront une notification leur indicant la suppression de votre projet de la plate-forme. Réfléchissez bien :-)</em></p>
	
	<p id="supprimerProjet">
		<a href="projets.php?supprimer=<?php echo $projet->projet_id ?>">
			<span>/!\</span> Supprimer mon projet <span>/!\</span>
		</a>
	</p>
			
	<?php
	
		}
	}
		
	?>

</div>

<?php		

	require_once("../inclusions/layout/bas.php");

?>