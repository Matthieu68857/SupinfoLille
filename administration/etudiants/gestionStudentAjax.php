<?php
	
	require_once('../inclusions/initialisation.php');
	
	if($_GET['idbooster'] == 300){
		echo "<p style='color:red; font-weight:bold; font-size:20px; text-align:center; margin-top:80px;'>Personne ne peut éditer Dieu !</p>";
	}	else {
		printStudentProfileToEdit($_GET['idbooster']);
	}

?>