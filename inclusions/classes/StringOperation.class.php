<?php 
class StringOperation {

/* ########## Fonction qui va executer plusieurs autre fonctions ########## */

	public static function operation($p_str, $backslash = false, $upper = false, $lower = false, $sansAccent = false, $formatFirst = false, $formatWords = false, $utf8Encode = false, $utf8Decode = false){
            if($backslash){
            	$p_str = StringOperation::noBackslash($p_str);
            }
            
            if($sansAccent){
            	$p_str = StringOperation::sansAccent($p_str);
            }
            
            if($upper){
            	$p_str = StringOperation::formatUpper($p_str);
            }
            
            if($lower){
            	$p_str = StringOperation::formatLower($p_str);
            }
            
            if($formatFirst){
            	$p_str = StringOperation::formatFirst($p_str);
            }
            
            if($formatWords){
            	$p_str = StringOperation::formatWords($p_str);
            }
            
            if($utf8Encode){
            	$p_str = utf8_encode($p_str);
            }
            
            if($utf8Decode){
            	$p_str = utf8_decode($p_str);
            }
            
            if(preg_match("#non[ ]renseigne#i", $p_str)){
            	$p_str = StringOperation::formatUpper($p_str);
            }
            
            return trim($p_str);
    }

/* ########## Supprimer les accents ########## */

	public static function sansAccent($p_str){
            $pattern = Array("/À/", "/Á/", "/Â/", "/Ã/", "/Ä/", "/Å/", "/Ç/", "/È/", "/É/", "/Ê/", "/Ë/", "/Ì/", "/Í/", "/Î/", "/Ï/", "/Ò/", "/Ó/", "/Ô/", "/Õ/", "/Ö/", "/Ù/", "/Ú/", "/Û/", "/Ü/", "/Ý/", "/à/", "/á/", "/â/", "/ã/", "/ä/", "/å/", "/ç/", "/è/", "/é/", "/ê/", "/ë/", "/ì/", "/í/", "/î/", "/ï/", "/ð/", "/ò/", "/ó/", "/ô/", "/õ/", "/ö/", "/ù/", "/ú/", "/û/", "/ü/", "/ý/", "/ÿ/");
            $rep_pat = Array("A", "A", "A", "A", "A", "A", "C", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "Y", "a", "a", "a", "a", "a", "a", "c", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "y", "y");
            $retour = preg_replace($pattern, $rep_pat, $p_str);
            return $retour;
    }
    
/* ########## Supprimer les backslash ########## */

	public static function noBackslash($p_str){
		return preg_replace("#\\\#", "", $p_str);
	}
	
/* ########## Applique la fonction ucfirst() ########## */

	public static function formatFirst($p_str){
		return ucfirst(mb_strtolower($p_str));
	}
	
/* ########## Applique la fonction ucwords() ########## */

	public static function formatWords($p_str){
		return ucwords(mb_strtolower($p_str));
	}
	
/* ########## Applique la fonction mb_strtoupper() ########## */

	public static function formatUpper($p_str){
		return mb_strtoupper($p_str);
	}
	
/* ########## Applique la fonction mb_strtolower() ########## */

	public static function formatLower($p_str){
		return mb_strtolower($p_str);
	}
}
?>