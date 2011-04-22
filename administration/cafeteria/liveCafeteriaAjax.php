<?php

	require_once('../inclusions/initialisation.php');
	
	$consos = getHistoriqueConsommationsJourAt($_GET['date']);

?>

	<table>
		<tr><th>ID</th><th>Étudiant</th><th>Consommation</th><th>Date</th></tr>
<?php
		foreach($consos as $conso){
			$date = explode(" ", $conso->historique_date);
			echo "
			<tr>
				<td>".$conso->historique_id."</td>
				<td>".$conso->student_nom." ".$conso->student_prenom." (".$conso->student_idbooster.")</td>
				<td>".$conso->produit_nom."</td>
				<td>".$date[1]."</td>
			</tr>";
		}
?>
	</table>	