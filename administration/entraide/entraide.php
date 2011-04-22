<?php

	require_once('../inclusions/initialisation.php');
	require_once("../inclusions/layout/haut.php");
	
	if(isset($_POST['id']) && isset($_POST['question']) && isset($_POST['details']) && isset($_POST['date'])){
		updateEntraide($_POST['id'], $_POST['question'], $_POST['details'], $_POST['date']);
	} elseif(isset($_GET['delete'])){
		supprimerEntraide($_GET['delete']);
	} elseif(!isset($_POST['id']) && isset($_POST['question']) && isset($_POST['details']) && isset($_POST['date'])){
		creerEntraide($_POST['question'], $_POST['details'], $_POST['date']);
	}

?>
<style>
table {
	font-size:11px;
}
</style>

<div id="liste_evenements">
	<h2>Liste des Entraides</h2>
	
	<table>
		<tr>
			<th class="event_titre">Question</th>
			<th class="event_date">Date</th>
			<th class="event_participants">Auteur</th>
            <th class="event_participants">Rép</th>
			<th class="event_actions">Actions</th>
		</tr>
		
<?php
	$entraides = getAllEntraides();
	foreach($entraides as $entraide){
		if(strlen($entraide->entraide_question)>55){
			$entraide->entraide_question = substr($entraide->entraide_question, 0, 54)."...";
		}
		echo "
		<tr>
			<td>".utf8_encode($entraide->entraide_question)."</td>
			<td>".$entraide->entraide_date."</td>
			<td>".$entraide->entraide_auteur."</td>
			<td>".$entraide->entraide_resolu."</td>
			<td>
				<img class='modifier_entraide' title='".$entraide->entraide_id."' src='../images/modifier.png'/> 
				<a href='entraide.php?delete=".$entraide->entraide_id."'>
					<img title='".$entraide->entraide_id."' src='../images/supprimer2.png'/>
				</a>
			</td>
		</tr>";
	}
?>
	</table>
</div>

<div id="editer_evenements">
	<h2>Éditer une Question</h2>
	<div id="edition_event">
		<?php 
			printEditionEntraide(getIdDernierEntraide());
		?>
	</div>
</div>

<div style="clear:both;"></div>

<?php

	require_once("../inclusions/layout/bas.php");

?>