<?php
	
	require_once('../inclusions/initialisation.php');

	global $BDD;

	// Ajout d'un Sondage -> et ses options
	if ($_GET[action] == "ajouter" && isset($_POST[question]) && !isset($_GET[id])) {
	
	$BDD->insert(
 		"TB_SONDAGES",
 		array("sondage_question", "sondage_date_debut", "sondage_date_fin", "sondage_type"),
 		array("?","CURDATE()","?","?"),
 		array(stripslashes($_POST[question]), $_POST[datefin], $_POST[type])
 	); 

	$sondageid = $BDD->select(
		"sondage_id",
		"TB_SONDAGES",
		"ORDER BY sondage_id DESC LIMIT 0,1"
	);
	
	$BDD->update(
 		"TB_STUDENTS",
 		array("student_sondage_reponses = 0"),
 		"1 = 1"
 	);
	
	for ($i=0; $i < count($_POST[opt]); $i++) {
		$BDD->insert(
 		"TB_SONDAGES_CHOIX",
 		array("sondage_choix", "sondage_id"),
 		array("?","?"),
 		array(stripslashes($_POST[opt][$i]), $sondageid[0]->sondage_id)
 	); 
	}
	if(isset($_POST['publierSurTwitter'])){
		publierSurTwitter(
			'Nouveau sondage : ' . $_POST[question], 
			'/sondages.php', 
			'/administration/sondages.php?action=ok'
		);
	} else {
		require_once("../inclusions/layout/haut.php");
		echo "<p style='color: green; font-weight:bold; text-align:center; padding-top:8px;'>Ajout terminé !</p>";
	}
	}
	
	require_once("../inclusions/layout/haut.php");
	
	if($_GET[action] == "ok"){
		echo "<p style='color: green; font-weight:bold; text-align:center; padding-top:8px;'>Ajout terminé !</p>";
	}
	
	// Modification d'un Sondage
	if (isset($_GET[id]) && $_GET[action] == "ajouter") {
		
		
		$sondageid = $BDD->select(
		"sondage_id",
		"TB_SONDAGES_CHOIX",
		"WHERE sondage_id = ?",
		array($_GET[id])
		);
		
		$modifopt = $BDD->select(
			"*",
			"TB_SONDAGES_CHOIX",
			"WHERE sondage_id = ? ORDER BY sondage_choix_id",
			array($_GET[id]) 
		);
		
		$BDD->update(
		"TB_SONDAGES",
		array("sondage_question = ?", "sondage_type = ?", "sondage_date_fin = ?"),
		"sondage_id = $_GET[id]",
		array(stripslashes($_POST[question]), stripslashes($_POST[type]), stripslashes($_POST[datefin]))
		);
		
		
		for ($i=0; $i < count($_POST[opt]); $i++) {
			
			$idchoix = $modifopt[$i]->sondage_choix_id;
				if ($i < count($sondageid)) {
					
							$BDD->update(
							"TB_SONDAGES_CHOIX",
							array("sondage_choix = ?"),
							"sondage_choix_id = $idchoix",
							array(stripslashes($_POST[opt][$i])) ); 					
				}
				else {
						$BDD->insert(
						"TB_SONDAGES_CHOIX",
						array("sondage_choix", "sondage_id"),
						array("?","?"),
						array(stripslashes($_POST[opt][$i]), $sondageid[0]->sondage_id)
					); 
				}
			
		}
 	
		if (count($_POST[opt]) < count($sondageid)) {
				
				$suppr = $BDD->select(
				"*",
				"TB_SONDAGES_CHOIX",
				"WHERE sondage_id = ? ORDER BY sondage_choix_id DESC",
				array($_GET[id]) 
				); 
				
				for ($nbrsuppr = 0; $nbrsuppr < count($sondageid) - count($_POST[opt]); $nbrsuppr++) {

					$BDD->delete(
					"TB_SONDAGES_CHOIX",
					"sondage_choix_id = ?",
					array($suppr[$nbrsuppr]->sondage_choix_id)
					);
					 
				}
				
			}
			
		echo "<p style='color: green; font-weight:bold; text-align:center; padding-top:8px;'>Modification terminée !</p>";
	}
	
	//Delete Sondage
	if ($_GET[action] == "supprimer" && isset($_GET[id])) {
		
		$BDD->delete(
		"TB_SONDAGES",
		"sondage_id = ?",
		array($_GET[id])
		);
		
		$BDD->delete(
		"TB_SONDAGES_CHOIX",
		"sondage_id = ?",
		array($_GET[id])
		);
		echo "<p style='color: green; font-weight:bold; text-align:center; padding-top:8px;'>Suppression terminée !</p>";
	}
	
	
	// Gestion des pages et SELECTion des sondages
	if (isset($_GET[page])) { $debut = ($_GET[page]-1)*16;  } else { $debut = 0; }
	
	$news = $BDD->select(
		"*",
		"TB_SONDAGES",
		"ORDER BY sondage_id DESC LIMIT " .$debut. ",16 "
	);
	
	//Count nbr de pages
	$count = $BDD->select(
		"*",
		"TB_SONDAGES",
		"ORDER BY sondage_id DESC"
	);
	$nb_page = ceil(count($count)/16);
	
	//Reception du contenu modification
	if (isset($_GET[id]) && $_GET[action] == "modifier") {
		
		$modif = $BDD->select(
			"*",
			"TB_SONDAGES",
			"WHERE sondage_id = ?",
			array($_GET[id]) 
		);
		
		$modifopt = $BDD->select(
			"sondage_choix",
			"TB_SONDAGES_CHOIX",
			"WHERE sondage_id = ? ORDER BY sondage_choix_id",
			array($_GET[id]) 
		);
	}
