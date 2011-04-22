<?php

	require_once('../inclusions/initialisation.php');
		
	$ext = explode(".", $_GET['chemin']);
	$ext = $ext[count($ext)-1];	
		
	if($ext == "php" || $ext == "html" || $ext == "htm" || $ext == "js" || $ext == "css"){
		$ext = "web";
	} elseif($ext != "zip" && $ext != "xls" && $ext != "pdf" && $ext != "doc") {
		$ext = "autres";
	}
		
	if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/documents/uploads/".stripAccents($_GET['chemin']))){
		ajouterDocument($_GET['nom'], 
			preg_replace("# #","", 
			stripAccents($_GET['chemin'])), $ext, $_SESSION['user']['idbooster'], $_GET['matiere']);
	}	
	
?>