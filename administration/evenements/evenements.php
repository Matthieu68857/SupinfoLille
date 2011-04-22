<?php

	require_once('../inclusions/initialisation.php');
	
	if(isset($_POST['id']) && isset($_POST['titre']) && isset($_POST['ss_titre']) && isset($_POST['date']) && isset($_POST['description'])){
		updateEvenement($_POST['id'], $_POST['titre'], $_POST['ss_titre'], $_POST['date'], stripcslashes($_POST['description']));
	} elseif(isset($_GET['delete'])){
		supprimerEvenement($_GET['delete']);
	} elseif(!isset($_POST['id']) && isset($_POST['titre']) && isset($_POST['ss_titre']) && isset($_POST['date']) && isset($_POST['description'])){
		if(isset($_POST['publierSurTwitter'])){
			creerEvenement($_POST['titre'], $_POST['ss_titre'], $_POST['date'], stripcslashes($_POST['description']), true);
		} else {
			creerEvenement($_POST['titre'], $_POST['ss_titre'], $_POST['date'], stripcslashes($_POST['description']), false);
		}
	}

	require_once("../inclusions/layout/haut.php");

?>

<div id="liste_evenements">
	<h2>Liste des Événements <div>Créer</div></h2>
	
	<table>
		<tr>
			<th class="event_titre">Titre</th>
			<th class="event_date">Date</th>
			<th class="event_participants">Yes</th>
			<th class="event_actions">Actions</th>
		</tr>
		
<?php
	$evenements = getAllEvenements();
	foreach($evenements as $evenement){
		if(strlen($evenement->evenement_titre)>25){
			$evenement->evenement_titre = substr($evenement->evenement_titre, 0, 24);
		}
		echo "
		<tr>
			<td>".$evenement->evenement_titre."</td>
			<td>".$evenement->evenement_date."</td>
			<td>".$evenement->evenement_participants."</td>
			<td>
				<img class='modifier_event' title='".$evenement->evenement_id."' src='../images/modifier.png'/> 
				<a href='evenements.php?delete=".$evenement->evenement_id."'>
					<img title='".$evenement->evenement_id."' src='../images/supprimer2.png'/>
				</a>
			</td>
		</tr>";
	}
?>
	</table>
</div>

<div id="editer_evenements">
	<h2>Éditer un événement</h2>
	<div id="edition_event">
		<?php 
			printEditionEvenement(getIdDernierEvenement());
		?>
	</div>
</div>


<?php

	require_once("../inclusions/layout/bas.php");

?>