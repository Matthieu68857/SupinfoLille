<?php

	require_once("../inclusions/layout/haut.php");
	
	if(isset($_POST['badge']) && isset($_POST['idbooster'])){
		addBadgeToStudent($_POST['idbooster'], $_POST['badge']);
	}
	
	$badges = getListeBadges();

?>

	<div id="check_badges">
		
		<h2>Checker nouveaux badges</h2>
		
		<p style="text-align:center">
			<input type="button" value="Check !"/>
		</p>
		
		<div id="resultats">
		
		</div>

	</div>
	
	<div id="valider_badge">
	
		<h2>Valider un badge</h2>
		
		<form action="gestionBadgesCafeteria.php" method="post">
		
			ID Booster : <input type="text" name="idbooster"/><br/><br/>
			Badge :
			<select name="badge">
			<?php
				foreach($badges as $badge){
					echo "<option value='".$badge->badge_id."'>". utf8_encode($badge->badge_nom) ."</option>";
				}
			?>
			</select><br/><br/>
			
			<input type="submit" value="Valider"/>
		
		</form>
		
	</div>

	<div style="clear:both"></div>
	
	<p style="text-align:center; font-size: 18px;">
		<a href="cafeteria.php">Retourner à la gestion de la cafétéria</a>
	</p>

<?php

	require_once("../inclusions/layout/bas.php");

?>