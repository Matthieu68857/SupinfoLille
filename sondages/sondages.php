<?php

	require_once("../inclusions/layout/haut.php");
	
	global $BDD;
	
	$student = new Student($_SESSION['user']['idbooster']);
	
	$lastsondage = $BDD->select(
		"*",
		"TB_SONDAGES",
		"ORDER BY sondage_id DESC"
	);
	
	$dfin = explode("-", $lastsondage[0]->sondage_date_fin);
	$datefin = mktime(0,0,0,$dfin[1],$dfin[2],$dfin[0]);
	
	if ($datefin >= time()) {
	
		$sondageopt = $BDD->select(
			"*",
			"TB_SONDAGES_CHOIX",
			"WHERE sondage_id = ?",
			array($lastsondage[0]->sondage_id)
		);
		
		$total = 0;
		for ($i=0; $i < count($sondageopt); $i++) {
			 $total = $total + $sondageopt[$i]->sondage_choix_votes;
       	}
       	  
	 }
	 
	$voteid = $BDD->select(
		"student_sondage_reponses",
		"TB_STUDENTS",
		"WHERE student_idbooster = ?",
		array($_SESSION['user']['idbooster'])
	);
	
	$compteur = $BDD->select(
		"student_sondage_reponses",
		"TB_STUDENTS",
		"WHERE student_sondage_reponses != 0"
	);
		
	$count = count($compteur);
	
	// ************************** Données des sondages **************************
	
	
	$sondageopt1 = $BDD->select(
		"*",
		"TB_SONDAGES_CHOIX",
		"WHERE sondage_id = ?",
		array($lastsondage[1]->sondage_id)
	);
	
	for ($i=0; $i < count($sondageopt1); $i++) {	
		 $total1 = $total1 + $sondageopt1[$i]->sondage_choix_votes;
	}
	
	$sondageopt2 = $BDD->select(
		"*",
		"TB_SONDAGES_CHOIX",
		"WHERE sondage_id = ?",
		array($lastsondage[2]->sondage_id)
	);

	for ($i=0; $i < count($sondageopt2); $i++) {
		$total2 = $total2 + $sondageopt2[$i]->sondage_choix_votes;
	}   
	
	$data = "[";

	if ($datefin >= time()) { 
		for ($i=0; $i < count($sondageopt); $i++) { 
			$result = round(($sondageopt[$i]->sondage_choix_votes / $total)*100);
			$data .= "['".$sondageopt[$i]->sondage_choix."',".$result."],";
	 	} 
	}
	
	$data .= "]"; 
	
	$data1 = "[";
	
	for ($i=0; $i < count($sondageopt1); $i++) { 
		$result1 = round(($sondageopt1[$i]->sondage_choix_votes / $total1)*100);
		$data1 .= "['".$sondageopt1[$i]->sondage_choix."',".$result1."],";
	}
	
	$data1 .= "]"; 
	
	$data2 = "[";
	
	for ($i=0; $i < count($sondageopt2); $i++) { 
		$result2 = round(($sondageopt2[$i]->sondage_choix_votes / $total2)*100);
		$data2 .= "['".$sondageopt2[$i]->sondage_choix."',".$result2."],";
	}
	
	$data2 .= "]"; 
	
?>

<script type="text/javascript" src="../inclusions/javascript/highcharts/highcharts.js"></script>
<script type="text/javascript" src="../inclusions/javascript/highcharts/modules/exporting.js"></script>
<script type="text/javascript">
		
