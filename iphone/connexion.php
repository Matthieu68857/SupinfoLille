<?php
require_once('../inclusions/configuration.php');
require_once('../inclusions/auto_chargement_classes.php');
require_once("../inclusions/fonctions.php");


if(isset($_GET['idbooster']) && !empty($_GET['idbooster']) && isset($_GET['pass']) && !empty($_GET['pass'])){
	extract($_GET);
	if(checkUserLogin($idbooster,md5($pass))){
		echo '1';
	}
	else {
		echo '0';
	}


}
?>