<?php

	require_once('../inclusions/initialisation.php');
	
	$path = explode('/', $_SERVER['PHP_SELF']);
	$categorie = $path[count($path) - 2];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Administration Portail SUPINFO-Lille</title>
	<link rel="shortcut icon" type="image/x-icon" href="../../images/favicon.ico">
	
	<!-- Inclusions CSS Jquery + Plugins -->
	<link rel="stylesheet" type="text/css" href="../../inclusions/css/jquery-ui/jquery-ui-1.8.5.custom.css" /> 
	<link rel="stylesheet" type="text/css" href="../../inclusions/javascript/chat/chat.css" />
	
	<!-- Inclusions CSS Client -->
	<link rel="stylesheet" type="text/css" href="../../inclusions/css/main.css" />
	<link rel="stylesheet" type="text/css" href="../../inclusions/css/cafeteria.css" />
	<link rel="stylesheet" type="text/css" href="../../inclusions/css/documents.css" />
	<link rel="stylesheet" type="text/css" href="../../inclusions/css/entraide.css" />
	<link rel="stylesheet" type="text/css" href="../../inclusions/css/etudiants.css" />
	<link rel="stylesheet" type="text/css" href="../../inclusions/css/evenements.css" />
	<link rel="stylesheet" type="text/css" href="../../inclusions/css/moncompte.css" />
	<link rel="stylesheet" type="text/css" href="../../inclusions/css/projets.css" />
	<link rel="stylesheet" type="text/css" href="../../inclusions/css/sondages.css" />
		
	<!-- Inclusions CSS Admin -->
    <link type="text/css" rel="stylesheet" href="../inclusions/css/cafeteria.css" />
    <link type="text/css" rel="stylesheet" href="../inclusions/css/documents.css" />
    <link type="text/css" rel="stylesheet" href="../inclusions/css/droits.css" />
    <link type="text/css" rel="stylesheet" href="../inclusions/css/etudiants.css" />
    <link type="text/css" rel="stylesheet" href="../inclusions/css/evenements.css" />
    <link type="text/css" rel="stylesheet" href="../inclusions/css/main.css" />
    <link type="text/css" rel="stylesheet" href="../inclusions/css/sta.css" />
	<?php if($categorie == "sbn"){ ?>
	<link rel="stylesheet" type="text/css" href="../inclusions/css/sbn.css" />
	<?php } ?>
    
	<!-- Inclusions JS jQuery + Plugins -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>
    <script type="text/javascript" src="../../inclusions/javascript/jquery-ui-1.8.5.custom.min.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/productsBasket.js"></script>
    <script type="text/javascript" src="../inclusions/javascript/ckeditor/ckeditor.js"></script>
    
	<!-- Inclusions JS Admin -->
    <script type="text/javascript" src="../inclusions/javascript/cafeteria.js"></script>
    <script type="text/javascript" src="../inclusions/javascript/documents.js"></script>
    <script type="text/javascript" src="../inclusions/javascript/entraide.js"></script>
    <script type="text/javascript" src="../inclusions/javascript/etudiants.js"></script>
    <script type="text/javascript" src="../inclusions/javascript/evenements.js"></script>
    <script type="text/javascript" src="../inclusions/javascript/main.js"></script>
    <script type="text/javascript" src="../inclusions/javascript/sondages.js"></script>
    <script type="text/javascript" src="../inclusions/javascript/sta.js"></script>
    <script type="text/javascript" src="../inclusions/javascript/droits.js"></script>
    <?php if($categorie == "sbn"){ ?>
	<script type="text/javascript" src="../inclusions/javascript/sbn.js"></script>
	<?php } ?>
	<?php if($categorie == "cafeteria"){ ?>
    <script type="text/javascript">
        $(document).ready(function(){
            productsBasket();
        });
    </script>
    <?php } ?>
</head>

<body>

<div id="wrapper">

<div id="logo" onclick="location.href='../accueil/index.php'"></div>
	<div id="menu"><div id="encartmenu">
    <div id="photo-haut"><?php echo '<a href="../../moncompte.php"><img src="http://www.campus-booster.net/actorpictures/' . $_SESSION['user']['idbooster'] . '.jpg" style="height:60px;-moz-border-radius:10px; -webkit-border-radius:10px; border:3px solid white;"/></a>'; ?></div> <div id="textmenu"><p><a href="../moncompte.php">Mon compte</a><?php if ($_SESSION['user']['status'] == 2) { echo "<span>-</span><span><a href='../../index.php'>Retour au Site</a></span>"; } ?><span>-</span><span><a href="../../connexion/deconnexion.php">Déconnexion()</a></span></p></div></div>
    </div>
</div>

<div id="fondblanc">
	
	<div id="subwrapper">