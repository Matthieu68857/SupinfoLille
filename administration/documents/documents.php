<?php

	require_once('../inclusions/initialisation.php');
	require_once("../inclusions/layout/haut.php");
		
	if(isset($_POST['matiereToAdd']) && isset($_POST['cursus']) && isset($_POST['nomComplet'])){
		ajouterMatiere($_POST['matiereToAdd'], $_POST['nomComplet'], $_POST['cursus']);
	}
	
	if(isset($_GET['supprimer'])){
		supprimerDocument($_GET['supprimer'], $_GET['cursus']);
	}
	
	if(isset($_GET['valider']) && isset($_GET['chemin']) && isset($_GET['cursus']) && isset($_GET['matiere'])){
		validerDocument($_GET['valider'], $_GET['chemin'], $_GET['cursus'], $_GET['matiere']);
	}
	
	if(isset($_GET['desactiver'])){
		desactiverDocument($_GET['desactiver']);
	}
	
	if(isset($_GET['affichage'])){
		$affichage = $_GET['affichage'];
	} else {
		$affichage = "%";
	}
	
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	} else {
		$page = "1";
	}

?>

<div id="gerer_documents">

	<h2><a href="documents.php?affichage=%">Gérer les documents</a>
		<div>
			<a href="documents.php?affichage=B1">B1</a> - 
			<a href="documents.php?affichage=B2">B2</a> - 
			<a href="documents.php?affichage=B3">B3</a> -
			<a href="documents.php?affichage=M1">M1</a>
		</div>
	</h2>
	
	<table>
		<tr><th>Matière</th><th>Document</th><th>DLs</th><th>Actions</th></tr> 
	
	<?php
	
		$documents = getAllDocuments($affichage, $page);
				
		foreach($documents as $document){
			
			$actions = "<a target='_blank' href='../etudiants/etudiants.php?idbooster=". $document->student_id ."'><img src='../images/auteur.png'/></a>
						<a href='documents.php?supprimer=". $document->document_id ."&cursus=". $document->matiere_cursus ."'>
							<img class='supprimerDocument' src='../images/supprimer2.png'/>
						</a>";
					
			if($document->document_status == 0){
				$actions = "
					<a href='telecharger.php?document=" . $document->document_id . "'>
						<img src='../images/telecharger.png'/>
					</a> " . $actions;
				$actions = "
					<a href='documents.php?valider=". $document->document_id .
						"&chemin=".$document->document_chemin.
						"&cursus=".$document->matiere_cursus.
						"&matiere=".$document->matiere_id."'>
							<img src='../images/desactiver.png'/>
					</a> " . $actions;
			} else {
				$actions = "
					<a href='telecharger.php?document=" . $document->document_id . "'>
						<img src='../images/telecharger.png'/>
					</a> " . $actions;
				$actions = "
					<a href='documents.php?desactiver=". $document->document_id . "'>
							<img src='../images/valider2.png'/>
					</a> " . $actions;
			}
			
			echo "<tr>
				<td class='cursusDocument'>".$document->matiere_cursus." - ".$document->matiere_nom."</td>
				<td class='nomDocument' title='". $document->document_id ."'>".$document->document_nom."</td>
				<td class='dlsDocument'>".$document->document_telechargements."</td>
				<td class='actionsDocument'>".$actions."</td></tr>";
		}
	
	?>
	
	</table>
	
	<p id="pagesDocuments">
		<?php
			$nbPages = ceil(getNbDocuments($affichage)/10);
			for($i=1; $i <= $nbPages; $i++){
				if($i == $page){
					$actifOuPas = "pageDocumentsActive";
				} else {
					$actifOuPas = "";
				}
				echo "<a class='".$actifOuPas."' href='documents.php?affichage=".$affichage."&page=".$i."'>" . $i . "</a>";
			}
		?>
	</p>

</div>

<div id="actionsDiversesDocuments">
	
	<div id="statsDocuments">
		<h2>Statistiques</h2>
		
		<strong>Matières : </strong> <span><?php echo getNbMatieres(); ?></span> <br/>
		<strong>Documents tous cursus : </strong> <span><?php echo getNbDocuments('%'); ?></span> <br/>
		<strong>Documents B1 : </strong> <span><?php echo getNbDocuments('B1'); ?></span> <br/>
		<strong>Documents B2 : </strong> <span><?php echo getNbDocuments('B2'); ?></span> <br/>
		<strong>Documents B3 : </strong> <span><?php echo getNbDocuments('B3'); ?></span> <br/>
		<strong>Documents M1 : </strong> <span><?php echo getNbDocuments('M1'); ?></span> <br/>
		<strong>Téléchargements : </strong> <span><?php echo getNbTelechargements(); ?></span>
	</div>

</div>

<div style="clear:both"></div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>