<?php
	
	require_once("../inclusions/layout/haut.php");
	
	// ********** Ajout d'un projet
	
	if(isset($_POST['projet_nom']) && isset($_POST['projet_nb_membres']) && isset($_POST['projet_competences']) 
		&& isset($_POST['projet_icone']) && isset($_POST['projet_categorie']) && isset($_POST['projet_description'])){
	
		// si tous les champs obligatoires sont remplis, on ajoute le projet
		if($_POST['projet_nom']!="" && $_POST['projet_nb_membres']!="" && $_POST['projet_competences']!="" 
			&& $_POST['projet_icone']!="" && $_POST['projet_description']!="" && $_POST['projet_categorie']!=""){
			
			ajouterProjet($_POST['projet_nom'], $_POST['projet_nb_membres'], $_POST['projet_competences'], 
				$_POST['projet_icone'], $_POST['projet_description'], $_POST['projet_categorie'], 
				$_SESSION['user']['idbooster'], $_POST['projet_difficulte']);
				
			$fail_ajout = false;
			$succeed_ajout = true;
			
			unset($_POST);
							
		} else {
			$fail_ajout = true;
			$succeed_ajout = false;
		}
		
	}
	
	// ********** Supprimer un projet
	
	if(isset($_GET['supprimer'])){
		supprimerProjet($_GET['supprimer'], $_SESSION['user']['idbooster'], $_SESSION['user']['pass']);
	}
		
?>

<div id="projets">

<?php

	if(!(isset($_GET['proposer']) && $_GET['proposer'] == "true")){
	
?>

<!-- *********************** Liste des projets ***********************  -->

	<h2>Pôle Community : Les projets à Lille <div><a class="inactif" href="projets.php?proposer=true">Proposer votre projet</a></div></h2>
    
	<div id="categories">
    	<div class="categorie_actuelle" title="Tous">Tous</div>
    	<div title="Laboratoires">Laboratoires</div>
        <div title="Campus Tools">SUPINFO Tools</div>
        <div title="Campus Life">SUPINFO Life</div>
        <div title="Accomplissement personnel">Accomplissement Personnel</div>
    </div>
    
    <div style="clear:both"></div>
    
    <div id="affichageProjets">
    	<?php printAllProjets(); ?>
    </div>

<?php	
	
	} else {
	
?>

<!-- *********************** Proposer son projet ***********************  -->

	<h2><a class="inactif" href="projets.php">Pôle Community : Les projets à Lille</a> <div>Proposer votre projet</div></h2>
	
	<?php 
	
		if($fail_ajout){
			echo "<p id='fail_ajout_projet'>Merci de remplir tous les champs obligatoires pour soumettre votre projet :-)</p>";
		} elseif($succeed_ajout) {
			echo "<p id='succeed_ajout_projet'>Votre projet a bien été ajouté à la liste :-)</p>";
		}
	
	?>

	<form id="addProjet" method="post" action="projets.php?proposer=true">
	
		<div id="addProjet_etape1">
			<h1>1.</h1>
			<h3>Informations</h3><br/>
		
			Nom de votre projet : <br/>
			<input type="text" name="projet_nom" value="<?php echo stripcslashes($_POST['projet_nom']) ?>"/> <br/><br/>
			Icône pour votre projet (50x50) : <br/>
			<input type="text" name="projet_icone" value="<?php echo $_POST['projet_icone'] ?>"/> <br/><br/>
			Catégorie : <br/>
			<select name="projet_categorie">
				<option value="Laboratoires">Laboratoires</option>
				<option value="Campus Tools">Campus Tools</option>
				<option value="Campus Life">Campus Life</option>
				<option value="Accomplissement personnel">Accomplissement personnel</option>
			</select> <br/><br/>
		</div>
		
		<div id="addProjet_etape2">
			<h1>2.</h1>
			<h3>Pour qui ?</h3><br/>
			
			Nombre de membres :
			<select name="projet_nb_membres">
            	<?php 
            		for($i=1; $i<=50; $i++){
            			echo "<option value='".$i."'>".$i."</option>";
            		}
            	?>
            </select><br/><br/>
			Difficulté du projet : 
			<select name="projet_difficulte">
            	<?php 
            		for($i=1; $i<=5; $i++){
            			echo "<option value='".$i."'>".$i."</option>";
            		}
            	?>
            </select> / 5 <br/><br/>
            Compétences requises : <br/>
			<input type="text" name="projet_competences" value="<?php echo stripcslashes($_POST['projet_competences']) ?>"/> <br/><br/>
		</div>
		
		<div id="addProjet_etape3">
			<h1>3.</h1>
			<h3>Description</h3>
			
			<textarea name="projet_description"><?php echo stripcslashes($_POST['projet_description']) ?></textarea> <br/><br/>
		</div>
		
		<div id="addProjet_submit">
			<input type="submit" value="Ajouter mon projet"/>
		</div>
				
	</form>

<?php
	
	}

?>

</div>

<?php		

	require_once("../inclusions/layout/bas.php");
	
?>