?>

 		<div id="wrappercontenu">    	
        
        <div id="droite">
                    
                    <div id="news_ajouter" onclick="location.href='sondages.php'">Ajouter un sondage</div> 
                    
                    <h1><?php if (isset($_GET[action]) && $_GET[action] == "modifier") { echo "Modification du sondage " .$_GET[id]; }
                    else { echo "Gestion des Sondages - Ajout"; } ?></h1>
                    
                
                <form action="sondages.php?action=ajouter<?php if (isset($_GET[id]) && $_GET[action] == "modifier") { echo "&amp;id=" . $_GET[id]; } ?>" method="post" id="formsondage">
                    <p><label>Question  : </label><input name="question" type="text" value="<?php if (isset($_GET[id]) && $_GET[action] == "modifier") { echo $modif[0]->sondage_question; } ?>" /> <br /><br />
                    
                    <label>Choix : </label> <a href="#" class="plus"><img src="../images/plus.png" alt="plus"></a> <a href="#" class="moins"><img src="../images/moins.png" alt="moins" /></a><br />
                    <div id="options"><?php if (isset($_GET[id]) && $_GET[action] == "modifier") { for ($i=1; $i <= count($modifopt); $i++) { ?>
                    
                    <div>Choix <?php echo $i; ?> : <input name="opt[<?php echo $i-1; ?>]" type="text" value="<?php echo $modifopt[$i-1]->sondage_choix; ?>" class="nbroption" /><br /></div>
                    
                    <?php } } else { ?>
                    	
                        <div>Choix 1 : <input name="opt[0]" type="text" value="" class="nbroption" /><br /></div>
                    	<div>Choix 2 : <input name="opt[1]" type="text" value="" class="nbroption" /><br  id="opt2" /></div>
                        
                    <?php } ?>
                    </div>
                    <br />
                    <label>Type de sondage : </label> <input type="radio" name="type" value="simple" id="simple" <?php if (isset($_GET[id]) && $_GET[action] == "modifier" && $modif[0]->sondage_type == "simple") { echo 'checked="checked"'; } ?> /><label for='simple'>Simple</label> <input type="radio" name="type" value="multiple" id="multiple" <?php if (isset($_GET[id]) && $_GET[action] == "modifier" && $modif[0]->sondage_type == "multiple") { echo 'checked="checked"'; } ?> /><label for='simple'>Multiple</label><br />
                    <br />
                    <label>Date de cloture du sondage  : </label><input name="datefin" type="text" value="<?php if (isset($_GET[id]) && $_GET[action] == "modifier") { echo $modif[0]->sondage_date_fin; } ?>" id="datepicker" /> <br /> 
                    <?php if(TWI_CONSUMER_KEY != "0" && TWI_CONSUMER_SECRET != "0"){ ?>
                    <br />
					<label for="publierSurTwitter">Publier sur Twitter : </label>
					<input type="checkbox" id="publierSurTwitter" name="publierSurTwitter" checked="checked"/>
					<?php } ?>
                    <input type="hidden" name="nbroption" value="" />
                    </p>
                    <p>
                    
                        <input type="submit" value="Valider" style="width:100%; background:#333; color:white; font-weight:bold; -moz-border-radius:10px; -webkit-border-radius:10px; border:2px solid #666; cursor:pointer;" />
                    </p>
                </form>
                    
        </div>
        
        
            <div id="tableau">
                <table id="table_news">
                <tr>
                    <th style="width:20px">id</th>
                    <th style="width:300px">Question</th>
                    <th>Fin le :</th>
                    <th></th>
                    <th></th>
                </tr>
                
                <?php foreach($news as $new) { ?>
                <tr>
                    <td><?php echo $new->sondage_id; ?></td>
                    <td><?php echo $new->sondage_question; ?></td>
                    <td><?php echo $new->sondage_date_fin; ?></td>
                    <td><a href="sondages.php?id=<?php echo $new->sondage_id; ?>&amp;action=modifier" ><img src="../images/modifier.png" alt="Modifier" title="modifier" style="width:20px; height:20px;" /></a></td>
                    <td><a href="sondages.php?id=<?php echo $new->sondage_id; ?>&amp;action=supprimer" ><img src="../images/supprimer.png" alt="Supprimer" title="supprimer" style="width:20px; height:20px;" /></a></td>
                </tr>
                <?php } ?>
                
                </table>
                
                <?php 

				for ($i=1; $i <= $nb_page; $i++) { 
			 echo "<span style='background:white; padding:2px 4px 2px 4px; margin:3px; font-weight:bold;";
			
			 if($i == $_GET[page])
			 	{ echo "border:2px solid #A1C117;";}
			if (!isset($_GET[page])) { if($i==1){echo "border:2px solid #A1C117;";}}

				
			 
			 
			 echo "'><a style='color:#333;' href='news.php?page=" . $i . "'>". $i . "</a></span>"; 

			} ?>
            </div>
            
            <div style="clear:both"></div>
            
    	</div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>

