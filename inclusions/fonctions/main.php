<?php

/* ************ getCategoriesAutorisation() ************
 *
 * Renvoie la liste des pages que l'utilisateur est autoriser à voir.
 *
 */

	function getCategoriesAutorisation(){

		global $BDD;

		$_SESSION['categories'] = array();
		$_SESSION['categories_admin'] = array();

		$categories = $BDD->select(
			"categorie_nom, categorie_admin",
			"VW_AUTORISATIONS",
			"WHERE student_idbooster = ?",
			array($_SESSION['user']['idbooster'])
		);

		foreach($categories as $categorie){
			if($categorie->categorie_admin == "1"){
				array_push($_SESSION['categories_admin'], $categorie->categorie_nom);
			} else {
				array_push($_SESSION['categories'], $categorie->categorie_nom);
			}
		}

		// On autorise l'accès Invite si l'utilisateur a accès à rien (Evite les redirections infini à la connexion)
		if(empty($_SESSION['categories'])){
			$_SESSION['user']['status'] = "3";
			$categories = $BDD->select(
				"c.categorie_nom",
				"TB_CATEGORIES c " .
				"JOIN TB_GROUPES_has_CATEGORIES gc ON c.categorie_id = gc.categorie_id " .
				"JOIN TB_GROUPES g ON gc.groupe_id = g.groupe_id",
				"WHERE g.groupe_nom = 'Invite'"
			);

			foreach($categories as $categorie){
				array_push($_SESSION['categories'], $categorie->categorie_nom);
			}
		} else {
			$_SESSION['user']['status'] = "1";
		}

		if(!empty($_SESSION['categories_admin'])){
			$_SESSION['user']['status'] = "2";
		}
	}

/* ************ ajouterDansGroupeUtilisateur() ************
 *
 * Ajoute un nouveau utilisateur dans le groupe de droits utilisateurs
 *
 */

	function ajouterDansGroupeUtilisateur($p_idbooster){

		global $BDD;

		$idGroupe = $BDD->select(
			"groupe_id",
			"TB_GROUPES",
			"WHERE groupe_nom = 'Utilisateurs' LIMIT 0,1"
		);
		$idGroupe = $idGroupe[0]->groupe_id;
		$select = $BDD->select(
			"student_idbooster, groupe_id",
			"TB_STUDENTS_has_GROUPES",
			"WHERE student_idbooster = ? AND groupe_id = ? LIMIT 0,1",
			array($p_idbooster, $idGroupe)
		);
		if(count($select) == 0){
			$BDD->insert(
				'TB_STUDENTS_has_GROUPES',
				array('student_idbooster', 'groupe_id'),
				array('?', '?'),
				array($p_idbooster, $idGroupe)
			);
		}
	}

