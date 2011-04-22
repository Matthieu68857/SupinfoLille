<?php

	if(!isset($_GET['contact_entreprise']) && !isset($_GET['contact_id']) || empty($_GET['contact_entreprise']) && empty($_GET['contact_id'])){
		header('location: index.php?erreur=Contact entreprise ou contact id absent');
	}

	require_once('../inclusions/layout/haut.php');

	if(isset($_GET['contact_id']) && !empty($_GET['contact_id'])){
		$c = new Contact($BDD, $_GET['contact_id']);
		$action = "modifier";
	} else {
		$c = new Contact($BDD);
		$action = "ajouter";
		$c->setEntreprise($_GET['contact_entreprise']);
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
		<form action="actions.php" method="post">
			<input type="hidden" value="contact" name="type" />
			<input type="hidden" value="<?php echo $action; ?>" name="action" />
			<input type="hidden" value="<?php echo $c->getId(); ?>" name="contact_id" />
			<input type="hidden" value="<?php echo $c->getEntreprise(); ?>" name="contact_entreprise" />
			<div class="categorie">
				<a href="entreprise.php?id=<?php echo $c->getEntreprise(); ?>">Retour &agrave; l&apos;entreprise</a>
				<div class="title">Contact</div>
				<div class="infos">
					<span class="libelle">T&eacute;l&eacute;phone :</span> <input type="text" name="contact_telephone" value="<?php echo ($c->getTelephone() == 'NON RENSEIGNE' ? '' : $c->getTelephone()); ?>" /><br />
					<span class="libelle">Fax :</span> <input type="text" name="contact_fax" value="<?php echo ($c->getFax() == 'NON RENSEIGNE' ? '' : $c->getFax()); ?>" /><br />
					<span class="libelle">Nom :</span> <input type="text" name="contact_nom" value="<?php echo ($c->getNom() == 'NON RENSEIGNE' ? '' : $c->getNom()); ?>" /><br />
					<span class="libelle">Role :</span> <input type="text" name="contact_role" value="<?php echo ($c->getRole() == 'NON RENSEIGNE' ? '' : $c->getRole()); ?>" /><br />
					<span class="libelle">Email :</span> <input type="text" name="contact_email" value="<?php echo ($c->getEmail() == 'NON RENSEIGNE' ? '' : $c->getEmail()); ?>" />
				</div>
			</div>
			<div style="clear:both"></div>
			<div class="boutons">
				<input type="submit" value="Enregistrer" />
			</div>
		</form>
		<div class="boutons">
			<form action="actions.php" method="post" id="formSupprimer">
				<input type="hidden" value="contact" name="type" />
				<input type="hidden" value="supprimer" name="action" />
				<input type="hidden" value="<?php echo $c->getId(); ?>" name="contact_id" />
				<input type="hidden" value="<?php echo $c->getEntreprise(); ?>" name="contact_entreprise" />
				<input type="button" value="Supprimer" id="supprimerEntree" />
			</form>
		</div>
		<div id="dialog-confirm" title="Supprimer ce contact ?" style="display: none;">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&Ecirc;tes vous sur de vouloir supprimer ce contact ?</p>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<?php require_once('../inclusions/layout/bas.php'); ?>