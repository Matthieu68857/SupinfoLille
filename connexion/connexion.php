<?php

	session_start();

	require_once("../inclusions/configuration.php");
	require_once("../inclusions/auto_chargement_classes.php");
	
	$BDD = new BDD();
	
	require_once("../inclusions/fonctions/main.php");
	
	$fail = false;
	
	if(isset($_SESSION['user']['idbooster']) && isset($_SESSION['user']['pass']) && isset($_SESSION['user']['nom']) 
		&& isset($_SESSION['user']['prenom']) && isset($_SESSION['user']['status'])){
		if(checkUserLogin($_SESSION['user']['idbooster'], $_SESSION['user']['pass'],true))
		{
			header('location: ../accueil/index.php');
		}
	}
	
	if(isset($_COOKIE['nom']) || isset($_COOKIE['prenom']) || isset($_COOKIE['status'])){
		header('location: ../connexion/deconnexion.php');
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Portail SUPINFO Lille</title>
	<link rel="stylesheet" type="text/css" href="../inclusions/css/jquery-ui/jquery-ui-1.8.5.custom.css" />
	<link rel="stylesheet" type="text/css" href="../inclusions/css/main.css" />
	<link type="text/css" rel="stylesheet" href="../inclusions/javascript/chat/chat.css" />
	<link type="text/css" rel="stylesheet" href="../inclusions/javascript/uploadify/uploadify.css"/>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/jquery-ui-1.8.5.custom.min.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/chat/chat.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/uploadify/jquery.uploadify.v2.1.2.js"></script>
	<script type="text/javascript" src="../inclusions/javascript/main.js"></script>
    <script type="text/javascript">
		
	jQuery(document).ready(function() {	
		
		jQuery("#drop").click(function(){
			jQuery("#vid").slideToggle("slow");
		});
		
	});
	
	</script>
    <style> 
    body { 
    	background:url(../images/bg.jpg) repeat-x #1e2126; 
    }
    
    #vid
    {
    	display: none;
    }
    </style>
</head>

<body>

<div id="wrapper">

	<div id="logo"></div>
	<div id="menu"></div>

</div>

<div id="top_connexion" style="clear:both;">
</div>

<div id="connexion">
	<form action="../inclusions/OpenID/connexion.php" method="post">
		<?php
			if($fail){
				echo '<p id="echec_connexion">Échec de la connexion, veuillez réessayer.</p>';
			}
		?>
		<fieldset>
			<legend>Connexion<?php echo (isset($_COOKIE['sbn']) ? ' SBN' : ''); ?></legend>
			<div>
				<input type="text" name="idbooster" value="ID Booster"/>
				<br /><br />
				<span title="Cela permet d'avoir un accès complet au site. En refusant vous aurez juste accès au chat et à la partie recherche de stages.">
					Enregistrer mes informations : <input type="checkbox" name="save" checked="checked" />
				</span>
				<br/>
				<input type="submit" value="Connexion"/>
			</div>
		</fieldset>
	</form>
    
    <div id="video">
    <p style="text-align:center; color:white; cursor:pointer; font-size:12px;" id="drop">Voir la vidéo de présentation de SupinfoLille ▼</p>
	
	<div id="vid"><object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,115,0' width='560' height='345'><param name='movie' value='http://screenr.com/Content/assets/screenr_1116090935.swf' /><param name='flashvars' value='i=132004' /><param name='allowFullScreen' value='true' /><embed src='http://screenr.com/Content/assets/screenr_1116090935.swf' flashvars='i=132004' allowFullScreen='true' width='560' height='345' pluginspage='http://www.macromedia.com/go/getflashplayer'></embed></object>
	</div>

	</div>
    
</div>

</body>
</html>