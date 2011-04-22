<?php

	require_once('../inclusions/initialisation.php');

	if(isset($_GET['total']) && isset($_GET['student'])){	
		$BDD->update(
			"TB_STUDENTS",
			array("student_solde_cafeteria = student_solde_cafeteria - ?"),
			"student_idbooster = ?",
			array($_GET['total'], $_GET['student'])
		);
	}

?>