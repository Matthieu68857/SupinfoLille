<?php

	require_once('../inclusions/layout/haut.php');

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$e = new Entreprise($BDD, $_GET['id']);
		$action = "modifier";
	} else {
		$e = new Entreprise($BDD);
		$action = "ajouter";
	}
	
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
		<div class="choix" title="Afficher les <?php echo getNombreDoublons(); ?> doublon(s)"><a href="doublons.php">Afficher les doublons</a></div>
		<div class="separateur"></div>
	</div>
	<div id="contenuSBN">
		<a href="index.php">Retour &agrave; la liste des entreprises</a>
		<form action="actions.php" method="post">
			<input type="hidden" value="entreprise" name="type" />
			<input type="hidden" value="<?php echo $action; ?>" name="action" />
			<input type="hidden" value="<?php echo $e->getId(); ?>" name="entreprise_id" />
			<div class="categorie">
				<div class="title">Informations</div>
				<div class="infos">
					<span class="libelle">Entreprise :</span> <input type="text" name="entreprise_nom" value="<?php echo $e->getNom(); ?>" /><br />
					<span class="libelle">Site Internet :</span> <input type="text" name="entreprise_site" value="<?php echo ($e->getSite() == 'NON RENSEIGNE' ? '' : $e->getSite()); ?>" /><br />
					<span class="libelle">Th&eacute;matique :</span> <input type="text" name="entreprise_thematique" value="<?php echo ($e->getThematique() == 'NON RENSEIGNE' ? '' : $e->getThematique()); ?>" /><br />
					<span class="libelle">Infos :</span> <input type="text" name="entreprise_infos" value="<?php echo ($e->getInfos() == 'NON RENSEIGNE' ? '' : $e->getInfos()); ?>" />
				</div>
			</div>
			<div class="categorie">
				<div class="title">Localisation</div>
				<div class="infos">
					<span class="libelle">Adresse :</span> <input type="text" name="entreprise_adresse" value="<?php echo ($e->getAdresse() == 'NON RENSEIGNE' ? '' : $e->getAdresse()); ?>" /> &agrave; <input type="text" name="entreprise_ville" value="<?php echo ($e->getVille() == 'NON RENSEIGNE' ? '' : $e->getVille()); ?>" /><br />
					<span class="libelle">Code postal :</span> <input type="text" name="entreprise_cp" value="<?php echo ($e->getCP() == 'NON RENSEIGNE' ? '' : $e->getCP()); ?>" /><br />
				</div>
			</div>
			<div style="clear:both"></div>
			<div class="boutons">
				<input type="submit" value="Enregistrer" />
			</div>
		</form>
		<div class="boutons">
			<form action="actions.php" method="post" id="formSupprimer">
				<input type="hidden" value="entreprise" name="type" />
				<input type="hidden" value="supprimer" name="action" />
				<input type="hidden" value="<?php echo $e->getId(); ?>" name="entreprise_id" />
				<input type="button" value="Supprimer" id="supprimerEntree" />
			</form>
		</div>
		<div style="clear:both"></div>
		<?php if($e->getId() != 0){ ?>
		<div class="categorie">
			<div class="title">Contact</div>
			<div class="infos">
				<?php
					$contacts = $e->getContacts();
					$first = true;
					foreach($contacts as $c){
				?>
				<div>
					<span class="libelle">T&eacute;l&eacute;phone :</span> <?php echo ($c->getTelephone() == 'NON RENSEIGNE' ? '' : $c->getTelephone()); ?> <br />
					<span class="libelle">Fax :</span> <?php echo ($c->getFax() == 'NON RENSEIGNE' ? '' : $c->getFax()); ?> <br />
					<span class="libelle">Nom :</span> <?php echo ($c->getNom() == 'NON RENSEIGNE' ? '' : $c->getNom()); ?> <br />
					<span class="libelle">Role :</span> <?php echo ($c->getRole() == 'NON RENSEIGNE' ? '' : $c->getRole()); ?> <br />
					<span class="libelle">Email :</span> <?php echo ($c->getEmail() == 'NON RENSEIGNE' ? '' : $c->getEmail()); ?>
					<form action="contact.php" method="get">
						<input type="hidden" name="contact_id" value="<?php echo $c->getId(); ?>" />
						<input type="submit" value="Modifier le contact" />
					</form>
				</div>
				<hr />
				<?php } ?>
				<div>
					<form action="contact.php" method="get">
						<input type="hidden" name="contact_entreprise" value="<?php echo $e->getId(); ?>" />
						<input type="submit" value="Ajouter un contact" />
					</form>
				</div>
			</div>
		</div>
		<div class="categorie">
			<div class="title">Stage</div>
			<div class="infos">
				<?php
					$stages = $e->getStages();
					$nombreStages = count($stages);
					$first = true;
					foreach($stages as $s){
				?>
				<div>
					<span class="libelle">Date :</span> <?php echo convertToDisplayDate($s->getTheDate()) ?> <br />
					<?php
						if($s->getFichier() != ""){
					?>
					<span class="libelle">Fichier :</span> <a href="telecharger.php?stage=<?php echo $s->getId(); ?>"><?php echo $s->getFichier(); ?></a> <br />
					<?php } ?>
					<span class="libelle">Description :</span> <?php echo $s->getDescription(); ?>
					<form action="stage.php" method="get">
						<input type="hidden" name="stage_id" value="<?php echo $s->getId(); ?>" />
						<input type="submit" value="Modifier le stage" />
					</form>
				</div>
				<hr />
				<?php
					}
					if($nombreStages >= 5){
				?>
				<div>
					<span class="libelle">5 stages au maximum</span>
				</div>
				<?php } else { ?>
				<div>
					<form action="stage.php" method="get">
						<input type="hidden" name="stage_entreprise" value="<?php echo $e->getId(); ?>" />
						<input type="submit" value="Ajouter un stage" />
					</form>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
		<div id="dialog-confirm" title="Supprimer cette entreprise ?" style="display: none;">
			<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&Ecirc;tes vous sur de vouloir supprimer cette entreprise et tous les contacts et stages associ&eacute;s ?
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<?php require_once('../inclusions/layout/bas.php'); ?>