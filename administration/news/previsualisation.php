<?php

	require_once("../inclusions/layout/haut.php");
		
	$news = $BDD->select(
		"*",
		"TB_NEWS",
		"LIMIT 0,1"
	);

?>
 		
 	<div id="contenu">

 		<h1><?php echo $_POST[titre] ?></h1>
    
    	
    	<?php echo $_POST[contenu] ?>

		<p class="finnews">De : <strong><?php echo $news[0]->news_auteur; ?></strong> - Posté le : <strong><?php echo $news[0]->news_date; ?></strong></p>
      
      
      <form action="news.php?action=ajouter<?php if (isset($_POST[id])) { echo '&id=' .$_POST[id]; } ?>&visu=1" method="post">
           <input name="titre" type="hidden"  value="<?php echo stripslashes($_POST[titre]); ?>" />
           <?php if(TWI_CONSUMER_KEY != "0" && TWI_CONSUMER_SECRET != "0" && !isset($_POST[id])){ ?>
				<label for="publierSurTwitter">Publier sur Twitter : </label>
				<input type="checkbox" id="publierSurTwitter" name="publierSurTwitter" checked="checked"/>
				<br /><br />
		   <?php } ?>
           <textarea name="contenu" style="display:none;"><?php echo stripslashes($_POST[contenu]); ?></textarea>
   		 <input type="submit" value="<?php if (isset($_POST[id])) { echo 'Mettre à jour la News'; } else { ?>Ajouter la news<?php } ?>" style="width:47%; background:#333; color:white; font-weight:bold; -moz-border-radius:10px; -webkit-border-radius:10px; border:2px solid #666; cursor:pointer; float:left; text-align:center;"  />
      </form>
      
      <form action="news.php?action=modifier<?php if (isset($_POST[id])) { echo '&id=' .$_POST[id]; } ?>&visu=1" method="post">
           <input name="titre" type="hidden"  value="<?php echo stripslashes($_POST[titre]); ?>" />
           <textarea  name="contenu" style="display:none;"><?php echo stripslashes($_POST[contenu]); ?></textarea>
   		 <input type="submit" value="Modifier la news" style="width:47%; background:#333; color:white; font-weight:bold; -moz-border-radius:10px; -webkit-border-radius:10px; border:2px solid #666; cursor:pointer; float:left; text-align:center; margin-left:2%;"  />
      </form>
    
    </div>    
    
    <div class="encart" id="compte"><div class="encart" id="compte2"></div></div>
    <div class="encart" id="document">   <div class="encart" id="document2"></div></div>
    <div class="encart" id="etudiant"><div class="encart" id="etudiant2"></div></div><div style="clear:left"></div>
    <div class="encart" id="event"><div class="encart" id="event2"></div></div>
    <div class="encart" id="sondage"><div class="encart" id="sondage2"></div></div>
    <div class="encart" id="entraide"><div class="encart" id="entraide2"></div></div>
    <div style="clear:both"></div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>

