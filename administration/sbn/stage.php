<?php

	if(!isset($_GET['stage_entreprise']) && !isset($_GET['stage_id']) || empty($_GET['stage_entreprise']) && empty($_GET['stage_id'])){
		header('location: index.php?erreur=Stage entreprise ou stage id absent');
	}

	require_once('../inclusions/layout/haut.php');

	if(isset($_GET['stage_id']) && !empty($_GET['stage_id'])){
		$s = new Stage($BDD, $_GET['stage_id']);
		$action = "modifier";
	} else {
		$s = new Stage($BDD);
		$action = "ajouter";
		$s->setEntreprise($_GET['stage_entreprise']);
	}
	$e = new Entreprise($BDD, $s->getEntreprise());
	
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
		<form action="actions.php" method="post" enctype="multipart/form-data">
			<input type="hidden" value="stage" name="type" />
			<input type="hidden" value="<?php echo $action; ?>" name="action" />
			<input type="hidden" value="<?php echo $s->getId(); ?>" name="stage_id" />
			<input type="hidden" value="<?php echo $s->getEntreprise(); ?>" name="stage_entreprise" />
			<div class="categorie">
				<a href="entreprise.php?id=<?php echo $s->getEntreprise(); ?>">Retour &agrave; l&apos;entreprise</a>
				<div class="title">Stage</div>
				<div class="infos">
					<span class="libelle">Date :</span> <input type="text" name="stage_date" id="datepickerSBN" value="<?php echo convertToDisplayDate($s->getTheDate()); ?>" /><br />
					<span class="libelle">Description :</span><br />
					<textarea name="stage_description" rows="5" cols="30"><?php echo $s->getDescription(); ?></textarea><br />
					<?php if($s->getFichier() == ""){ ?>
					<span class="libelle">Fichier :</span> <input type="file" name="stage_fichier" value="<?php echo $s->getFichier(); ?>" /><br />
					<?php } else { ?>
					<span class="libelle">Fichier :</span> <input type="file" name="stage_fichier" value="<?php echo $s->getFichier(); ?>" /><br />
					Fichier actuel : <a href="telecharger.php?stage=<?php echo $s->getId(); ?>"><?php echo $s->getFichier(); ?></a>
					<?php } ?>
				</div>
			</div>
			<div style="clear:both"></div>
			<div class="boutons">
				<input type="submit" value="Enregistrer" />
			</div>
		</form>
		<div class="boutons">
			<form action="actions.php" method="post" id="formSupprimer">
				<input type="hidden" value="stage" name="type" />
				<input type="hidden" value="supprimer" name="action" />
				<input type="hidden" value="<?php echo $s->getId(); ?>" name="stage_id" />
				<input type="hidden" value="<?php echo $s->getEntreprise(); ?>" name="stage_entreprise" />
				<input type="button" value="Supprimer" id="supprimerEntree" />
			</form>
		</div>
		<div id="dialog-confirm" title="Supprimer ce stage ?" style="display: none;">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&Ecirc;tes vous sur de vouloir supprimer ce stage ?</p>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<?php require_once('../inclusions/layout/bas.php'); ?>