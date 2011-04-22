<?php
	require_once('../inclusions/layout/haut.php');

	$nombreStages = getNombreStages();

	if(isset($_GET['page']) && !empty($_GET['page']) && preg_match("#^[0-9]*$#", $_GET['page'])){
		if(($_GET['page'] * 30) > $nombreStages && ($_GET['page'] * 30 - $nombreStages) > 30){
			$page = ceil($nombreStages / 30);
		} else {
			$page = $_GET['page'];
		}
	} else {
		$page = 1;
	}
	$stages = getStages((($page -1) * 30));
	
?>

<div id="sbn">

	<div id="menuSBN">
		<div class="separateur"></div>
		<div class="choix selected" title="Stages"><a href="stages.php">Stages</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Entreprises"><a href="entreprises.php">Entreprises</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Liens utiles"><a href="liens.php">Liens utiles</a></div>
		<div class="separateur"></div>
	</div>
	
	<div id="contenuSBN">
	
		<div id="stages">
			<table class="tableau">
				<tr>
					<th class="thDate">Date</th>
					<th class="thDesc">Description</th>
					<th class="thPlus"></th>
				</tr>
				<?php
					foreach($stages as $s){
				?>
				<tr>
					<td><?php echo convertToDisplayDate($s->getTheDate()); ?></td>
					<td><?php echo makeReturn(limit($s->getDescription(), 150)); ?></td>
					<td>
						<a href="<?php echo getDetailLink("stage", $s->getId(), false); ?>" class="lien">
							<img src="../images/plus.png" title="Plus d'informations"/>
						</a>
						<?php if($s->getFichier() != ""){ ?>
						<a href="telecharger.php?stage=<?php echo $s->getId(); ?>">
							<img src="../images/telecharger.png" title="Télécharger le fichier"/>
						</a>
						<?php } ?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>
		
		<br/>
		
		<?php

		if($nombreStages > 1){
			$nombrePages = ceil($nombreStages / 30);
		?>
	
		<p class="pages">
		<?php
	    	if(($page - 5) > 0){
	    ?>
	    	<a href="stages.php?page=1">Premi&egrave;re page</a>
	    <?php
	    	}
			for($i = 1; $i <= $nombrePages; $i++){
				if($i == $page){
				?>
					<span class="pageActuelle"><?php echo $i; ?></span> 
				<?php
				} else {
					if(($i > ($page - 5)) && ($i < ($page + 5))){
					?>
						<a href="stages.php?page=<?php echo $i; ?>"><?php echo $i; ?></a> 
					<?php
					}
				}
			}
			if(($page + 4) < $nombrePages){
			?>
				... <a href="stages.php?page=<?php echo $nombrePages; ?>">Derni&egrave;re page</a>
			<?php } ?>
		</p>
		
		<?php 
	
		}  
		
		?>
	
	</div>
	
	<div style="clear:both;"></div>

</div>

<?php

	require_once('../inclusions/layout/bas.php'); 
	
?>