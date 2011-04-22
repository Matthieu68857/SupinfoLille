<?php

	require_once('../inclusions/layout/haut.php');
	
	$thematiques = getThematiques();
	
	if(!in_array($_SESSION['admin_thematique'], $thematiques)){
		$_SESSION['admin_thematique'] = "";
	}
	
	if(isset($_SESSION['admin_nom']) && isset($_SESSION['admin_ville']) && isset($_SESSION['admin_thematique']) && isset($_SESSION['admin_id'])){
		if($_SESSION['admin_id'] == ""){
			$_SESSION['admin_id'] = 0;
		}
		$nombreEntreprises = getNombreEntreprises($_SESSION['admin_id'], $_SESSION['admin_nom'], "", "", $_SESSION['admin_ville'], "", $_SESSION['admin_thematique'], "");
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
	
	if(isset($_SESSION['admin_nom']) && isset($_SESSION['admin_ville']) && isset($_SESSION['admin_thematique']) && isset($_SESSION['admin_id'])){
		if($_SESSION['admin_id'] == ""){
			$_SESSION['admin_id'] = 0;
		}
		$entreprises = getEntreprises((($page - 1) * 30), 30, $_SESSION['admin_id'], $_SESSION['admin_nom'], "", "", $_SESSION['admin_ville'], "", $_SESSION['admin_thematique'], "");
	} else {
		$entreprises = getEntreprises((($page - 1) * 30), 30);
	}
	
	$thematique = '<select class="rechercheAdminSelect" id="rechercheThematique">';
	$thematique .= '<option '.( !isset($_SESSION['admin_thematique']) ? ' selected="selected"' : '').' value="">Choisir une thematique</option>';
	foreach($thematiques as $t){
		$thematique .= '<option value="'.$t->entreprise_thematique.'"'.( isset($_SESSION['admin_thematique']) && $_SESSION['admin_thematique'] == $t->entreprise_thematique ? ' selected="selected"' : '').'>'.$t->entreprise_thematique.'</option>';
	}
	$thematique .= '</select>';
	
?>
<div id="sbn">
	<div id="menuSBN">
		<div class="separateur"></div>
		<div class="choix selected" title="Entreprises"><a href="index.php">Entreprises</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Importer des entreprises et contacts avec un fichier .csv"><a href="gerer.php?action=import">Importer</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Exporter les <?php echo getNombreEntreprises(); ?> entreprises et les <?php echo getNombreContacts(); ?> contacts dans un fichier .csv"><a href="gerer.php?action=export">Exporter</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Afficher les <?php echo getNombreEntreprises(); ?> entreprises et les <?php echo getNombreContacts(); ?> contacts dans un même tableau"><a href="base.php">Afficher toutes les données</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Afficher les <?php echo getNombreDoublons(); ?> doublon(s)"><a href="doublons.php">Afficher les doublons</a></div>
		<div class="separateur"></div>
	</div>
	<div id="contenuSBN">
		<div id="recherche">
			<input type="hidden" class="recherche" id="recherchePage" value="<?php echo $page; ?>" />
			<table class="tableau">
				<tr>
					<th colspan="5">Recherche</th>
				</tr>
				<tr>
					<td>Id : <input type="text" class="rechercheAdmin" id="rechercheId"<?php echo ( isset($_SESSION['admin_id']) && $_SESSION['admin_id'] != 0 ? ' value="'.$_SESSION['admin_id'].'"' : '') ?> /></td>
					<td>Nom : <input type="text" class="rechercheAdmin" id="rechercheNom"<?php echo ( isset($_SESSION['admin_nom']) ? ' value="'.$_SESSION['admin_nom'].'"' : '') ?> /></td>
					<td>Ville : <input type="text" class="rechercheAdmin" id="rechercheVille"<?php echo ( isset($_SESSION['admin_ville']) ? ' value="'.$_SESSION['admin_ville'].'"' : '') ?> /></td>
					<td>Th&eacute;matique : <?php echo $thematique; ?></td>
					<td><div id="loader"><img src="../../images/ajax-loader-sbn.gif" alt="loader" /></div></td>
				</tr>
			</table>
		</div>
		<hr />
		<div id="entreprises">
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
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<?php require_once('../inclusions/layout/bas.php'); ?>