/* ************ addChatMessage() ************
 *
 * Ajoute un message dans le chat
 *
 */

 	function addChatMessage($p_source, $p_idbooster, $p_message){

 		$smileys = array(
			array(":@","<img src='../images/smileys/angry.gif' title='smiley' class='smiley'/>"),
			array(":D","<img src='../images/smileys/biggrin.gif' title='smiley' class='smiley'/>"),
			array("O_o","<img src='../images/smileys/blink.gif' title='smiley' class='smiley'/>"),
			array(":blush:","<img src='../images/smileys/blush.gif' title='smiley' class='smiley'/>"),
			array("8D","<img src='../images/smileys/cool.gif' title='smiley' class='smiley'/>"),
			array(" :/","<img src='../images/smileys/dry.gif' title='smiley' class='smiley'/>"),
			array(":/ ","<img src='../images/smileys/dry.gif' title='smiley' class='smiley'/>"),
			array(":o","<img src='../images/smileys/huh.gif' title='smiley' class='smiley'/>"),
			array("lol","<img src='../images/smileys/laugh.gif' title='smiley' class='smiley'/>"),
			array(":mellow:","<img src='../images/smileys/mellow.gif' title='smiley' class='smiley'/>"),
			array(":O","<img src='../images/smileys/ohmy.gif' title='smiley' class='smiley'/>"),
			array(":troll:","<img src='../images/smileys/ph34r.gif' title='smiley' class='smiley'/>"),
			array(":roll:","<img src='../images/smileys/rolleyes.gif' title='smiley' class='smiley'/>"),
			array(":\(","<img src='../images/smileys/sad.gif' title='smiley' class='smiley'/>"),
			array("-_-","<img src='../images/smileys/sleep.gif' title='smiley' class='smiley'/>"),
			array(":\)","<img src='../images/smileys/smile.gif' title='smiley' class='smiley'/>"),
			array(":P","<img src='../images/smileys/tongue.gif' title='smiley' class='smiley'/>"),
			array(":p","<img src='../images/smileys/tongue.gif' title='smiley' class='smiley'/>"),
			array(":unsure:","<img src='../images/smileys/unsure.gif' title='smiley' class='smiley'/>"),
			array(":S","<img src='../images/smileys/wacko.gif' title='smiley' class='smiley'/>"),
			array(";\)","<img src='../images/smileys/wink.gif' title='smiley' class='smiley'/>")
		);

		$student = new Student($p_idbooster);

		$user = "<a target='_BLANK' href='../etudiants/etudiants.php?idbooster=".$student->getIdbooster()."'>" .
			$student->getPrenom() . " " . $student->getNom() .
		"</a>";

		$message = wordwrap(htmlspecialchars(stripslashes($p_message)), 46, "\n", true);

		if($message != ""){

			if($p_source == "supirc"){
				$file = '../inclusions/javascript/chat/chatbox.php';
			} else {
				$file = 'chatbox.php';
			}

			// Transformation en Liens cliquables

			$in = array(
				'`((?:https?|ftp)://\\S+)(\\s|\\z)`',
				'`([[:alnum:]]([-_.]?[[:alnum:]])*@[[:alnum:]]([-_.]?[[:alnum:]])*\.([a-z]{2,4}))`'
			);

			$out = array(
				'<a href="$1" target="_blank">$1</a>$2',
				'<a href="mailto:$1">$1</a>'
			);

			$message = preg_replace($in, $out, $message);

			// remplacement des smileys

			foreach($smileys as $smiley){
				if(preg_match("#".$smiley[0]."#i", $message)){
					$message = preg_replace("#".$smiley[0]. "#i", $smiley[1], $message);
				}
			}

			if(preg_match("#:([0-9]+):#i", $message)){
				preg_match("#:([0-9]+):#i", $message, $smiley_boost);
				if(estInscritSurCePortail($smiley_boost[1])){
					$message = preg_replace(
						"#:([0-9]+):#",
						"<img src='http://www.campus-booster.net/actorpictures/$1.jpg' title='smiley' class='smiley'/>",
						$message
					);
				}
			}

			// ajout du message

    		$date     = date('d/m/y H:i:s');
    		$new_line = "<dt><b>{$user}</b> {$date}</dt><dd>{$message}</dd>\n";
    		$content  = file($file);
    		$content  = array_slice($content, 0, $max_lines);
    		array_push($content, $new_line);
    		file_put_contents($file, $content);

		}

 	}

/* ************ printNotificationConnectes() ************
 *
 * Affiche la notification des nouveaux connectés
 *
 */

	function printNotificationConnectes(){

		global $BDD;

		$students_connectes = getNoNotifConnectes();

		if (isset($students_connectes[0]) && $students_connectes[0]->student_prenom != "") {

		$p_connectes = "";
			$p_connectes .= $students_connectes[0]->student_prenom . " " . $students_connectes[0]->student_nom . ", ";

		$nom = "<strong>" . $p_connectes . "</strong>";

		echo '<div class="notice">'
								  . '<div class="notice-body">'
									  . '<a href="../etudiants/etudiants.php?idbooster="' . $students_connectes[0]->student_idbooster.'">							<img title="' . $students_connectes[0]->student_idbooster . '"
					src="http://www.campus-booster.net/actorpictures/' . $students_connectes[0]->student_idbooster . '.jpg"/></a>'
									  . '<h3>Nouvelle connexion</h3>'
									  . '<p>' . "<strong>" . $p_connectes . "</strong>" .' s\'est connecté à la plateforme!</p>'
								  . '</div>'
								  . '<div class="notice-bottom">'
								  . '</div>'
							  . '</div>';
		}

	}

/* ************ getNoNotifConnectes() ************
 *
 * Retourne la liste des connectés qui n'ont pas encore eu de notification
 *
 * @return array liste students
 *
 */

	function getNoNotifConnectes(){

		global $BDD;

		$students = $BDD->select(
			"c.student_idbooster, s.student_prenom, s.student_nom, c.connecte_notification",
			"TB_STUDENTS s JOIN TB_CONNECTES c ON s.student_idbooster = c.student_idbooster",
			"WHERE c.connecte_notification <= CURRENT_TIMESTAMP() AND c.connecte_notification >= (CURRENT_TIMESTAMP()-3) ORDER BY s.student_nom, s.student_prenom"
		);

		return $students;

	}

