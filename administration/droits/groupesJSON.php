<?php
	require('../inclusions/initialisation.php');
	
	if($_GET['term'] == "all"){
		$groupesBDD = getGroupes("");
	} else {
		$groupesBDD = getGroupes($_GET['term']);
	}
	
	$groupes = array();
	
	foreach($groupesBDD as $groupe){
		array_push(
			$groupes, 
			array(
				'value' => $groupe['id'],
				'label' => ucfirst($groupe['nom'])
			)
		);
	}	
	
	echo json_encode($groupes);
?>