<?php

	require_once('../inclusions/initialisation.php');
	require_once("../inclusions/layout/haut.php");

?>

<div id="recherche_student">

	<h2>Rechercher un étudiant du Campus</h2>
	
	<input type="text" name="recherche_student" value="Nom, Prénom, ID Booster ..."/>
	<input type="button" name="recherche_student_button" value="Rechercher"/>
	
	<div id="resultat_recherche">
	
	</div>

</div>

<div id="profile_student">

<?php

	if(isset($_GET['idbooster'])){
		printStudentProfileToEdit($_GET['idbooster']);
	} else {
		printStudentProfileToEdit($_SESSION['user']['idbooster']);
	}

?>

</div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>