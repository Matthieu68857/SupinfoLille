<?php

/* SupinfoLille20103.fr - Classe Student
 * 		Permet de créer un student avec toutes ses infos
 *  
 * @Attributs :
 *		$sgbd | private | type de SGBD (mysql, oracle, etc...)
 *		$idBooster | private | ID Booster
 *	 	$promo | private | Promotion (B1 | B2 | B3 | M1 | M2)
 *	 	$pass | private | Mot de passe en MD5
 *	 	$prenom | private | Prenom
 *	 	$nom | private | Nom
 *	 	$portable | private | numero de portable 
 *	 	$msn | private | identifiant MSN
 *	 	$skype | private | identifiant Skype
 *	 	$twitter | private | compte Twitter
 *	 	$facebook | private | compte Facebook
 *	 	$autorisation | private | Booleen pour l'acces au site (0=Bloque | 1=Student | 2=Admin)
 *	 	$visites | private | Nombre de visite
 *	 	$derniere_visite | private | Date de la derniere visite
 *
 * @Methodes :
 *		__construct() | public | initialise les attributs lors de la creation d'un objet
 *
 */

class Student
{

/* ************ Attributs ************ */

	private $BDD;

	private $idBooster;
	private $promo;
	private $pass;
	private $prenom;
	private $nom;
	private $portable;
	private $msn;
	private $skype;
	private $twitter;
	private $facebook;
	private $visites;
	private $derniere_visite;
	private $soldeCafeteria;
	
	private $persiste;
	
/* ************ __construct() ************ */
	
	public function __construct($p_idBooster){
	
		$this->idBooster = $p_idBooster;
		
		$this->BDD = new BDD();
		
		$student = $this->BDD->select(
			"student_promo, student_pass, student_prenom, student_nom, student_portable, student_msn, student_skype, student_twitter, student_facebook, student_visites, DATE_FORMAT(student_derniere_visite,'Le %d/%m/%y') AS sdt_derniere_visite, student_solde_cafeteria",
			"TB_STUDENTS",
			"WHERE student_idbooster = ?",
			array($this->idBooster)
		);
		
		if(count($student)==0){
		
			$this->persiste = false;
			
		} else {
		
			$this->persiste = true;
		
			$this->promo = $student[0]->student_promo;
			$this->pass = $student[0]->student_pass;
			$this->prenom = $student[0]->student_prenom;
			$this->nom = $student[0]->student_nom;
			$this->portable = $student[0]->student_portable;
			$this->msn = $student[0]->student_msn;
			$this->skype = $student[0]->student_skype;
			$this->twitter = $student[0]->student_twitter;
			$this->facebook = $student[0]->student_facebook;
			$this->visites = $student[0]->student_visites;
			$this->derniere_visite = $student[0]->sdt_derniere_visite;
			$this->soldeCafeteria = $student[0]->student_solde_cafeteria;
		
		}
		
	}
	
/* ************ sauvegarder() ************ */

	public function sauvegarder(){
	
		if($this->persiste == true){
			$date = explode("/", preg_replace("#Le #", "", $this->derniere_visite));
			$dateMySQL = $date[2] . "-" . $date[1] . "-" . $date[0];
			
			$this->BDD->update(
				"TB_STUDENTS",
				array(
					"student_promo = ?",
					"student_pass = ?",
					"student_prenom = ?",
					"student_nom = ?",
					"student_portable = ?",
					"student_msn = ?",
					"student_skype = ?",
					"student_twitter = ?",
					"student_facebook = ?",
					"student_visites = ?",
					"student_derniere_visite = ?",
					"student_solde_cafeteria = ?"
				),
				"student_idbooster = ?",
				array(
					$this->promo,
					$this->pass,
					$this->prenom,
					$this->nom,
					$this->portable,
					$this->msn,
					$this->skype,
					$this->twitter,
					$this->facebook,
					$this->visites,
					$dateMySQL,
					$this->soldeCafeteria,
					$this->idBooster
				)
			);
		
		} else {
			
			$this->BDD->insert(
				"TB_STUDENTS",
				array(
					"student_idbooster",
					"student_promo",
					"student_pass",
					"student_prenom",
					"student_nom",
					"student_portable",
					"student_msn",
					"student_skype",
					"student_twitter",
					"student_facebook",
					"student_visites",
					"student_derniere_visite",
					"student_solde_cafeteria"
				),
				array("?","?","?","?","?","?","?","?","?","?","?","?","?"),
				array(
					$this->idBooster,
					$this->promo,
					$this->pass,
					$this->prenom,
					$this->nom,
					$this->portable,
					$this->msn,
					$this->skype,
					$this->twitter,
					$this->facebook,
					$this->visites,
					$this->derniere_visite,
					$this->soldeCafeteria
				)
			);
			
			$this->persiste = true;
		
		}
	
	}
	
/* ************ Getters + Setters ************ */

	public function getIdBooster() { return $this->idBooster; } 
	public function getPromo() { return $this->promo; } 
	public function getPass() { return $this->pass; } 
	public function getPrenom() { return $this->prenom; } 
	public function getNom() { return $this->nom; } 
	public function getPortable() { return $this->portable; } 
	public function getMsn() { return $this->msn; } 
	public function getSkype() { return $this->skype; } 
	public function getTwitter() { return $this->twitter; } 
	public function getFacebook() { return $this->facebook; } 
	public function getAutorisation() { return $this->autorisation; } 
	public function getVisites() { return $this->visites; } 
	public function getDerniere_visite() { return $this->derniere_visite; } 
	public function getSoldeCafeteria() { return $this->soldeCafeteria; } 
	public function setIdBooster($x) { $this->idBooster = $x; } 
	public function setPromo($x) { $this->promo = $x; } 
	public function setPass($x) { $this->pass = $x; } 
	public function setPrenom($x) { $this->prenom = $x; } 
	public function setNom($x) { $this->nom = $x; } 
	public function setPortable($x) { $this->portable = $x; } 
	public function setMsn($x) { $this->msn = $x; } 
	public function setSkype($x) { $this->skype = $x; } 
	public function setTwitter($x) { $this->twitter = $x; } 
	public function setFacebook($x) { $this->facebook = $x; } 
	public function setAutorisation($x) { $this->autorisation = $x; } 
	public function setVisites($x) { $this->visites = $x; } 
	public function setDerniere_visite($x) { $this->derniere_visite = $x; }
	public function setSoldeCafeteria($x) { $this->soldeCafeteria = $x; }
		
}

?>