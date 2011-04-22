<?php

	require_once("../inclusions/layout/haut.php");
	
?>

<div id="evenements">

<?php

if(isset($_GET['past'])){
	$events = getInactifsEvenements();
	echo '<h2><span class="inactif" onclick="location.href=\'evenements.php\'">Événements du moment</span> <div>Événements passés</div> </h2>';
} else {
	$events = getActifsEvenements();
	echo '<h2>Événements du moment <div class="inactif" onclick="location.href=\'evenements.php?past=true\'">Événements passés</div> </h2>';
}

?>

</div>

<br/>

<?php

foreach($events as $event){
		
	$date = explode("/", $event->evenement_date);
	
	echo '
	<div class="event">	
		<div class="event_header"> 
			<span class="date"><strong>'.$date[1].'</strong>'.$date[0].' <small>'.$date[2].'</small></span> 
			<h2>'.$event->evenement_titre.'</h2> 
			<span class="participants" id="participants_'.$event->evenement_id.'">'.$event->evenement_participants.' participants</span> 
			<p><span>'.getActionThisEvent($_SESSION['user']['idbooster'], $event->evenement_id).'</span> '.$event->evenement_ss_titre.'</p> 
		</div>
		<p>'.$event->evenement_description.'</p>
		<h3>Participants</h3> 
		<p class="ilsparticipent" id="ilsparticipent_'.$event->evenement_id.'">';
		
			printParticipantsEvenement($event->evenement_id);
		
	echo '</p>
	</div>
	';

}

	require_once("../inclusions/layout/bas.php");

?>

