<?php

	require_once("../inclusions/layout/haut.php");

?>

<div id="outilsSTA">

	<h2>Random pour le Bouc émissaire </h2>
	
	<div id="randomStudent">
	
		<strong>Promotion :</strong>
			<span id="selectPromo">
				<input checked="checked" type="radio" name="promo" value="B1" id="B1"/> <label for="B1">B1</label>
				<input type="radio" name="promo" value="B2" id="B2"/> <label for="B2">B2</label>
			</span>
			
			<br/><br/>
	
		<strong>Méthode :</strong>
			<span id="selectMethode">
				<input type="radio" value="visites" name="methode" id="visites"/> <label for="visites">Visites</label>
				<input checked="checked" type="radio" value="random" name="methode" id="random"/> <label for="random">Random</label>
				<input type="radio" value="sondage" name="methode" id="sondage"/> <label for="sondage">Sondage</label>
				<input type="button" value="Quel élève ?"/>
			</span>
			
		<div id="randomStudentReponse"></div>
	
	</div>
	
		<br/>
		
	<h2>Random pour la torture</h2>

	<div id="randomSujet">
		<strong>Borne inférieure :</strong> 
		<select id="borneInf">
			<?php
				for($i=1; $i<=100; $i++){
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
			?>
		</select> 
		<strong>Borne supérieure :</strong> 
		<select id="borneSup">
			<?php
				for($i=2; $i<=100; $i++){
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
			?>
		</select> 
		<input type="button" value="Quel sujet ?"/>
		<div id="randomSujetReponse"></div>
	</div>	

<?php



?>
	
</div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>