/* ************ getNbEntraidesEnCours() ************
 *
 * Retourne le nombre de questions non répondues
 *
 * @return int nb questions en attente
 *
 */

	function getNbEntraidesEnCours(){

		global $BDD;

		$entraide = $BDD->select(
			"COUNT(*) AS NB",
			"TB_ENTRAIDES",
			"WHERE entraide_resolu = 0"
		);

		return $entraide[0]->NB;
	}


/* ************ printStudentConnectes() ************
 *
 * Affiche la liste des connectés
 *
 */

	function printStudentConnectes(){

		$students_connectes = getStudentConnectes();

		$p_connectes = "";

		foreach($students_connectes as $student_connecte){
			$p_connectes .=
				"<a href='../etudiants/etudiants.php?idbooster=".$student_connecte->student_idbooster."'>".
					$student_connecte->student_prenom . " " . $student_connecte->student_nom .
				"</a>, ";
		}

		$p_connectes = substr($p_connectes, 0, strlen($p_connectes)-2);

		echo "<strong>" . count($students_connectes) . " connecté(s) : </strong> " . $p_connectes;

	}

/* ************ getStudentConnectes() ************
 *
 * Retourne la liste des connectés
 *
 * @return array liste students
 *
 */

	function getStudentConnectes(){

		global $BDD;

		$students = $BDD->select(
			"DISTINCT c.student_idbooster, s.student_prenom, s.student_nom",
			"TB_STUDENTS s JOIN TB_CONNECTES c ON s.student_idbooster = c.student_idbooster",
			"ORDER BY s.student_nom, s.student_prenom"
		);

		return $students;

	}

/* ************ checkStudentIpConnexion() ************
 *
 * Vérifie l'enregistrement de la connexion dans la table TB_CONNECTES
 *
 */

	function checkStudentIpConnexion($p_idbooster, $p_ip){

		global $BDD;

		$NB = $BDD->select(
			"COUNT(*) AS NB",
			"TB_CONNECTES",
			"WHERE student_idbooster = ?",
			array($p_idbooster)
		);

		if($NB[0]->NB == 0){
			$BDD->insert(
				"TB_CONNECTES",
				array("student_idbooster","connecte_ip","connecte_timestamp","connecte_notification"),
				array("?","?","CURRENT_TIMESTAMP()","CURRENT_TIMESTAMP()"),
				array($p_idbooster, $p_ip)
			);
		} else {
			$BDD->update(
				"TB_CONNECTES",
				array("connecte_timestamp = CURRENT_TIMESTAMP()"),
				"student_idbooster = ? AND connecte_ip = ?",
				array($p_idbooster, $p_ip)
			);
		}

		$BDD->delete(
			"TB_CONNECTES",
			"connecte_timestamp < CURRENT_TIMESTAMP()-120"
		);

	}


/* ************ estInscritSurCePortail() ************
 *
 * Renvoit un bool pour savoir si le student est dans la BDD ou non
 *
 * @return bool inscrit ou pas
 *
 */

	function estInscritSurCePortail($p_idbooster){

		$BDD = new BDD();

		$NB = $BDD->select(
			"COUNT(student_idbooster) AS NB",
			"TB_STUDENTS",
			"WHERE student_idbooster = ?",
			array($p_idbooster)
		);

		if($NB[0]->NB > 0 || $p_idbooster == 300){
			return true;
		} else {
			return false;
		}

	}

/* ************ stripAccents() ************
 *
 * Supprime tous les accents de la chaine
 *
 */

	function stripAccents($string){
		return str_replace(
			explode(' ', 'à á â ã ä ç è é ê ë ì í î ï ñ ò ó ô õ ö ù ú û ü ý ÿ À Á Â Ã Ä Ç È É Ê Ë Ì Í Î Ï Ñ Ò Ó Ô Õ Ö Ù Ú Û Ü Ý'),
			explode(' ', 'a a a a a c e e e e i i i i n o o o o o u u u u y y A A A A A C E E E E I I I I N O O O O O U U U U Y'),
			$string
		);
	}

