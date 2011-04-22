<?php

/* SupinfoLille20103.fr - Classe BDD
 * 		Permet toutes les operations concernant la BDD
 * 		connexion, select, delete, update, etc...
 *  
 * @Attributs :
 *		$sgbd | private | type de SGBD (mysql, oracle, etc...)
 *		$hote | private | adresse IP ou nom de domaine du serveur 
 *		$port | private | port d'ecoute du SGBD
 *		$nom_bdd | private | nom de la BDD a ouvrir
 *		$identifiant | private | identifiant de connexion
 *		$mot_de_passe | private | mot de passe de connexion
 *		$connexion | private | enregistre la connexion à la BDD
 *
 * @Methodes :
 *		__construct() | public | initialise les attributs lors de la creation d'un objet
 *		connexion() | private | demarre une connexion à la BDD
 *		select() | public | execute les requetes passees en arguments
 *		insert() | public |	execute les requetes passees en arguments
 *		update() | public |	execute les requetes passees en arguments
 *		delete() | public |	execute les requetes passees en arguments
 *		getEvents() | public | va chercher tous les evenements dans webcal_entry et les renvoit dans un tableau
 *		searchEventsByName($name) | public | recherche la liste des evenements correspondant a $name
 *
 */

class BDD
{

/* ************ Attributs ************ */

	private $sgbd;
	private $hote;
	private $port;
	private $nom_bdd; 
	private $identifiant; 
	private $mot_de_passe;
	private $connexion;
	public  $nbReq = 0;
	
/* ************ __construct() ************ */
	
	public function __construct(){
		$this->sgbd = BDD_SGBD;
		$this->hote = BDD_SERVEUR;
		$this->port = BDD_PORT;
		$this->nom_bdd = BDD_NOM;
		$this->identifiant = BDD_IDENTIFIANT;
		$this->mot_de_passe = BDD_MOTDEPASSE;
		$this->connexion();
	}
	
/* ************ connexion() ************ */

	private function connexion(){
		$this->connexion = 
		new PDO("mysql:host=".$this->hote."; dbname=".$this->nom_bdd, $this->identifiant, $this->mot_de_passe);
	}
	
/* ************ select() ************
 * 
 * Execute une requete SELECT et retourne le resultat.
 * 
 * @param string	Le SELECT de la requete a executer.
 * @param string	Le FROM de la requete a executer.
 * @param string	La fin de la requete a executer (WHERE, GROUP BY, ORDER BY, etc...).
 * @param array		Tableau qui contient les variables a remplacer dans le requete.
 * 
 * @return array	Un tableau avec le resultat de la requete.
 */
 
	public function select($select, $from, $end = "", $arg = ""){		
		$objectArray = array();
		
		$sql = "SELECT " . $select . " FROM " . $from . " " . $end;
		
		//echo $sql;
																								
		$req = $this->connexion->prepare($sql);
		if(!empty($arg)){
			$req->execute($arg);
		} else {
			$req->execute();
		}
			
		$req->setFetchMode(PDO::FETCH_OBJ); 
		while($res = $req->fetch()) 
		{
			array_push($objectArray, $res);
		}
		$req->closeCursor();
		
		return $objectArray;
	}

/* ************ insert() ************
 * 
 * Execute une requete INSERT et retourne le resultat.
 * 
 * @param string	La table ou il faut ajouter les donnees.
 * @param array		Les colonnes ou il faut ajouter les donnees.
 * @param array		Les valeurs associe aux colonnes.
 * @param array		Tableau qui contient les variables a remplacer dans le requete.
 * 
 * @return array	Un tableau avec le resultat de la requete.
 */
 
	public function insert($table, $columns, $values, $arg = ""){		
		$objectArray = array();
		
		$cols = "";
		foreach($columns as $column){
			if($cols == ""){
				$cols = '('.$column.'';
			} else {
				$cols .= ','.$column.'';
			}
		}
		$cols .= ")";
		
		$vals = "";
		foreach($values as $value){
			if($vals == ""){
				$vals = '('.$value.'';
			} else {
				$vals .= ','.$value.'';
			}
		}
		$vals .= ")";
		
		$sql = 'INSERT INTO ' . $table . ' ' . $cols . ' VALUES ' . $vals;
												
		$req = $this->connexion->prepare($sql);
		if(!empty($arg)){
			$req->execute($arg);
		} else {
			$req->execute();
		}
					
		$req->setFetchMode(PDO::FETCH_OBJ); 
		while($res = $req->fetch()) 
		{
			array_push($objectArray, $res);
		}
		$req->closeCursor();
		
		return $objectArray;
	}
	
/* ************ update() ************
 * 
 * Execute une requete UPDATE et retourne le resultat.
 * 
 * @param string	La table ou il faut ajouter les donnees.
 * @param array		Le champ SET de la requete a executer.
 * @param string	La condition de l'update (WHERE).
 * @param array		Tableau qui contient les variables a remplacer dans le requete.
 * 
 * @return array	Un tableau avec le resultat de la requete.
 */
 
	public function update($table, $set, $where, $arg = ""){		
		$objectArray = array();
		
		$cols = "";
		foreach($set as $column){
			if($cols == ""){
				$cols = $column;
			} else {
				$cols .= ','.$column;
			}
		}
		
		$sql = 'UPDATE ' . $table . ' SET ' . $cols . ' WHERE ' . $where;
																
		$req = $this->connexion->prepare($sql);
		if(!empty($arg)){
			$req->execute($arg);
		} else {
			$req->execute();
		}
			
		$req->setFetchMode(PDO::FETCH_OBJ); 
		while($res = $req->fetch()) 
		{
			array_push($objectArray, $res);
		}
		$req->closeCursor();
		
		return $objectArray;
	}
	
/* ************ delete() ************
 * 
 * Execute une requete DELETE et retourne le resultat.
 * 
 * @param string	La table ou il faut supprimer les donnees.
 * @param string	La condition de suppression (WHERE).
 * @param array		Tableau qui contient les variables a remplacer dans le requete.
 * 
 * @return array	Un tableau avec le resultat de la requete.
 */
 
	public function delete($table, $where, $arg = ""){		
		$objectArray = array();
		
		$sql = 'DELETE FROM ' . $table . ' WHERE ' . $where;
												
		$req = $this->connexion->prepare($sql);
		if(!empty($arg)){
			$req->execute($arg);
		} else {
			$req->execute();
		}
			
		$req->setFetchMode(PDO::FETCH_OBJ); 
		while($res = $req->fetch()) 
		{
			array_push($objectArray, $res);
		}
		$req->closeCursor();
		
		return $objectArray;
	}
	
/* ************ callStoredProcedure() ************
 * 
 * Execute une procedure stockee et retourne le resultat.
 * 
 * @param string	La procedure
 * @param array		Tableau qui contient les variables a remplacer dans le requete.
 * 
 * @return array	Un tableau avec le resultat de la requete.
 */
	
	public function callStoredProcedure($p_procedure, $args = ""){
	
		$objectArray = array();
		
		if(!empty($args)){
			$vals = "";
			foreach($args as $arg){
				if($vals == ""){
					$vals = '("'.$arg.'"';
				} else {
					$vals .= ',"'.$arg.'"';
				}
			}
			$vals .= ")";
		}
		
		$sql = 'CALL ' . $p_procedure . $vals;
						
		$req = $this->connexion->prepare($sql);
		$req->execute();
		
		$req->setFetchMode(PDO::FETCH_OBJ); 
		while($res = $req->fetch()) 
		{
			array_push($objectArray, $res);
		}
		$req->closeCursor();
		
		return $objectArray;
	
	}
	
}

?>