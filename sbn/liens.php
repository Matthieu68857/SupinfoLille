<?php

	require_once('../inclusions/layout/haut.php');
	
?>
<div id="sbn">
	<div id="menuSBN">
		<div class="separateur"></div>
		<div class="choix" title="Stages"><a href="stages.php">Stages</a></div>
		<div class="separateur"></div>
		<div class="choix" title="Entreprises"><a href="entreprises.php">Entreprises</a></div>
		<div class="separateur"></div>
		<div class="choix selected" title="Liens utiles"><a href="liens.php">Liens utiles</a></div>
		<div class="separateur"></div>
	</div>
	<div id="contenuSBN">
		<div id="liensUtiles">
				<p><?php echo getlink('http://www.apec.fr'); ?></p>
				<hr />
				<p><?php echo getlink('http://www.monster.fr'); ?></p>
				<hr />
				<p><?php echo getlink('http://www.pole-emploi.fr/accueil'); ?></p>
				<hr />
				<p><?php echo getLink('http://www.keljob.com/conseils-emploi/chercher-un-emploi/conseils-entretien-dembauche/entretien-les-bonnes-reponses-aux-questions-sur-la-motivation.html', 'Conseils entretien d\'embauche'); ?></p>
				<hr />
				<p>
					<b>HBC CONSULTANTS</b><br />
					Centre Mercure 445, Boulevard Gambetta 59200 Tourcoing<br />
					Matthias Boone<br />
					Email: <?php echo getLink('matthias@hbcconsultants.fr'); ?>
				</p>
				<hr />
				<p>
					<b>Kelly IT Ressources</b><br />
					46 place du Général de Gaulle - 59000 Lille<br />
					Marie HEGO | Chargée de Recrutement <br />
					Email: <?php echo getLink('marie.hego@kellyservices.fr'); ?> | Tel: 03.20.12.38.92 | Fax: 03.20.12.38.94
				</p>
				<hr />
				<p>
					<b>INEAT CONSEIL</b><br />
					Vanessa TAINMONT | Chargée de recrutement  <br />
					<?php echo getLink('vanessa.tainmont@ineat-conseil.com'); ?>
				</p>
				<hr />
				<p>
					<img src="images/Exactitude.jpg" alt="Exactitude" /><br />
					23 Boulevard du Général Leclerc 59100 ROUBAIX <br />
					Dorothée DHOUAILLY <br />
					Email: <?php echo getLink('d.dhouailly@exactitude.eu'); ?> | Tel: 03.59.05.85.31 | Port: 06.68.34.25.51
				</p>
				<hr />
				<p>
					<b>Groupe CONSORT NT</b><br />
					Immeuble Le Leeds 253 Boulevard de Leeds 59777 LILLE<br />
					Vincent LAIRY<br />
					Email: <?php echo getLink('Vincent.LAIRY@consortnt.fr'); ?>
				</p>
				<hr />
				<p>
					<img src="images/RH Performances.png" alt="RH Performances" />
				</p>
			</ul>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<?php require_once('../inclusions/layout/bas.php'); ?>