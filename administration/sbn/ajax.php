<?php

	require_once('../inclusions/initialisation.php');

	if(isset($_POST['nom']) && isset($_POST['ville']) && isset($_POST['thematique']) && isset($_POST['id'])){
		if($_POST['id'] == ""){
			$_POST['id'] = 0;
		}
		$_SESSION['admin_id'] = htmlentities($_POST['id']);
		$_SESSION['admin_nom'] = htmlentities($_POST['nom']);
		$_SESSION['admin_ville'] = htmlentities($_POST['ville']);
		$_SESSION['admin_thematique'] = htmlentities($_POST['thematique']);
		$entreprises = getEntreprises(0, 30, $_SESSION['admin_id'], $_SESSION['admin_nom'], "", "", $_SESSION['admin_ville'], "", $_SESSION['admin_thematique'], "");
		$nombreEntreprises = getNombreEntreprises($_SESSION['admin_id'], $_SESSION['admin_nom'], "", "", $_SESSION['admin_ville'], "", $_SESSION['admin_thematique'], "");
		$page = 1;
?>
		<table class="tableau">
		<tr>
			<th>Id</th>
			<th>Nom</th>
			<th>Ville</th>
			<th>Thematique</th>
			<th>Nombre de stages</th>
			<th>Modifier</th>
		</tr>
		<?php
			foreach($entreprises as $e){
		?>
		<tr>
			<td><?php echo $e->getId(); ?></td>
			<td><?php echo $e->getNom(); ?></td>
			<td><?php echo $e->getVille(); ?></td>
			<td><?php echo $e->getThematique(); ?></td>
			<td><?php echo count($e->getStages()); ?></td>
			<td><?php echo getModifLink($e->getId()); ?></td>
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
    		<a href="index.php?page=1">Premi&egrave;re page</a>
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
						 <a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a> 
					<?php
					}
				}
			}
			if(($page + 4) < $nombrePages){
			?>
				... <a href="index.php?page=<?php echo $nombrePages; ?>">Derni&egrave;re page</a>
			<?php } ?>
		</p>
	<?php } ?>
<?php } ?>