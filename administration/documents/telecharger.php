<?php

	require_once('../inclusions/initialisation.php');

	$sourceDocument = getSourcesDocumentsAdmin($_GET['document']);
	if(!file_exists($sourceDocument[0])){
		$sourceDocument = getSourcesDocumentsAdmin($_GET['document'], false);
	}
	$fichier = explode("/", $sourceDocument[0]);
	$nom = $fichier[count($fichier) - 1];
	$chemin = substr($sourceDocument[0], 0, - strlen($nom));
	if($nom != "" && $chemin != ""){
		telechargerDocument($nom, $chemin);
	}

?>