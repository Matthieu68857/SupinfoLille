<?php
	
	require_once('../inclusions/initialisation.php');
	
	$path = explode('/', $_SERVER['PHP_SELF']);
	$categorie = $path[count($path) - 2];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Portail du Campus SUPINFO Lille</title>
	<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
	
	<!-- Inclusions CSS Jquery + Plugins -->
	<link rel="stylesheet" type="text/css" href="../inclusions/css/jquery-ui/jquery-ui-1.8.5.custom.css" />
	<link type="text/css" rel="stylesheet" href="../inclusions/javascript/chat/chat.css" />
	<link type="text/css" rel="stylesheet" href="../inclusions/javascript/uploadify/uploadify.css"/>
	
	<!-- Inclusions CSS -->
	<link rel="stylesheet" type="text/css" href="../inclusions/css/main.css" />
	<link rel="stylesheet" type="text/css" href="../inclusions/css/cafeteria.css" />
	<link rel="stylesheet" type="text/css" href="../inclusions/css/documents.css" />
	<link rel="stylesheet" type="text/css" href="../inclusions/css/entraide.css" />
	<link rel="stylesheet" type="text/css" href="../inclusions/css/etudiants.css" />
	<link rel="stylesheet" type="text/css" href="../inclusions/css/evenements.css" />
	<link rel="stylesheet" type="text/css" href="../inclusions/css/moncompte.css" />
	<link rel="stylesheet" type="text/css" href="../inclusions/css/projets.css" />
	<link rel="stylesheet" type="text/css" href="../inclusions/css/sondages.css" />
	<?php if($categorie == "sbn"){ ?>
	<link rel="stylesheet" type="text/css" href="../inclusions/css/sbn.css" />
	<?php } ?>
	
	<!-- Inclusions JS jQuery + Plugins -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/jquery-ui-1.8.5.custom.min.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/chat/chat.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/uploadify/jquery.uploadify.v2.1.2.js"></script>
   	<script type="text/javascript" src="../inclusions/javascript/purr/jquery.purr.js"></script>
   	<script type="text/javascript" src="../inclusions/javascript/qtip.js"></script>
   	
   	<!-- Inclusions JS -->
	<script type="text/javascript" src="../inclusions/javascript/main.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/cafeteria.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/documents.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/entraide.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/etudiants.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/evenements.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/moncompte.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/projets.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/sondages.js"></script>
	<?php if($categorie == "sbn"){ ?>
	<script type="text/javascript" src="../inclusions/javascript/sbn.js"></script>
	<?php } ?>
   
</head>

<body>

<div id="wrapper">

	<div id="logo" onclick="location.href='../accueil/index.php'"></div>
	<div id="menu"><div id="encartmenu">
	
    <div id="photo-haut"><?php echo '<a href="../moncompte/moncompte.php"><img src="http://www.campus-booster.net/actorpictures/' . $_SESSION['user']['idbooster'] . '.jpg" style="height:60px;-moz-border-radius:10px; -webkit-border-radius:10px; border:3px solid white;"/></a>'; ?></div> 
    
    <div id="textmenu"><p><a href="../moncompte/moncompte.php">Mon compte</a><?php if ($_SESSION['user']['status'] == 2) { echo "<span>-</span><span><a href='../administration'>Administration</a></span>"; } ?><span>-</span><span><a href="../connexion/deconnexion.php">Déconnexion</a></span></p></div></div>
    </div>

</div>

<div id="fondblanc">
	
	<div id="subwrapper">
