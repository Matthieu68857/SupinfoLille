<?php

	require_once('../inclusions/initialisation.php');

	if(!isset($_GET['type']) && empty($_GET['type']) && !isset($_GET['id']) && empty($_GET['id'])){
		header('location: index.php?erreur=Erreur en affichant les details');
	} else {
		switch ($_GET['type']){
			case "entreprise":
				detailEntreprise($_GET['id']);
				break;
			case "stage":
				detailStage($_GET['id']);
				break;
			default:
				header('location: index.php?erreur=Erreur en affichant les details');
				break;
		}
	}
	
	function detailEntreprise($p_id){
		
		global $BDD;
		
		$e = new Entreprise($BDD, $p_id);
		if($e->getNom() == ""){
			header('location: index.php?erreur=Erreur en affichant les details');
		}
		$contacts = $e->getContacts();
		$stages = $e->getStages();
		
		require_once('../inclusions/layout/haut.php');
		
		?>
		<div id="sbn">
			<div id="menuSBN">
				<div class="separateur"></div>
				<div class="choix" title="Stages"><a href="stages.php">Stages</a></div>
				<div class="separateur"></div>
				<div class="choix" title="Entreprises"><a href="entreprises.php">Entreprises</a></div>
				<div class="separateur"></div>
				<div class="choix" title="Liens utiles"><a href="liens.php">Liens utiles</a></div>
				<div class="separateur"></div>
			</div>
			<div id="contenuSBN">
				<div class="categorie">
					<div class="title">Informations</div>
					<div class="infos">
						<span class="libelle">Entreprise :</span> <?php echo $e->getNom(); ?><br />
						<span class="libelle">Site :</span> <?php echo getLink($e->getSite()); ?><br />
						<span class="libelle">Th&eacute;matique :</span> <?php echo ($e->getThematique() == 'NON RENSEIGNE' ? '' : $e->getThematique()); ?><br />
						<span class="libelle">Infos :</span> <?php echo ($e->getInfos() == 'NON RENSEIGNE' ? '' : $e->getInfos()); ?>
					</div>
				</div>
				<div class="categorie">
					<div class="title">Localisation</div>
					<div class="infos">
						<iframe width="600" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=<?php echo ($e->getAdresse() == 'NON RENSEIGNE' ? '' : $e->getAdresse()) . ' ' . ($e->getVille() == 'NON RENSEIGNE' ? '' : $e->getVille()); ?>&amp;ie=UTF8&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br />
						<span class="libelle">Adresse :</span> <?php echo ($e->getAdresse() == 'NON RENSEIGNE' ? '' : $e->getAdresse()); ?> &agrave; <?php echo ($e->getVille() == 'NON RENSEIGNE' ? '' : $e->getVille()); ?><br />
						<span class="libelle">Code postal :</span> <?php echo $e->getCP(); ?>
					</div>
				</div>
				<div class="categorie">
					<div class="title">Contact</div>
					<div class="infos">
						<?php if(!empty($contacts)){ ?>
						<table>
						<?php
							$first = true; 
							foreach($contacts as $c){
							if($first){
								$first = false;
							} else {
								echo "<tr><td><hr /></td></tr>";
							}
						?>
							<tr>
								<td>
									<span class="libelle">T&eacute;l&eacute;phone :</span> <?php echo ($c->getTelephone() == 'NON RENSEIGNE' ? '' : $c->getTelephone()); ?><br />
									<span class="libelle">Fax :</span> <?php echo ($c->getFax() == 'NON RENSEIGNE' ? '' : $c->getFax()); ?><br />
									<span class="libelle">Nom :</span> <?php echo ($c->getNom() == 'NON RENSEIGNE' ? '' : $c->getNom()); ?><br />
									<span class="libelle">Role :</span> <?php echo ($c->getRole() == 'NON RENSEIGNE' ? '' : $c->getRole()); ?><br />
									<span class="libelle">Email :</span> <?php echo getLink($c->getEmail()); ?><br />
								</td>
							</tr>
						<?php } ?>
						</table>
						<?php } else { ?>
						<span class="libelle">Pas de contacts</span>
						<?php } ?>
					</div>
				</div>
				<div class="categorie">
					<div class="title">Stages</div>
					<div class="infos">
						<?php if(!empty($stages)){ ?>
						<table>
						<?php
							$first = true; 
							foreach($stages as $s){
							if($first){
								$first = false;
							} else {
								echo "<tr><td><hr /></td></tr>";
							}
						?>
							<tr>
								<th><?php echo convertToDisplayDate($s->getTheDate()); ?></th>
							</tr>
							<tr>
								<td>
									<?php echo makeReturn(limit($s->GetDescription(), 150)); ?><br />
									<?php echo getDetailLink("stage", $s->getId()); ?><br />
								</td>
							</tr>
						<?php } ?>
						</table>
						<?php } else { ?>
						<span class="libelle">Pas de stages</span>
						<?php } ?>
					</div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
		<?php
	}
	
	function detailStage($p_id){
		
		global $BDD;
		
		$s = new Stage($BDD, $p_id);
		if($s->getTheDate() == ""){
			header('location: index.php?erreur=Erreur en affichant les details');
		}
		$e = new Entreprise($BDD, $s->getEntreprise());
		require_once('../inclusions/layout/haut.php');
		?>
		<div id="sbn">
			<div id="menuSBN">
				<div class="separateur"></div>
				<div class="choix" title="Stages"><a href="stages.php">Stages</a></div>
				<div class="separateur"></div>
				<div class="choix" title="Entreprises"><a href="entreprises.php">Entreprises</a></div>
				<div class="separateur"></div>
				<div class="choix" title="Liens utiles"><a href="liens.php">Liens utiles</a></div>
				<div class="separateur"></div>
			</div>
			<div id="contenuSBN">
				<h1>Entreprise <?php echo $e->getNom(); ?> (<?php echo getDetailLink("entreprise", $e->getId()); ?>)</h1>
				<span class="libelle">Date du stage :</span> <?php echo convertToDisplayDate($s->getTheDate()); ?><br />
				<?php if($s->getFichier() != ""){ ?>
				<span class="libelle">Fichier :</span> <a href="telecharger.php?stage=<?php echo $s->getId(); ?>"><?php echo $s->getFichier(); ?></a><br />
				<?php } ?>
				<span class="libelle">Description :</span> <br /><?php echo makeReturn($s->getDescription()); ?>
			</div>
			<div style="clear: both;"></div>
		</div>
		<?php
	}
	
	require_once('../inclusions/layout/bas.php');
?>