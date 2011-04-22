<?php

	require_once("../inclusions/layout/haut.php");
	
?>
	
<div id="matieres">
	<h2>Matières</h2>
	<h3 id="choix_promo"><span class="choix_promo">B1</span> | <span class="choix_promo">B2</span> | <span class="choix_promo">B3</span> | <span class="choix_promo">M1</span></h3>
	<div id="liste_matieres">
	<?php
	
	$student = new Student($_SESSION['user']['idbooster']);
	
	printListeMatieres($student->getPromo());
	
	?>
	</div>
</div>

<div id="documents">
	<h2>Documents <span id="matiere_en_cours"></span></h2>
	<div id="liste_documents">
	<p>Choisissez la promo de votre choix, cliquez sur une matière disponnible puis Drag&Dropper à droite les fichiers que vous voulez télécharger.</p>
	</div>
</div>

<div id="telechargements">
	<h2>Téléchargements</h2>
	<div id="liste_telechargements">
	<span class="placeholder">Drag&Dropper ici les fichiers que vous voulez télécharger.</span>
	</div><br/>
	<div id="telechargements_actions">
		<input id="bouton_telecharger" type="button" value="Télécharger"/>
		<input id="bouton_vider" type="button" value="Vider"/>
		<hr/>
		<input id="bouton_proposer" type="button" value="Proposer un document"/>
		<p class="loaderTelechargement"><img src="../images/ajax-loader.gif"/></p>
	</div>
</div>

<div style="clear:both"></div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>

