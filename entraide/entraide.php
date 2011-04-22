<?php

	require_once("../inclusions/layout/haut.php");
	
?>

<br/>
	<div id="entraides">
    
    <?php 
	
	if ($_GET[action] == "new") { $success = AddQuestion(); }
	if ($_GET[action] == "newrep") { $successrep = AddReponse(); }
	if ($_GET[action] == "okrep" && isset($_GET[id])) { OkQuestion(); }

	if(isset($_GET['past'])){
		$entraides = getRepEntraides();
		echo '<h2><span class="inactif" onclick="location.href=\'entraide.php\'">Questions non répondues</span> <div>Questions répondues</div> </h2>';
	} else {
		$entraides = getNonRepEntraides();
		echo '<h2>Questions non répondues <div class="inactif" onclick="location.href=\'entraide.php?past=true\'">Questions répondues</div> </h2>';
	}

?> 
    </div>
    
        <div class="postquestion">
    	<form action="entraide.php?action=new" method="post" id="form_question">
        	<img src="../images/question.png" alt="question" /> <input type="text" value="Entrez votre Question ici..." name="question" />
            <div style="clear:both;"></div>
            <?php if(isset($success) && !$success) { echo '<p style="color:red;">Une erreur est survenue ! Veuillez réessayer !</p>'; } ?>
            
            <div class="details">
        	<textarea name="details"></textarea>
       		</div>
            
            <div class="submitquestion">Poster !</div>
            <div class="detailquestion">Ajouter des détails ▼</div>
            <div class="detailquestion" style="display:none;">Fermer ▲</div>
          
        </form> 
    </div>
    
    
    
<?php 	$design = 1;
		foreach($entraides as $entraide){
			$reponses = getReponses($entraide->entraide_id);
		if ($design == 1) {
			$design = 2;
	 ?>

    <div class="questiondesign1">
        <h2><?php echo utf8_encode($entraide->entraide_question); ?></h2>
        
        <div class="details">
        <p><?php echo utf8_encode($entraide->entraide_details); ?><br /><span style="float:right; font-size:10px; font-style:italic; font-weight:normal"><?php echo $entraide->entraide_date; ?> <span style="margin-left:20px;">Par : <?php echo $entraide->entraide_auteur; ?></span></span></p>
                
        <?php $drep = 1;
		foreach($reponses as $reponse){  ?>
        <div class="rep" <?php if ($drep == 1) {$drep = 2;} else if ($drep == 2) { echo 'style="float:right;"'; $drep = 1 ; } ?> >
        <h3><img src="../images/auteur.png" width="25" height="25" alt="auteur" /><?php echo utf8_encode($reponse->entraide_reponse_auteur); ?><span><?php echo $reponse->entraide_reponse_date; ?></span></h3>
        <p><?php echo utf8_encode($reponse->entraide_reponse); ?></p>
        </div>
        <?php } ?> 
        
		<div style="clear:both"></div>
        
        <form action="entraide.php?action=newrep" method="post" class="reponse1 reponse">
        <textarea name="reponse"></textarea>
        <input type="hidden" value="<?php echo $entraide->entraide_id; ?>" name="entraideid" />
        <div class="valid">Répondre</div>
        </form>

      </div>
      
        <?php $studentpn =  $_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom']; if ($entraide->entraide_auteur == $studentpn) { ?>
         <div class="auteur" onclick="location.href='entraide.php?action=okrep&id=<?php echo $entraide->entraide_id; ?>'">▼ J'ai eu ma réponse !</div>
        <?php } ?>
        
        <div class="detailquestion">Voir le détail et les réponses ▼</div>
        <div class="detailquestion" style="display:none;">Fermer ▲</div>
    </div><div style="clear:both"></div>
    <div class="quotedesign1"></div>
    <div style="clear:both"></div>
    
    <?php } else { $design = 1; ?>
    
    <div class="questiondesign2">
        <h2><?php echo utf8_encode($entraide->entraide_question); ?></h2>
        
        <div class="details">
        <p><?php echo utf8_encode($entraide->entraide_details); ?><br /><span style="float:right; font-size:10px; font-style:italic; font-weight:normal"><?php echo $entraide->entraide_date; ?><span style="margin-left:20px;">Par : <?php echo $entraide->entraide_auteur; ?></span></span></p>
        
        <?php foreach($reponses as $reponse){ ?>
        <div class="rep"  <?php if ($drep == 1) {$drep = 2;} else if ($drep == 2) { echo 'style="float:right;"'; $drep = 1 ; }?> >
        <h3><img src="../images/auteur.png" width="25" height="25" alt="auteur" /><?php echo utf8_encode($reponse->entraide_reponse_auteur); ?><span><?php echo $reponse->entraide_reponse_date; ?></span></h3>
        <p><?php echo utf8_encode($reponse->entraide_reponse); ?></p>
        </div>
        <?php } ?> 
        
        <div style="clear:both"></div>
        
		<form action="entraide.php?action=newrep" method="post" class="reponse2 reponse">
        <textarea name="reponse"></textarea>
        <input type="hidden" value="<?php echo $entraide->entraide_id; ?>" name="entraideid" />
        <div class="valid">Répondre</div>
        </form>
 
        
        </div>
        
       	<?php $studentpn =  $_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom']; if ($entraide->entraide_auteur == $studentpn) { ?>
         <div class="auteur" onclick="location.href='entraide.php?action=okrep&id=<?php echo $entraide->entraide_id; ?>'">▼ J'ai eu ma réponse !</div>
        <?php } ?>
        
        <div class="detailquestion">Voir le détail et les réponses ▼</div>
        <div class="detailquestion" style="display:none;">Fermer ▲</div>
    </div> <div style="clear:both"></div>
    <div class="quotedesign2"></div>
	
<?php		} } ?>
 		<p style="margin:0; padding-bottom:5px;"></p>
 		
<?php		
	require_once("../inclusions/layout/bas.php"); 

?>

