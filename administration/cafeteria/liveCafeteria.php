<?php

	require_once('../inclusions/initialisation.php');
	require_once("../inclusions/layout/haut.php");
	
	if(isset($_GET['heures']) && isset($_GET['minutes']) && !empty($_GET['heures']) && !empty($_GET['minutes'])){
	
		$date = $_GET['heures'] . "H" . $_GET['minutes'];
	
	} else {
	
		$date = date('H\Hi');
	
	}
		
?>

	<div id="liveCafeteria">
		<h2>Live Cafétéria</h2>
		<div id="live">
			<input type="hidden" name="date" value="<?php echo $date; ?>"/>
			<p style="text-align:center;">
				Les derniers achats depuis <strong style="color:red;"><?php echo $date; ?></strong>
				(	<input type="button" value="Changer l'heure"/>
					<input type="text" name="heures"/> H
					<input type="text" name="minutes"/>
				) </p>
			<hr/>
			<div id="liveTable">
				<table>
					<tr><th>ID</th><th>Étudiant</th><th>Consommation</th><th>Date</th></tr>
				</table>
			</div>
		</div>
	</div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>