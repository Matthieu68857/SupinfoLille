<?php

	require_once('../inclusions/layout/haut.php');

	$thematiques = getThematiques();
	
	if(!in_array($_SESSION['admin_thematique'], $thematiques)){
		$_SESSION['admin_thematique'] = "";
	}

	if(isset($_SESSION['nom']) && isset($_SESSION['ville']) && isset($_SESSION['thematique'])){
		$nombreEntreprises = getNombreEntreprises(0, $_SESSION['nom'], "", "", $_SESSION['ville'], "", $_SESSION['thematique'], "");
	} else {
		$nombreEntreprises = getNombreEntreprises();
	}

	if(isset($_GET['page']) && !empty($_GET['page']) && preg_match("#^[0-9]*$#", $_GET['page'])){
		if(($_GET['page'] * 30) > $nombreEntreprises && ($_GET['page'] * 30 - $nombreEntreprises) > 30){
			$page = ceil($nombreEntreprises / 30);
		} else {
			$page = $_GET['page'];
		}
	} else {
		$page = 1;
	}
	
	if(isset($_SESSION['nom']) && isset($_SESSION['ville']) && isset($_SESSION['thematique'])){
		$entreprises = getEntreprises((($page - 1) * 30), 30, 0, $_SESSION['nom'], "", "", $_SESSION['ville'], "", $_SESSION['thematique'], "");
	} else {
		$entreprises = getEntreprises((($page - 1) * 30), 30);
	}
	
	$thematique = '<select class="rechercheSelect" id="rechercheThematique">';
	$thematique .= '<option '.( !isset($_SESSION['thematique']) ? ' selected="selected"' : '').' value="">Choisir une thematique</option>';
	foreach($thematiques as $t){
		$thematique .= '<option value="'.$t->entreprise_thematique.'"'.( isset($_SESSION['thematique']) && $_SESSION['thematique'] == $t->entreprise_thematique ? ' selected="selected"' : '').'>'.$t->entreprise_thematique.'</option>';
	}
	$thematique .= '</select>';
?>

<div id="sbn">
	<div id="menuSBN">
		<div class="separateur"></div>
		<div class="choix" title="Stages"><a href="stages.php">Stages</a></div>
		<div class="separateur"></div>
		<div class="choix selected" title="Entreprises"><a href="entreprises.php">Entreprises</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Liens utiles"><a href="liens.php">Liens utiles</a></div>
		<div class="separateur"></div>
	</div>
	<div id="contenuSBN">
		<div id="recherche">
			<input type="hidden" class="recherche" id="recherchePage" value="<?php echo $page; ?>" />
			<table class="tableau">
				<tr>
					<th colspan="4">Recherche</th>
				</tr>
				<tr>
					<td>Nom : <input type="text" class="recherche" id="rechercheNom"<?php echo ( isset($_SESSION['nom']) ? ' value="'.$_SESSION['nom'].'"' : '') ?> /></td>
					<td>Ville : <input type="text" class="recherche" id="rechercheVille"<?php echo ( isset($_SESSION['ville']) ? ' value="'.$_SESSION['ville'].'"' : '') ?> /></td>
					<td>Th&eacute;matique : <?php echo $thematique; ?></td>
					<td><div id="loader"><img src="../images/ajax-loader-sbn.gif" alt="loader" /></div></td>
				</tr>
			</table>
		</div>
		<hr />
		<div id="entreprises">
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
					<td>
						<a href="<?php echo getDetailLink("entreprise", $e->getId(), false); ?>">
							<img src="../images/plus.png" title="Plus d'informations"/>
						</a>
					</td>
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
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<?php require_once('../inclusions/layout/bas.php'); ?>