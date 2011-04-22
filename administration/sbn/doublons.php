<?php

	require_once('../inclusions/layout/haut.php');

	if(isset($_POST['id']) && !empty($_POST['id'])){
		supprimerDoublon($_POST['id']);
	}

	$nombreDoublons = getNombreDoublons();

	if(isset($_GET['page']) && !empty($_GET['page']) && preg_match("#^[0-9]*$#", $_GET['page'])){
		if(($_GET['page'] * 30) > $nombreDoublons && ($_GET['page'] * 30 - $nombreDoublons) > 30){
			$page = ceil($nombreDoublons / 30);
		} else {
			$page = $_GET['page'];
		}
	} else {
		$page = 1;
	}

	$entreprises = $entreprises = getEntreprisesDoublons((($page - 1) * 30), 30);
	
?>
<div id="sbn">
	<div id="menuSBN">
		<div class="separateur"></div>
		<div class="choix" title="Entreprises"><a href="index.php">Entreprises</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Importer des entreprises et contacts avec un fichier .csv"><a href="gerer.php?action=import">Importer</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Exporter les <?php echo getNombreEntreprises(); ?> entreprises et les <?php echo getNombreContacts(); ?> contacts dans un fichier .csv"><a href="gerer.php?action=export">Exporter</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Afficher les <?php echo getNombreEntreprises(); ?> entreprises et les <?php echo getNombreContacts(); ?> contacts dans un même tableau"><a href="base.php">Afficher toutes les données</a></div>
		<div class="separateur"></div>
		<div class="choix selected" title="Afficher les <?php echo getNombreDoublons(); ?> doublon(s)"><a href="doublons.php">Afficher les doublons</a></div>
		<div class="separateur"></div>
	</div>
	<div id="contenuSBN">
		<table class="tableau">
			<tr>
				<th>Supprimer doublons</th>
				<th>Nom</th>
				<th>Adresse</th>
				<th>Ville</th>
				<th>Site</th>
				<th>Modifier</th>
			</tr>
			<?php
				foreach($entreprises as $e){
			?>
			<tr>
				<td>
					<form action="doublons.php" method="post" class="supprimerDoublonForm">
						<input type="hidden" name="id" value="<?php echo $e->getId(); ?>" />
						<img src="../images/supprimer.png" alt="supprimer" class="supprimerDoublon" title="Supprimer des doublons" />
					</form>
				</td>
				<td><?php echo $e->getNom(); ?></td>
				<td><?php echo $e->getAdresse(); ?></td>
				<td><?php echo $e->getVille(); ?></td>
				<td><?php echo couper($e->getSite(), 35); ?></td>
				<td><?php echo getModifLink($e->getId()); ?></td>
			</tr>
			<?php } ?>
		</table>
<?php
	if($nombreDoublons > 1){
			$nombrePages = ceil($nombreDoublons / 30);
	?>
		<p class="pages">
		<?php
    		if(($page - 5) > 0){
    	?>
    		<a href="doublons.php?page=1">Premi&egrave;re page</a>
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
						 <a href="doublons.php?page=<?php echo $i; ?>"><?php echo $i; ?></a> 
					<?php
					}
				}
			}
			if(($page + 4) < $nombrePages){
			?>
				... <a href="doublons.php?page=<?php echo $nombrePages; ?>">Derni&egrave;re page</a>
			<?php } ?>
		</p>
	<?php }
	
?>
	</div>
	<div style="clear:both;"></div>
</div>
<?php require_once('../inclusions/layout/bas.php'); ?>