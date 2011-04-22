<?php

session_start();

require_once('../inclusions/configuration.php');
require_once('../inclusions/auto_chargement_classes.php');
require_once("../inclusions/fonctions.php");

if(isset($_POST['message']) && isset($_POST['idbooster']) && checkUserLogin($_POST['idbooster'], $_POST['pass'])) { 

	addChatMessage("supirc", $_POST['idbooster'], $_POST['message']);
	
}

?>