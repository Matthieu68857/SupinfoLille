<?php

	require_once('../inclusions/initialisation.php');

	if($_GET['section'] == "matieres"){
		printListeMatieres($_GET['promo']);
	} else if($_GET['section'] == "documents"){
		printListeDocuments($_GET['matiere']);
	}

?>