<?php

require_once('../inclusions/configuration.php');

$name = explode(".", $_SERVER['SERVER_NAME']);

if($name[0] == "stages"){
	//header('location: ' . GBL_NDD_WWW . "/sbn/");
	setcookie('sbn', "true", time() + 31*24*3600, '/', '.' . GBL_NDD);
}

header('location: stages.php');

?>