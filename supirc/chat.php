<?php

	header('Content-Type: text/html; charset=utf-8');

	require_once("../inclusions/configuration.php");
	require_once("../inclusions/auto_chargement_classes.php");
	require_once("../inclusions/fonctions.php");

	if(isset($_POST['idbooster']) && isset($_POST['pass'])){
		if(checkUserLogin($_POST['idbooster'], $_POST['pass'])){
		 	
		 	$fp = fopen("../inclusions/javascript/chat/chatbox.php","r");
		 	$recupMessage = false;
			while(!feof($fp)) {
		       	//$ligne = fgets($fp,255);
		       	$ligne = fgets($fp);
		       	if(preg_match("#<dt><b>.*</b>.*</dt><dd>.*</dd>#", $ligne)){
		       		echo $ligne;
		       	} else if(preg_match("#<dt><b>.*</b>.*</dt><dd>.*#", $ligne)){
		       		$recupMessage = true;
		       		$tempMessage = "";
		       		$tempMessage .= $ligne;
		       	} else if(preg_match("#.*</dd>#", $ligne) && $recupMessage){
		       		$recupMessage = false;
		       		$tempMessage .= $ligne;
		       		echo $tempMessage;
		       	} else if($recupMessage){
		       		$tempMessage .= $ligne;
		       	}
   			}
  	 		fclose($fp);	 	
		 	
		} else {
			echo "fail";
		}
	}

?>