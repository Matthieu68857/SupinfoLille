<?php

	require_once('../inclusions/initialisation.php');
	require_once('../inclusions/librairies/pclzip.php');

	if($_GET['section'] == "telechargements"){		
		$documents = explode("a", $_GET['documents']);
		$documents = array_unique($documents);
			
		if($documents[0] != ""){
			$fichier = explode("/", getArchive($documents));
			$nom = $fichier[count($fichier) - 1];
			if($nom != ""){
				telechargerDocument($nom, "telechargements/");
			}
		}
	} else if($_GET['section'] == "ddl"){		
		$sourceDocument = getSourcesDocuments($_GET['document']);
		$fichier = explode("/", $sourceDocument[0]);
		$nom = $fichier[count($fichier) - 1];
		$chemin = substr($sourceDocument[0], 0, - strlen($nom));
		majNombreTelechargements($_GET['document']);
		if($nom != "" && $chemin != ""){
			telechargerDocument($nom, $chemin);
		}
	}

?>