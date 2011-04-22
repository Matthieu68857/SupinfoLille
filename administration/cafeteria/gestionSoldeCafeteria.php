<?php

	require_once("../inclusions/layout/haut.php");
	
	if(isset($_GET['idbooster'])){
		$student = new Student($_GET['idbooster']);
	} elseif(isset($_POST['new_student'])){
		$student = new Student($_POST['new_student']);
	} else {
		$student = new Student($_SESSION['user']['idbooster']);
	}
	
	if(isset($_POST['ajouter'])){
		modifierSolde($student->getIdbooster(), $student->getSoldeCafeteria() + $_POST['ajouter']);
		$student = new Student($student->getIdbooster());
	}
	
	if(isset($_POST['enlever'])){
		modifierSolde($student->getIdbooster(), $student->getSoldeCafeteria() - $_POST['enlever']);
		$student = new Student($student->getIdbooster());
	}

?>

	<div id="solde_historique_cafeteria">
	<h2><?php echo $student->getPrenom() . " - " . $student->getIdbooster(); ?></h2>
		<p>Le solde de <?php echo $student->getPrenom() . " " . $student->getNom(); ?> est de : <strong id="solde"><?php echo $student->getSoldeCafeteria(); ?> €</strong></p>
		<br/>
	<h2>Ses dernières consommations</h2>
		<?php
		
		$transactions = getHistoriqueConsommations($student->getIdbooster());
		
		if(count($transactions) == 0){
			echo "<strong style='color:red'>Aucune consommation pour le moment.</strong>";
		} else {
		
		?>
		
		<table>
			<tr><th>Date</th><th>Consommation</th></tr>
			
		<?php
		
			foreach($transactions as $transaction){
				echo "<tr><td>" . $transaction->historique_date . "</td><td>" . $transaction->produit_nom . "</td></tr>";
			}
		
		?>	
			
		</table>
		
		<?php
		
		}
		
		?>
	</div>
	
	<div id="gestion_solde">
	<h2>Gérer le solde</h2>
	
	<form method="post" action="gestionSoldeCafeteria.php?idbooster=<?php echo $student->getIdbooster(); ?>">
		<p><input type="submit" value="Ajouter"/> <input type="text" name="ajouter" value="0.0"/> € au solde</p>
	</form>
	
	<form method="post" action="gestionSoldeCafeteria.php?idbooster=<?php echo $student->getIdbooster(); ?>">
		<p><input type="submit" value="Enlever"/> <input type="text" name="enlever" value="0.0"/> € au solde</p>
	</form>
	
	<br/>
	
	<h2>Changer de student</h2>
	
	<form method="post" action="gestionSoldeCafeteria.php">
		<p><input type="text" name="new_student"/></p>
		<p><input type="submit" value="Switcher"/></p>
	</form>
		
	</div>

	<div style="clear:both"></div>
	
	<p style="text-align:center; font-size: 18px;">
		<a href="cafeteria.php?idbooster=<?php echo $student->getIdbooster(); ?>">Retourner à la gestion de la caféteria</a>
	</p>

<?php

	require_once("../inclusions/layout/bas.php");

?>