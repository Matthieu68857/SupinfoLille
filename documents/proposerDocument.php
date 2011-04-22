<?php

	require_once("../inclusions/layout/haut.php");
	
	if(isset($_FILES['fichier']) && isset($_POST['nom_fichier']) && isset($_POST['matiere_fichier']) && !empty($_FILES['fichier']) && !empty($_POST['nom_fichier']) && !empty($_POST['matiere_fichier'])){
		$upload = "";
		uploadDocument($_FILES['fichier'], $_POST['nom_fichier'], $_POST['matiere_fichier']);
	}

	$matieres = getAllMatieres();
		
?>

<div id="proposerDocument">
	
	<h2>Proposer un document<div><img src='../images/ajax-loader.gif'/></div></h2>
	
	<?php
		if(isset($upload)){
			echo '<p class="uploadInfos">' . $upload . "</p>";
		}
	?>
	
	<p id="texteProposer">Pour proposer un document, il vous suffit de choisir la matière correspondante, son nom, puis de choisir votre fichier.<br/>
	Une fois toutes les informations renseignées, cliquez sur "Proposer mon document". Ainsi votre document sera uploadé sur notre serveur et sera proposé aux administrateurs.</p>
	<form method="post" action="proposerDocument.php" enctype="multipart/form-data">
		<strong>Matière de votre document :</strong> <select id="matiere_fichier" name="matiere_fichier">
			<optgroup label="B1">
				<?php
					foreach($matieres as $matiere){
						if($matiere->matiere_cursus == "B1"){
							echo '<option value="'. $matiere->matiere_id .'">'. $matiere->matiere_nom_complet .'</option>';
						}
					}
				?>
			</optgroup>
			<optgroup label="B2">
				<?php
					foreach($matieres as $matiere){
						if($matiere->matiere_cursus == "B2"){
							echo '<option value="'. $matiere->matiere_id .'">'. $matiere->matiere_nom_complet .'</option>';
						}
					}
				?>
			</optgroup>
			<optgroup label="B3">
				<?php
					foreach($matieres as $matiere){
						if($matiere->matiere_cursus == "B3"){
							echo '<option value="'. $matiere->matiere_id .'">'. $matiere->matiere_nom_complet .'</option>';
						}
					}
				?>
			</optgroup>
			<optgroup label="M1">
				<?php
					foreach($matieres as $matiere){
						if($matiere->matiere_cursus == "M1"){
							echo '<option value="'. $matiere->matiere_id .'">'. $matiere->matiere_nom_complet .'</option>';
						}
					}
				?>
			</optgroup>
		</select><br/><br/>
	
		<strong>Nom de votre document :</strong> <input id="nom_fichier" type="text" name="nom_fichier"/><br/><br/>
		<strong>Choisissez votre fichier :</strong><input id="fichier" name="fichier" type="file" />
		<p style="text-align:center">
			<input id="bouton_proposer" type="submit" value="Proposer mon document"/>
		</p>
	</form>
	
</div>

<div id="derniersDocuments">

	<h2>Derniers documents</h2>
	
	<ul>
	
		<?php
	
		$documents = getDerniersDocuments();
	
		foreach($documents as $document){
	
			echo "<li>". $document->document_nom ."</li>";
	
		}
	
		?>
		
	</ul>

</div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>

