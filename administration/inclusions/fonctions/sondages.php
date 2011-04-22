<?php

/* ************ getReponseChoix() ************
 * 
 * Retourne le nom de la réponse
 * 
 * @return string reponse
 *
 */

	function getReponseChoix($p_id){
		
		global $BDD;
	
		$reponse = $BDD->select(
			"sondage_choix",
			"TB_SONDAGES_CHOIX",
			"WHERE sondage_choix_id = ?",
			array($p_id)
		);
		
		return $reponse[0]->sondage_choix;
	
	}

?>