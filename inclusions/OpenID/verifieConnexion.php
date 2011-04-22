<?php

	session_start();
	
	require_once("../configuration.php");
	require_once("../auto_chargement_classes.php");
	
	$BDD = new BDD();
	
	require_once("../fonctions/main.php");
	require_once('Auth/OpenID/SReg.php');
	
	function getUserInfos($p_sreg){
		$attr = array();
		
		$attr['IDBooster'] = $_COOKIE['idbooster'];
		$fullname = preg_split("# #", $p_sreg['fullname']);
		$attr['Prenom'] = $fullname[0];
		$attr['Nom'] = $fullname[1];
		
		for($i = 1; $i <= 5; $i++){
			if(isset($_GET['openid_alias3_count_alias' . $i])){
				$rank = array();
				for($j = 1; $j <= $_GET['openid_alias3_count_alias' . $i]; $j++){
					array_push($rank, $_GET['openid_alias3_value_alias' . $i . '_' . $j]);
				}
				$attr[preg_replace("#Person#", "", $_GET['openid_alias3_type_alias' . $i])] = $rank;
			} else if(isset($_GET['openid_alias3_type_alias' . $i]) && $_GET['openid_alias3_value_alias' . $i]){
				$attr[preg_replace("#Person#", "", $_GET['openid_alias3_type_alias' . $i])] = $_GET['openid_alias3_value_alias' . $i];
			}
		}
		
		$campus = explode(";", $attr['Campus']);
		
		$attr['CampusID'] = $campus[0];
		$attr['Cursus'] = getCursus($attr['Cursus']);
		
		return $attr;
	}
	
	function getCursus($p_cursus){
		switch($p_cursus){
			case 'SIIT;1;WorldWide;':
				return 'B1';
				break;
			case 'SIIT;2;WorldWide;':
				return 'B2';
				break;
			case 'SIIT;3;WorldWide;':
				return 'B3';
				break;
			case 'SIIT;1;Specialized;':
				return 'M1';
				break;
			case 'SIIT;2;Specialized;':
				return 'M2';
				break;
			default:
				return 'Inconnu';
				break;
		}
	}
	
	$store = new Auth_OpenID_FileStore(OID_STORAGE);
	$consumer = new Auth_OpenID_Consumer($store);

	$result = $consumer->complete(OID_RETURN_TO);
	if ($result->status == Auth_OpenID_SUCCESS) {
		$sreg = Auth_OpenID_SRegResponse::fromSuccessResponse($result)->contents();

		$infos = getUserInfos($sreg);
		
		if($infos['CampusID'] == GBL_CAMPUS_ID){
			$s = new Student($infos['IDBooster']);
			if($s->getPromo() == ''){
				$s->setPromo($infos['Cursus']);
				$s->setPrenom($infos['Prenom']);
				$s->setNom($infos['Nom']);
				$s->setDerniere_visite(date('Y-m-d', time()));
				$s->setVisites(0);
				$s->setSoldeCafeteria(0);
				if($_COOKIE['save'] == "true"){
					//$s->setAutorisation('1');
					$s->setPass(md5($infos['Prenom'] . ' ' . $infos['Nom'] . time()));
					$s->sauvegarder();
					ajouterDansGroupeUtilisateur($infos['IDBooster']);
				} else {
					//$s->setAutorisation('3');
					$s->setPass(md5($infos['Prenom'] . ' ' . $infos['Nom'] . GBL_SEL));
				}
			} else if($s->getPromo() != ''){
				if($s->getPromo() != $infos['Cursus']){
					$s->setPromo($infos['Cursus']);
					$s->sauvegarder();
				}
			}
			
			/*$_SESSION['user']['idbooster'] = $s->getIdBooster();
			$_SESSION['user']['status'] = $s->getAutorisation();
			$_SESSION['user']['prenom'] = $s->getPrenom();
			$_SESSION['user']['nom'] = $s->getNom();
			$_SESSION['user']['pass'] = md5(GBL_SEL).$s->getPass();*/
			
			setcookie('save', '', 0, '/', '.' . GBL_NDD);
			setcookie('idbooster', $s->getIdBooster(), time() + 31*24*3600, '/', '.' . GBL_NDD);
			setcookie('pass', md5(GBL_SEL).$s->getPass(), time() + 31*24*3600, '/', '.' . GBL_NDD);
			setcookie('nom', $s->getNom(), time() + 31*24*3600, '/', '.' . GBL_NDD);
			setcookie('prenom', $s->getPrenom(), time() + 31*24*3600, '/', '.' . GBL_NDD);
			//setcookie('status', $s->getAutorisation(), time() + 31*24*3600, '/', '.' . GBL_NDD);
			setcookie('loginSuccess', "true", time() + 300, '/', '.' . GBL_NDD);
			//setcookie('role', $infos['Role'], time() + 31*24*3600, '/', '.' . GBL_NDD);
			
			majVisites($s->getIdBooster());
			
		}

		header('location: ' . GBL_NDD_WWW);

	} else {
	
		header('location: ' . GBL_NDD_WWW);
		
	}

?>