$(document).ready(function() {
 			
	jQuery("#container").hide();
	jQuery("#container2").hide();
	jQuery("#bouton-vote").hide();
			
	<?php if ($voteid[0]->student_sondage_reponses != "0") { ?>
		jQuery("#container").show();
		jQuery("#container2").show();
		jQuery("#bouton-vote").show();
		jQuery("#poll-container").hide();
	<?php } ?>
				
	jQuery("#bouton-vote").click(function() { 
		jQuery.ajax({ type: "GET", 
			url: "sondagesAjax.php?action=changevote",
    		success:function(retour){
				jQuery("#bouton-vote").fadeOut(500);
				jQuery("#container2").hide();
				jQuery("#container").fadeOut(500, function() { $("#poll-container").fadeIn(500);});
			}	
		});
	});


	printChart(
		'container', 
		'<?php echo $lastsondage[0]->sondage_question; ?>',
		'<?php echo $lastsondage[0]->sondage_question; ?>',  
		20, 50, 30, -60, 
		'auto', 'auto', '0px', '100px', 
		<?php echo $data ?>,
		true,
		true,
		true
	);

	printChart(
		'lastsondage1', 
		'',
		'<?php echo $lastsondage[1]->sondage_question; ?>',  
		5, 5, 5, 5, 
		'auto', 'auto', '5px', '30px', 
		<?php echo $data1 ?>,
		false,
		false,
		false
	);

	printChart(
		'lastsondage2', 
		'',
		'<?php echo $lastsondage[2]->sondage_question; ?>',  
		5, 5, 5, 5, 
		'auto', 'auto', '5px', '30px', 
		<?php echo $data2 ?>,
		false,
		false
	);

});
				
</script>
		
	<div id="wrapper_sondage">
	
        <div id="lastsondage">
        <h1>Derniers sondages : </h1>
        <div class="lastsondage"><p style="color:white; text-align:center; font-weight:bold; padding:5px; font-size:11px; padding-bottom:0;"><?php echo $lastsondage[1]->sondage_question; ?></p>
        <div id="lastsondage1" style="width:80%; height:70%; margin-left:10%;"></div></div>
        <div class="lastsondage"><p style="color:white; text-align:center; font-weight:bold; padding:5px; font-size:11px; padding-bottom:0;"><?php echo $lastsondage[2]->sondage_question; ?></p>
        <div id="lastsondage2" style="width:80%; height:70%; margin-left:10%;"></div></div>
        </div>
    
        <div id="newsondage">
        <h1>Sondage actif : </h1>
    			
				<div id="container" style="width: 550px; height: 380px; margin: 0 auto"> </div>
                <div id="container2" style="width: 550px; text-align:center;"><?php /*?><?php echo $count . " votants !"; ?><?php */?></div>
                
                <div id="bouton-vote" style=" border:1px solid black; text-align:center; cursor:pointer;-moz-border-radius:10px;-webkit-border-radius:10px;">Changer mon vote</div>
                                
              <?php		  
			   if ($datefin >= time()) { ?>
                
                <div id="poll-container">
               
                    <h3><?php echo $lastsondage[0]->sondage_question; ?></h3>
                    <form id='poll' action="sondagesAjax.php" method="post" accept-charset="utf-8">
                     <?php if ($lastsondage[0]->sondage_type == "simple") { ?>
                       <?php   for ($i=0; $i < count($sondageopt); $i++) { ?>                
                        <p><input type="radio" name="opt[0]" value="<?php echo $sondageopt[$i]->sondage_choix_id; ?>" id="opt<?php echo $i ?>" class="optpoll" /><label for='opt<?php echo $i ?>'><?php echo $sondageopt[$i]->sondage_choix; ?></label><br />
                        <?php } } else { for ($i=0; $i < count($sondageopt); $i++) { ?>
                         <p><input type="checkbox" name="opt[<?php echo $i ?>]" value="<?php echo $sondageopt[$i]->sondage_choix_id; ?>" id="opt[<?php echo $i ?>]" class="optpoll" /><label for='opt[<?php echo $i ?>]'><?php echo $sondageopt[$i]->sondage_choix; ?></label><br />
                         <?php } } ?>
                        <input type="submit" value="Voter !" class="submit" /> </p>
                    </form>
                    <div style="clear:both;"></div>
				</div>
             <?php } else { echo "Aucun sondage pour l'instant ;)"; } ?>   
             
        </div>
        <div style="clear:both"></div>
        
	</div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>

