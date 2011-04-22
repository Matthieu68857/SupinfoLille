<?php

	require_once('../inclusions/initialisation.php');
	require_once("../inclusions/layout/haut.php");
		
?>

	<div id="top"><?php $clients = getTopClients(10); $top_count = 0;	foreach($clients as $client){ $top_count++;  ?>
    <span class="top_people"><a href="?idbooster=<?php echo $client->student_idbooster; ?>">
	<?php echo $client->student_prenom . " " . $client->student_nom ?></a></span>
	<?php if($top_count >= 5) { echo "<br />"; $top_count = 0; } } ?></div>
    
    <div id="cafet-header">
    	<div id="cafet-form">
        	<label for="student">Étudiant : </label><input type="text" value="<?php echo isset($_GET['idbooster']) ? $_GET['idbooster'] : 'Entrez un ID Booster...' ?>" name="student" id="cafet-input" />
             <button>Valider</button>
        </div>
    	<div id="cafet-student"></div>
    </div>
    
    <div id="container-basket">
    <div id="cafet-basket">
        <ul> 
        </ul>   
        <div id="total-container">Total : <span id="total">0.00</span> €</div> 
    </div>
    <button id='payer' style="display:none;">Payer</button>
    </div>
    
    <div id="cafet-products">
    <h2>Produits</h2>
        <ul> 
          <?php printAllProducts(); ?>
        </ul>
    </div>

<div style="clear:both"></div>
<?php

	require_once("../inclusions/layout/bas.php");

?>