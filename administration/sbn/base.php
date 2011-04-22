<?php
	require_once('../inclusions/layout/haut.php');

	$nombreEntreprises = getNombreEntreprises();

	if(isset($_GET['page']) && !empty($_GET['page']) && preg_match("#^[0-9]*$#", $_GET['page'])){
		if((($_GET['page'] * 30) > $nombreEntreprises) && (($_GET['page'] * 30 - $nombreEntreprises) > 30)){
			$page = ceil($nombreEntreprises / 30);
		} else {
			$page = $_GET['page'];
		}
	} else {
		$page = 1;
	}
	
	$entreprises = getEntreprises((($page - 1) * 30), 30);
	
	$results = getThematiques();
	$thematique = '<select class="rechercheAdminSelect" id="rechercheThematique">';
	$thematique .= '<option '.( !isset($_SESSION['admin_thematique']) ? ' selected="selected"' : '').' value="">Choisir une thematique</option>';
	foreach($results as $r){
		$thematique .= '<option value="'.$r->entreprise_thematique.'"'.( isset($_SESSION['admin_thematique']) && $_SESSION['admin_thematique'] == $r->entreprise_thematique ? ' selected="selected"' : '').'>'.$r->entreprise_thematique.'</option>';
	}
	$thematique .= '</select>';
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
		<div class="choix selected" title="Afficher les <?php echo getNombreEntreprises(); ?> entreprises et les <?php echo getNombreContacts(); ?> contacts dans un même tableau"><a href="base.php">Afficher toutes les données</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Afficher les <?php echo getNombreDoublons(); ?> doublon(s)"><a href="doublons.php">Afficher les doublons</a></div>
		<div class="separateur"></div>
	</div>
	<div id="contenuSBN">
		<div id="entreprises">
			<table class="tableau base">
				<tr>
					<th>Nom</th>
					<th>Adresse</th>
					<th>Code postal</th>
					<th>Ville</th>
					<th>Site</th>
					<th>Thematique</th>
					<th>Modifier</th>
				</tr>
				<?php
					foreach($entreprises as $e){
						$contacts = $e->getContacts();
				?>
				<tr>
					<td rowspan="<?php echo (count($contacts) != 0 ? count($contacts) + 2 : 1); ?>"><?php echo $e->getNom(); ?></td>
					<td><?php echo $e->getAdresse(); ?></td>
					<td><?php echo $e->getCP(); ?></td>
					<td><?php echo $e->getVille(); ?></td>
					<td><?php echo $e->getSite(); ?></td>
					<td><?php echo $e->getThematique(); ?></td>
					<td><?php echo getModifLink($e->getId()); ?></td>
				</tr>
					<?php
						if(!empty($contacts)){
					?>
					<tr class="contactTrHeader">
						<th>Téléphone</th>
						<th>Fax</th>
						<th>Nom</th>
						<th>Role</th>
						<th>Email</th>
						<th>Modifier</th>
					</tr>
						<?php
							foreach($contacts as $c){
						?>
						<tr class="contactTr">
							<td><?php echo $c->getTelephone(); ?></td>
							<td><?php echo $c->getFax(); ?></td>
							<td><?php echo $c->getNom(); ?></td>
							<td><?php echo $c->getRole(); ?></td>
							<td><?php echo $c->getEmail(); ?></td>
							<td><?php echo '<a href="contact.php?contact_entreprise='.$e->getId().'&contact_id='.$c->getId().'">Modifier</a>'; ?></td>
						</tr>
						<?php } ?>
					<?php } ?>
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
		    		<a href="base.php?page=1">Premi&egrave;re page</a>
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
								 <a href="base.php?page=<?php echo $i; ?>"><?php echo $i; ?></a> 
							<?php
							}
						}
					}
					if(($page + 4) < $nombrePages){
					?>
						... <a href="base.php?page=<?php echo $nombrePages; ?>">Derni&egrave;re page</a>
					<?php } ?>
				</p>
			<?php } ?>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<?php require_once('../inclusions/layout/bas.php'); ?>