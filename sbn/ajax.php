<?php

	require_once('../inclusions/initialisation.php');

	if(isset($_POST['nom']) && isset($_POST['ville']) && isset($_POST['thematique'])){
		$_SESSION['nom'] = htmlentities($_POST['nom']);
		$_SESSION['ville'] = htmlentities($_POST['ville']);
		$_SESSION['thematique'] = htmlentities($_POST['thematique']);
		$entreprises = getEntreprises(0, 30, 0, $_SESSION['nom'], "", "", $_SESSION['ville'], "", $_SESSION['thematique'], "");
		$nombreEntreprises = getNombreEntreprises(0, $_SESSION['nom'], "", "", $_SESSION['ville'], "", $_SESSION['thematique'], "");
		$page = 1;
?>
		<table class="tableau">
		<tr>
			<th>Nom</th>
			<th>Ville</th>
			<th>Thematique</th>
			<th>Nombre de stages</th>
			<th>D&eacute;tail</th>
		</tr>
		<?php
			foreach($entreprises as $e){
		?>
		<tr>
			<td><?php echo $e->getNom(); ?></td>
			<td><?php echo $e->getVille(); ?></td>
			<td><?php echo $e->getThematique(); ?></td>
			<td><?php echo count($e->getStages()); ?></td>
			<td><?php echo getDetailLink("entreprise", $e->getId()); ?></td>
		</tr>
		<?php } ?>
	</table>
	<?php
		if($nombreEntreprises > 1){
			$nombrePages = ceil($nombreEntreprises / 30);
	?>
		<p class="pages">
		<?php
    		if(($page - 5) > 0){
    	?>
    		<a href="entreprises.php?page=1">Premi&egrave;re page</a>
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
						 <a href="entreprises.php?page=<?php echo $i; ?>"><?php echo $i; ?></a> 
					<?php
					}
				}
			}
			if(($page + 4) < $nombrePages){
			?>
				... <a href="entreprises.php?page=<?php echo $nombrePages; ?>">Derni&egrave;re page</a>
			<?php } ?>
		</p>
	<?php } ?>
<?php } ?>