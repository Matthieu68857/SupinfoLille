<?php

	require_once("../inclusions/layout/haut.php");

?>

<div id="meilleurs_visiteurs">
	<h2>Les 10 visiteurs les plus réguliers</h2>
	<table>
	<?php
		$students = getMeilleursStudentsVisites(10);
		$i = 1;
		
		foreach($students as $student){
			echo "
			<tr>
				<td><strong>N°".$i."</strong></td>  
				<td>
					<a href='../etudiants.php?idbooster=". $student->student_idbooster ."'>
						<img src='http://www.campus-booster.net/actorpictures/" . $student->student_idbooster . ".jpg'/>
					</a>
				</td>
				<td>" . $student->student_prenom . " " . $student->student_nom . "</td>
				<td><strong>" . $student->student_visites . " visites</strong></td>
			</tr>";
			$i++;
		}
	?>
	</table>
</div>

<div id="meilleurs_documents">
	<h2>Les 5 meilleurs téléchargements</h2>
	<?php
		$documents = getMeilleursDocumentsTelechargements(5);
		$j = 1;
		
		foreach($documents as $document){
			echo "<strong>N°".$j."</strong> : <em>(" . 
			$document->matiere_cursus . ") " . $document->matiere_nom . "</em> - " . 
			$document->document_nom . " avec <strong>" . $document->document_telechargements . " téléchargements</strong> <br/><br/>";
			$j++;
		}
	?>
</div>

<div style="clear:both"></div>

<?php $students = getStudentsVisiteAujourdhui(); ?>

<div id="visiteurs_aujourdhui">
	<h2>Les Étudiants venus aujourd'hui <strong>(<?php echo count($students) ?>)</strong></h2>
	<?php
		
		$students = getStudentsVisiteAujourdhui();
		
		foreach($students as $student){
			
			echo "
			<a href='../etudiants.php?idbooster=". $student->student_idbooster ."'>
				<img src='http://www.campus-booster.net/actorpictures/" . $student->student_idbooster . ".jpg'/>
			</a>";
			
		}
		
	?>
</div>

<?php

	require_once("../inclusions/layout/bas.php");

?>