<?php

	require_once('../inclusions/initialisation.php');
	require_once("../inclusions/layout/haut.php");

?>

<div id="droits">

	<h2>Gestion des catégories</h2>
	<div id="categories_droits">
		<h3>Ajout d'une catégorie</h3>
		<div id="ajout_categorie">
			<label for="nouvelle_categorie_value">Catégorie : </label><input type="text" id="nouvelle_categorie_value" /><input type="hidden" id="nouvelle_categorie_id" /><br />
			<label for="nouvelle_categorie_admin">Catégorie d'admin : </label><input type="checkbox" id="nouvelle_categorie_admin" /><br />
			<button class="bouton" id="nouvelle_categorie">Ajouter la catégorie</button>
		</div>
		<h3>Suppression d'une catégorie</h3>
		<div id="suppression_categorie">
			<label for="ancienne_categorie_value">Catégorie : </label><input type="text" id="ancienne_categorie_value" class="auto_complete_categories" /><input type="hidden" id="ancienne_categorie_id" /><br />
			<button class="bouton" id="ancienne_categorie">Supprimer la catégorie</button>
		</div>
	</div>
	<h2>Gestion des groupes</h2>
	<div id="groupes_droits">
		<h3>Ajout d'un groupe</h3>
		<div id="ajout_groupe">
			<label for="nouveau_groupe_value">Groupe : </label><input type="text" id="nouveau_groupe_value" /><input type="hidden" id="nouveau_groupe_id" /><br />
			<button class="bouton" id="nouveau_groupe">Ajouter le groupe</button>
		</div>
		<h3>Suppression d'un groupe</h3>
		<div id="suppression_groupe">
			<label for="ancien_groupe_value">Groupe : </label><input type="text" id="ancien_groupe_value" class="auto_complete_groupes" /><input type="hidden" id="ancien_groupe_id" /><br />
			<button class="bouton" id="ancien_groupe">Supprimer la catégorie</button>
		</div>
		<h3>Modification d'un groupe</h3>
		<div id="modification_groupe">
			<label for="nom_groupe">Groupe : </label><input type="text" id="nom_groupe" class="auto_complete_groupes" /><input type="hidden" id="groupe_id" />
			<div style="clear:both;"></div>
			<div id="groupe_categories">
				<label for="ajouter_categorie">Catégorie : </label><input type="text" id="ajouter_categorie" class="auto_complete_categories" /><input type="hidden" id="ajouter_categorie_id" /> <button class="bouton action_modification_groupe" id="ajouter_categorie_bouton">Ajouter</button><button class="bouton action_modification_groupe" id="retirer_categorie_bouton">Retirer</button>
				<br />
				<span id="categories_actuelle"></span>
			</div>
			<div id="groupe_membres">
				<label for="ajouter_utilisateur">Utilisateur : </label><input type="text" id="ajouter_utilisateur" class="auto_complete_utilisateurs" /><input type="hidden" id="utilisateur_id" /><button class="bouton action_modification_groupe" id="ajouter_membre_bouton">Ajouter</button><button class="bouton action_modification_groupe" id="retirer_membre_bouton">Retirer</button>
				<br />
				<span id="membres_actuel"></span>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>

</div>
	
<?php

	require_once("../inclusions/layout/bas.php");

?>