/* ************ getNombreNews() ************
 *
 * Renvoit le nombre total de news - 1
 *
 * @return int nombre news - 1
 *
 */

	function getNombreNews(){

		global $BDD;

		$count = $BDD->select(
			"COUNT(*) AS NB",
			"TB_NEWS",
			""
		);

		return $count[0]->NB - 1;

	}

/* ************ getThisNew() ************
 *
 * Renvoit la news correspondante au parametre
 *
 * @return objet contenant toutes les infos de la news
 *
 */

	function getThisNew($pagenews){

		global $BDD;

		$news = $BDD->select(
			"*",
			"TB_NEWS",
			"ORDER BY news_id DESC LIMIT ".$pagenews.",1"
		);

		$auteur = new Student($news[0]->news_auteur);

		$news[0]->news_auteur = $auteur;

		return $news[0];

	}

/* ************ majVisites() ************
 *
 * Met à jour le nombre de visite et la date de dernière visite d'un eleve
 *
 */

	function majVisites($p_idbooster){

		global $BDD;

		$visite = $BDD->select(
			"DATE_FORMAT(student_derniere_visite, '%Y-%m-%d') AS student_derniere_visite, DATE_FORMAT(CURDATE(), '%Y-%m-%d') AS curdate",
			"TB_STUDENTS",
			"WHERE student_idbooster = ?",
			array($p_idbooster)
		);

		if($visite[0]->student_derniere_visite != $visite[0]->curdate){

			$BDD->update(
				"TB_STUDENTS",
				array("student_derniere_visite = CURRENT_TIMESTAMP()","student_visites = student_visites + 1"),
				"student_idbooster = ?",
				array($p_idbooster)
			);

		}

	}

/* ************ checkUserLogin() ************
 *
 * Renvoit un booleen pour confirmer ou non la connexion
 *
 * @return bool
 *
 */

	function checkUserLogin($p_login, $p_pass, $check_cookies=false){

		global $BDD;

		if(!$check_cookies){

			$nb = $BDD->select(
				"COUNT(*) AS NB",
				"TB_STUDENTS",
				"WHERE student_idbooster = ? AND student_pass = ?",
				array($p_login,$p_pass)
			);

			if($nb[0]->NB == 1){
				return true;
			} else {
				return false;
			}

		} else {

			$user = $BDD->select(
				"student_pass",
				"TB_STUDENTS",
				"WHERE student_idbooster = ?",
				array($p_login)
			);

			if(md5(GBL_SEL).$user[0]->student_pass == $p_pass){
				return true;
			} else {
				return false;
			}

		}

	}

/* ************ checkGuestLogin() ************
 *
 * Renvoit un booleen pour confirmer ou non la connexion invité
 *
 * @return bool
 *
 */

	function checkGuestLogin($p_prenom, $p_nom, $p_pass){
		if(md5(GBL_SEL) . md5($p_prenom . " " . $p_nom . GBL_SEL) == $p_pass){
			return true;
		} else {
			return false;
		}
	}

/* ************ standardCharacter() ************
 *
 * Supprime les caractères autre que A-Za-z0-9 .-_@
 *
 * @param string	La chaine qui ne doit pas avoir les caractères non standard
 *
 */

	function standardCharacter($p_string){
		return preg_replace("#[^A-Za-z0-9_.@ -]#", "", $p_string);
	}


/* ************ telechargerDocument() ************
 *
 * Télécharger un document
 *
 */

	function telechargerDocument($p_fichier, $p_chemin){

		switch(strrchr(basename($p_fichier), ".")) {
			case ".zip": $type = "application/zip"; break;
			case ".pdf": $type = "application/pdf"; break;
			case ".png": $type = "image/png"; break;
			case ".gif": $type = "image/gif"; break;
			case ".jpg": $type = "image/jpeg"; break;
			case ".txt": $type = "text/plain"; break;
			case ".htm": $type = "text/html"; break;
			case ".html": $type = "text/html"; break;
			default: $type = "application/octet-stream"; break;

		}

		if(file_exists($p_chemin . $p_fichier)){
			header("Content-disposition: attachment; filename=" . $p_fichier);
			header("Content-Type: application/force-download");
			header("Content-Transfer-Encoding: " . $type . "\n");
			header("Content-Length: ".filesize($p_chemin . $p_fichier));
			header("Pragma: no-cache");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
			header("Expires: 0");
			readfile($p_chemin . $p_fichier);
		} else {
			echo "404 - File not found";
		}
	}
?>