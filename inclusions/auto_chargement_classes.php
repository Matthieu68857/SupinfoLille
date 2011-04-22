<?php

/* Inclusion : auto_chargement_classes
 * 		Permet de charger automatiquement les classes utilisées
 * 		A inclure dans chaque page pour l'utiliser 
 */


/* ************ chargerClasse ($classe) ************ */

	function chargerClasse ($classe)
    {
    	if(preg_match("#Auth_OpenID_#i", $classe)){
    		$split = split('_', $classe);
			include_once "OpenID/Auth/OpenID/${split[2]}.php";
    	} else {
        	require 'classes/' . $classe . '.class.php';
        }
    }
    
    spl_autoload_register ('chargerClasse');

?>