<?php
	session_start();
	require_once('inclusions/librairies/twitteroauth.php');
	require_once('../inclusions/configuration.php');

	if (!empty($_SESSION['twitter_access_token']) && !empty($_SESSION['twitter_access_token']['oauth_token']) && !empty($_SESSION['twitter_access_token']['oauth_token_secret'])) { 
		// On a les tokens d'accès, l'authentification est OK.
		$access_token = $_SESSION['twitter_access_token'];

		// On créé la connexion avec twitter en donnant les tokens d'accès en paramètres.
		$connection = new TwitterOAuth(TWI_CONSUMER_KEY, TWI_CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	
		// On vérifie les infos du tweet
		if(isset($_SESSION['tweet']) && isset($_SESSION['tweet']['texte']) && isset($_SESSION['tweet']['url'])){
			publishOnTwitter($connection);
		}
	}
	elseif(isset($_REQUEST['oauth_token']) && $_SESSION['twitter_oauth_token'] === $_REQUEST['oauth_token']) {
		// Les tokens d'accès ne sont pas encore stockés, il faut vérifier l'authentification
		// On créé la connexion avec twitter en donnant les tokens d'accès en paramètres.
		$connection = new TwitterOAuth(TWI_CONSUMER_KEY, TWI_CONSUMER_SECRET, $_SESSION['twitter_oauth_token'], $_SESSION['twitter_oauth_token_secret']);
	
		// On vérifie les tokens et récupère le token d'accès
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	
		// On stocke en session les token d'accès et on supprime ceux qui ne sont plus utiles.
		$_SESSION['twitter_access_token'] = $access_token;
		unset($_SESSION['twitter_oauth_token']);
		unset($_SESSION['twitter_oauth_token_secret']);
	
		if (200 == $connection->http_code) {
			if(isset($_SESSION['tweet']) && isset($_SESSION['tweet']['texte']) && isset($_SESSION['tweet']['url'])){
				publishOnTwitter($connection);
			}
		}
	}
	
	if((!isset($_SESSION['twitter_access_token']) || empty($_SESSION['twitter_access_token'])) && !isset($_REQUEST['oauth_token'])){
		// Créer une connexion twitter avec les accès de l'application
		$connection = new TwitterOAuth(TWI_CONSUMER_KEY, TWI_CONSUMER_SECRET);

		// On demande les tokens à Twitter, et on passe l'URL de callback
		$request_token = $connection->getRequestToken(TWI_OAUTH_CALLBACK);

		// On sauvegarde le tout en session */
		$_SESSION['twitter_oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['twitter_oauth_token_secret'] = $request_token['oauth_token_secret'];

		// On test le code de retour HTTP pour voir si la requête précédente a correctement fonctionné
		switch ($connection->http_code) {
  			case 200:
    			// On construit l'URL de callback avec les tokens en params GET
    			$url = $connection->getAuthorizeURL($token);
    			header('Location: ' . $url); 
   	 			break;
  			default:
				$redirect = $_SESSION['redirect'];
				unset($_SESSION['redirect']);
				header('location: ' . $redirect);
    			break;
		}
	}
	
	function publishOnTwitter($p_connection){
		// On réduit l'url
		$url = file_get_contents('http://tinyurl.com/api-create.php?url=' . $_SESSION['tweet']['url']);
		// On regarde si le tweet n'est pas trop grand
		if(strlen($_SESSION['tweet']['texte']) + strlen($url) > 140){
			$texte = substr($_SESSION['tweet']['texte'], 0, 140 - strlen($url) - 4) . "...";
		} else {
			$texte = $_SESSION['tweet']['texte'];
		}
		$tweet = $texte . ' ' . $url;
		// On post le tweet
		if(TWI_LATITUDE != "0" && TWI_LONGITUDE != "0"){
			$params = array("status" => $tweet, "lat" => TWI_LATITUDE, "long" => TWI_LONGITUDE);
		} else {
			$params = array("status" => $tweet);
		}
		$p_connection->post('statuses/update', $params);
		unset($_SESSION['tweet']);
		$redirect = $_SESSION['redirect'];
		unset($_SESSION['redirect']);
		header('location: ' . $redirect);
	}

?>