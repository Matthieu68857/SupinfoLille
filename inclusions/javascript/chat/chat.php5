<?php

session_start();

require_once('../../configuration.php');
require_once('../../auto_chargement_classes.php');
require_once("../../fonctions/main.php");

if(isset($_POST['message']) && isset($_SESSION['user']['idbooster'])) { 

	addChatMessage("root", $_SESSION['user']['idbooster'], $_POST['message']);
	
}

?>