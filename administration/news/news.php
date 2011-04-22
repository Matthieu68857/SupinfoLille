<?php

	require_once('../inclusions/initialisation.php');
	
	$auteur = $_SESSION['user']['idbooster'];
		
	// Ajout d'une News
	if ($_GET[action] == "ajouter" && isset($_POST[titre]) && isset($_POST[contenu]) && !isset($_GET[id])) {
	
	$BDD->insert(
 		"TB_NEWS",
 		array("news_titre", "news_contenu", "news_auteur", "news_date"),
 		array("?","?","?","CURDATE()"),
 		array(stripslashes($_POST[titre]), stripslashes($_POST[contenu]), $auteur)
 	); 
 	
 	if(isset($_POST['publierSurTwitter'])){
		publierSurTwitter(
			'Nouvelle news : ' . $_POST[titre], 
			'/accueil/index.php', 
			'/administration/news/news.php'
		);
	}
	
	}
	
	require_once("../inclusions/layout/haut.php");
	
	// Modification d'une news
	if (isset($_GET[id]) && $_GET[action] == "ajouter" && $_GET[visu]) {
		
		$BDD->update(
		"TB_NEWS",
		array("news_titre = ?", "news_contenu = ?"),
		"news_id = $_GET[id]",
		array(stripslashes($_POST[titre]), stripslashes($_POST[contenu]))
		);
		
	}
	
	//Delete News
	if ($_GET[action] == "supprimer" && isset($_GET[id])) {
		
		$BDD->delete(
		"TB_NEWS",
		"news_id = ?",
		array($_GET[id])
		);
	}
	
	// Gestion des pages et SELECTion des news
	if (isset($_GET[page])) { $debut = ($_GET[page]-1)*16;  } else { $debut = 0; }
	
	$news = $BDD->select(
		"*",
		"TB_NEWS",
		"ORDER BY news_id DESC LIMIT " .$debut. ",16 "
	);
	
	//Count nbr de pages
	$count = $BDD->select(
		"*",
		"TB_NEWS",
		"ORDER BY news_id DESC"
	);
	$nb_page = ceil(count($count)/16);
	
	//Reception du contenu modification
	if (isset($_GET[id]) && $_GET[action] == "modifier" && !isset($_GET[visu])) {
		
		$modif = $BDD->select(
			"*",
			"TB_NEWS",
			"WHERE news_id = ?",
			array($_GET[id]) 
		);
	}
?>

 		<div id="wrappercontenu">    	
        
        <div id="droite">
                    
                    <div id="news_ajouter" onclick="location.href='news.php'">Ajouter une News</div> 
                    
                    <h1><?php if (isset($_GET[action]) && $_GET[action] == "modifier") { echo "Modification de la news " .$_GET[id]; }
                    else { echo "Gestion des News - Ajout"; } ?></h1>
                    
                
                <form action="previsualisation.php" method="post">
                    <p><label>Titre : </label><input name="titre" type="text" value="<?php if (isset($_GET[id]) && $_GET[action] == "modifier" && !isset($_GET[visu])) { echo $modif[0]->news_titre; }
					else if (isset($_GET[visu]) && $_GET[action] == "modifier") { echo stripslashes($_POST[titre]); } ?>" />
                    <p>
                        <textarea class="ckeditor" cols="80" id="editor1" name="contenu" rows="10">
                    <?php if (isset($_GET[id]) && $_GET[action] == "modifier" && !isset($_GET[visu])) { echo $modif[0]->news_contenu; }
					else if (isset($_GET[visu])&& $_GET[action] == "modifier") { echo stripslashes($_POST[contenu]); } else { ?>
                    &lt;p&gt;Entrez votre news ici...&lt;/p&gt;<?php } ?></textarea>
                    </p>
                    <p>
                    <?php if (isset($_GET[id]) && $_GET[action] == "modifier") { ?><input type="hidden" name="id" value="<?php echo $_GET[id];?>" /><?php } ?>
                        <input type="submit" value="Pré-visualiser la News" style="width:100%; background:#333; color:white; font-weight:bold; -moz-border-radius:10px; -webkit-border-radius:10px; border:2px solid #666; cursor:pointer;" />
                    </p>
                </form>
                    
        </div>
        
        
            <div id="tableau">
                <table id="table_news">
                <tr>
                    <th style="width:20px">id</th>
                    <th>Date</th>
                    <th style="width:300px">Titre</th>
                    <th></th>
                    <th></th>
                </tr>
                
                <?php foreach($news as $new) { ?>
                <tr>
                    <td><?php echo $new->news_id; ?></td>
                    <td><?php echo $new->news_date; ?></td>
                    <td><?php echo $new->news_titre; ?></td>
                    <td><a href="news.php?id=<?php echo $new->news_id; ?>&action=modifier" ><img src="../images/modifier.png" alt="Modifier" title="modifier" style="width:20px; height:20px;" /></a></td>
                    <td><a href="news.php?id=<?php echo $new->news_id; ?>&action=supprimer" ><img src="../images/supprimer.png" alt="Supprimer" title="supprimer" style="width:20px; height:20px;" /></a></td>
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

