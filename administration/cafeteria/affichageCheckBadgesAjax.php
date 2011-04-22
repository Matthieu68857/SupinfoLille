<?php

	require_once('../inclusions/initialisation.php');
	
	$retour = $BDD->callStoredProcedure("checkBadgesValidation");
	
	$resultats = explode(' | ', $retour[0]->resultat);
	
?>

	<table>
		<tr><th>Winner</th><th>Badge</th></tr>

<?php
	
	foreach($resultats as $resultat){
		$winner = explode(" remporte le badge ", $resultat);
		echo "<tr><td>".$winner[0]."</td><td>".utf8_encode($winner[1])."</td></tr>";
	}

?>

	</table>
