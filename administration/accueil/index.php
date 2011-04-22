<?php
	
	require_once('../inclusions/initialisation.php');
	require_once("../inclusions/layout/haut.php");
	
	$i = 0;
?> 
	<div style="width:805px; margin:auto;">
	<?php if(in_array("etudiants", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="etudiants_admin" onclick="location.href='../etudiants/etudiants.php'"><div class="encart" id="etudiants_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
	<?php if(in_array("documents", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="documents_admin" onclick="location.href='../documents/documents.php'"><div class="encart" id="documents_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
	<?php if(in_array("stats", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="stats_admin" onclick="location.href='../stats/stats.php'"><div class="encart" id="stats_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
	<?php if(in_array("evenements", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="evenements_admin" onclick="location.href='../evenements/evenements.php'"><div class="encart" id="evenements_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
    	
	<?php if(in_array("sondages", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="sondage_admin" onclick="location.href='../sondages/sondages.php'"><div class="encart" id="sondage_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
	<?php if(in_array("news", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="news_admin" onclick="location.href='../news/news.php'"><div class="encart" id="news_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
	<?php if(in_array("entraide", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="entraide_admin" onclick="location.href='../entraide/entraide.php'"><div class="encart" id="entraide_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
	<?php if(in_array("cafeteria", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="cafet_admin" onclick="location.href='../cafeteria'"><div class="encart" id="cafet_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
	<?php if(in_array("droits", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="droits_admin" onclick="location.href='../droits'"><div class="encart" id="droits_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
	<?php if(in_array("sbn", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="sbn_admin" onclick="location.href='../sbn'"><div class="encart" id="sbn_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
	<?php if(in_array("sta", $_SESSION['categories_admin'])){ ?>
		<div class="encart" id="sta_admin" onclick="location.href='../sta'"><div class="encart" id="sta_admin2"></div></div>
	<?php
			$i++; 
		}
	?>
     
    	<div style="clear:both"></div>
    	
    </div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>

