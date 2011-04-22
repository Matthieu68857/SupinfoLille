<?php

/* Classe Entreprise
 * 		Permet de gerer toutes les infos d'une entreprise
 *  
 * @Attributs :
 *		$id | private | L'id de l'entreprise
 *		$nom | private | Le nom de l'entreprise
 *		$adresse | private | L'adresse de l'entreprise
 *		$cp | private | Le code postal de l'entreprise
 *		$ville | private | La ville de l'entreprise
 *		$site | private | Le site de l'entreprise
 *		$thematique | private | La thematique de l'entreprise
 *		$infos | private | Les infos de l'entreprise
 *		$BDD | private | La connexion a la BDD
 *		$newEntry | private | Si l'entreprise est nouvelle ou non
 *
 * @Methodes :
 *		__construct() | public | Initialise les attributs lors de la creation d'un objet
 *			$Parametres : $id = "0", $nom = "", $adresse = "", $cp = "", $ville = "", $site = "", $thematique = "", $infos = ""
 *		save() | public | Enregister l'entreprise dans la BDD
 *		delete() | public | Supprime l'entreprise de la BDD
 *		compareTo() | public | Compare le nom et la ville de deux entreprises
 *			@Parametres : $e
 *			@Retour : True (Nom et ville pareil) sinon False
 *		fusionWith() | public | Fusionne deux entreprises
 *			@Parametres : $e
 *		creerContact() | public | Cree un contact pour l'entreprise
 *			@Parametres : $nom = "", $role = "", $telephone = "", $fax = "", $email = ""
 *		creerStage() | public | Cree un stage pour l'entreprise
 *			@Parametres : $description = "", $date = "", $fichier = ""
 *		modifierContact() | public | Modifie un contact de l'entreprise
 *			@Parametres : $id, $nom = "", $role = "", $telephone = "", $fax = "", $email = ""
 *		modifierStage() | public | Modifie un stage de l'entreprise
 *			@Parametres : $id, $description = "", $date = "", $fichier = ""
 *		supprimerContact() | public | Supprime un contact de l'entreprise
 *			@Parametres : $id
 *		supprimerStage() | public | Supprime un stage de l'entreprise
 *			@Parametres : $id
 *		getContacts() | public | Donne tous les contacts de l'entreprise
 *			@Retour : Tableau de Contact
 *		getStages() | public | Donne tous les stages de l'entreprise
 *			@Retour : Tableau de Stages
 *		isDoublon() | public | Regarde si l'entreprise est dans la table SBN_DOUBLONS
 *			@Retour : True (Entreprise dans la table) sinon False
 *		setDoublon() | public | Entre l'entreprise dans la table SBN_DOUBLONS
 *		fillEmpty() | private | Remplis les champs vide avec NON RENSEIGNE
 *		applyStyle() | private | Applique le style voulu aux variables
 *
 */
 
class Entreprise {

/* ########## Attributs ########## */

	private $id = 0;
	private $nom;
	private $adresse;
	private $cp;
	private $ville;
	private $site;
	private $thematique;
	private $infos;
	private $BDD;
	private $newEntry = 1;

/* ########## Constructeur ########## */

	public function __construct($BDD, $id = "0", $nom = "", $adresse = "", $cp = "", $ville = "", $site = "", $thematique = "", $infos = ""){
		$this->BDD = $BDD;
		if($id != 0 && $nom == ""){
			$entreprises = $this->BDD->select(
				"*",
				"SBN_ENTREPRISES",
				"WHERE entreprise_id = :id", 
				array("id" => $id)
			);
			$entreprises = $entreprises[0];
			$this->id = $id;
			$this->nom = $entreprises->entreprise_nom;
			$this->adresse = $entreprises->entreprise_adresse;
			$this->cp = $entreprises->entreprise_cp;
			$this->ville = $entreprises->entreprise_ville;
			$this->site = $entreprises->entreprise_site;
			$this->thematique = $entreprises->entreprise_thematique;
			$this->infos = $entreprises->entreprise_infos;
			$this->newEntry = 0;
		} else if($id != 0 && $nom != ""){
			$this->id = $id;
			$this->nom = $nom;
			$this->adresse = $adresse;
			$this->cp = $cp;
			$this->ville = $ville;
			$this->site = $site;
			$this->thematique = $thematique;
			$this->infos = $infos;
			$this->newEntry = 0;
		} else {
			$this->nom = $nom;
			$this->adresse = $adresse;
			$this->cp = $cp;
			$this->ville = $ville;
			$this->site = $site;
			$this->thematique = $thematique;
			$this->infos = $infos;
		}
	}

/* ########## Sauvegarder ########## */

	public function save(){
		if($this->nom != ""){
			$this->fillEmpty();
			$this->applyStyle();
			if($this->newEntry){
				$this->BDD->insert(
					"SBN_ENTREPRISES",
					array(
						"entreprise_nom", 
						"entreprise_adresse", 
						"entreprise_cp", 
						"entreprise_ville", 
						"entreprise_site", 
						"entreprise_thematique", 
						"entreprise_infos"
					),
					array(
						":nom", 
						":adresse", 
						":cp", 
						":ville", 
						":site", 
						":thematique", 
						":infos"
					),
					array(
						"nom" => $this->nom, 
						"adresse" => $this->adresse, 
						"cp" => $this->cp, 
						"ville" => $this->ville, 
						"site" => $this->site, 
						"thematique" => $this->thematique, 
						"infos" => $this->infos
					)
				);
				$result = 
				$this->BDD->select(
					"entreprise_id",
					"SBN_ENTREPRISES",
					"WHERE ".
						"entreprise_nom = :nom AND ".
						"entreprise_adresse = :adresse AND ".
						"entreprise_cp = :cp AND ".
						"entreprise_ville = :ville AND ".
						"entreprise_site = :site AND ".
						"entreprise_thematique = :thematique AND ".
						"entreprise_infos = :infos",
					array(
						"nom" => $this->nom, 
						"adresse" => $this->adresse, 
						"cp" => $this->cp, 
						"ville" => $this->ville, 
						"site" => $this->site, 
						"thematique" => $this->thematique, 
						"infos" => $this->infos
					)
				);
				$this->id = $result[0]->entreprise_id;
				$this->newEntry = 0;
			} else {
				$this->BDD->update(
					"SBN_ENTREPRISES",
					array(
						"entreprise_nom = :nom", 
						"entreprise_adresse = :adresse", 
						"entreprise_cp = :cp", 
						"entreprise_ville = :ville", 
						"entreprise_site = :site", 
						"entreprise_thematique = :thematique", 
						"entreprise_infos = :infos"
					),
					"entreprise_id = :id",
					array(
						"nom" => $this->nom, 
						"adresse" => $this->adresse, 
						"cp" => $this->cp, 
						"ville" => $this->ville, 
						"site" => $this->site, 
						"thematique" => $this->thematique, 
						"infos" => $this->infos, 
						"id" => $this->id
					)
				);
			}
		}
	}

/* ########## Supprimer ########## */

	public function delete(){
		if($this->id != 0){
			$this->BDD->delete(
				"SBN_ENTREPRISES",
				"entreprise_id = :id",
				array("id" => $this->id)
			);
			$this->BDD->delete(
				"SBN_STAGES",
				"stage_entreprise = :id",
				array("id" => $this->id)
			);
			$this->BDD->delete(
				"SBN_CONTACTS",
				"contact_entreprise = :id",
				array("id" => $this->id)
			);
			$this->BDD->delete(
				"SBN_DOUBLONS",
				"doublon_entreprise = :id",
				array("id" => $this->id)
			);
		}
	}
	
/* ########## Comparer ########## */

	public function compareTo($e){
		$same = true;
		$temp = $e->getNom();
		if(strtolower($this->nom) != strtolower($temp) || empty($this->nom) || empty($temp)){
			$same = false;
		}
		$temp = $e->getVille();
		if(strtolower($this->ville) != strtolower($temp) && !empty($this->ville) && !empty($temp)){
			$same = false;
		}
		return $same;
	}
	
/* ########## Fusion ########## */

	public function fusionWith($e){
		
		$temp = $e->getAdresse();
		if(
			strtolower($this->adresse) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->adresse) && 
			!empty($temp)))
		){
			$e->setAdresse($this->adresse);
		}
		
		$temp = $e->getCP();
		if(
			strtolower($this->cp) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->cp) && 
			!empty($temp)))
		){
			$e->setCP($this->cp);
		}
		
		$temp = $e->getVille();
		if(
			strtolower($this->ville) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->ville) && 
			!empty($temp)))
		){
			$e->setVille($this->ville);
		}
		
		$temp = $e->getSite();
		if(
			strtolower($this->site) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->site) && 
			!empty($temp)))
		){
			$e->setSite($this->site);
		}
		
		$temp = $e->getThematique();
		if(
			strtolower($this->thematique) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->thematique) && 
			!empty($temp)))
		){
			$e->setThematique($this->thematique);
		}
		
		$temp = $e->getInfos();
		if(
			strtolower($this->infos) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->infos) && 
			!empty($temp)))
		){
			$e->setInfos($this->infos);
		}
		
		$e->save();
		
	}
	
/* ########## FillEmpty ########## */

	private function fillEmpty(){
		if(empty($this->adresse)){
			$this->adresse = "NON RENSEIGNE";
		}
		
		if(empty($this->cp)){
			$this->cp = "NON RENSEIGNE";
		}
		
		if(empty($this->ville)){
			$this->ville = "NON RENSEIGNE";
		}
		
		if(empty($this->site)){
			$this->site = "NON RENSEIGNE";
		}
		
		if(empty($this->thematique)){
			$this->thematique = "NON RENSEIGNE";
		}
	}
	
/* ########## ApplyStyle ########## */

	private function applyStyle(){
		$this->id = StringOperation::operation($this->id, true);
		$this->nom = StringOperation::operation($this->nom, true, true);
		$this->adresse = StringOperation::operation($this->adresse, true, true);
		$this->cp = StringOperation::operation($this->cp, true);
		$this->ville = StringOperation::operation($this->ville, true, true);
		$this->site = StringOperation::operation($this->site, true, false, true);
		$this->thematique = StringOperation::operation($this->thematique, true, true, false, true);
		$this->infos = StringOperation::operation($this->infos, true, false, false, false, true);
	}
	
/* ########## Creer contact ########## */

	public function creerContact($nom = "", $role = "", $telephone = "", $fax = "", $email = ""){
		$contact = new Contact($this->BDD, "0", false, $nom, $role, $telephone, $fax, $email, $this->id);
		$contact->save();
	}
	
/* ########## Creer stage ########## */

	public function creerStage($description = "", $date = "", $fichier = ""){
		$stage = new Stage($this->BDD, "0", false, $description, $date, $fichier, $this->id);
		$stage->save();
	}

/* ########## Modifier contact ########## */

	public function modifierContact($id, $nom = "", $role = "", $telephone = "", $fax = "", $email = ""){
		if($id != 0){
			$contact = new Contact($this->BDD, $id, false, $nom, $role, $telephone, $fax, $email, $this->id);
			$contact->save();
		}
	}
	
/* ########## Modifier stage ########## */

	public function modifierStage($id, $description = "", $date = "", $fichier = ""){
		if($id != 0){
			$stage = new Stage($this->BDD, $id, true);
			if(!empty($description)){
				$stage->setDescription($description);
			}
			if(!empty($date)){
				$stage->setDate($date);
			}
			if(!empty($fichier)){
				$stage->setFichier($fichier);
			}
			$stage->save();
		}
	}
	
/* ########## Supprimer contact ########## */

	public function supprimerContact($id){
		if($id != 0){
			$contact = new Contact($this->BDD, $id);
			$contact->delete();
		}
	}
	
/* ########## Supprimer stage ########## */

	public function supprimerStage($id){
		if($id != 0){
			$stage = new Stage($this->BDD, $id);
			$stage->delete();
		}
	}
	
/* ########## Get Contacts ########## */

	public function getContacts(){
		$contactsReq = $this->BDD->select(
			"*",
			"SBN_CONTACTS",
			"WHERE contact_entreprise = :id", 
			array("id" => $this->id)
		);
		$contacts = array();
		foreach($contactsReq as $contact){
			$c = new Contact(
					$this->BDD, 
					$contact->contact_id, 
					false, 
					$contact->contact_nom, 
					$contact->contact_role, 
					$contact->contact_telephone, 
					$contact->contact_fax, 
					$contact->contact_email, 
					$contact->contact_entreprise
				);
			array_push($contacts, $c);
		}
		return $contacts;
	}
	
/* ########## Get Stages ########## */

	public function getStages(){
		$stagesReq = $this->BDD->select(
			"*",
			"SBN_STAGES",
			"WHERE stage_entreprise = :id", 
			array("id" => $this->id)
		);
		$stages = array();
		foreach($stagesReq as $stage){
			$s = new Stage(
					$this->BDD, 
					$stage->stage_id, 
					false, 
					$stage->stage_description, 
					$stage->stage_date, 
					$stage->stage_fichier, 
					$stage->stage_entreprise
				);
			array_push($stages, $s);
		}
		return $stages;
	}
	
/* ########## is Doublon ########## */

	public function isDoublon(){
		$doublon = $this->BDD->select(
			"*",
			"SBN_DOUBLONS",
			"WHERE doublon_entreprise = :id", 
			array("id" => $this->id)
		);
		if(empty($doublon)){
			return false;
		} else {
			return true;
		}
	}
	
/* ########## set Doublon ########## */

	public function setDoublon(){
		$this->BDD->insert(
			"SBN_DOUBLONS",
			array("doublon_entreprise"),
			array(":id"), 
			array("id" => $this->id)
		);
	}

/* ########## Getters et Setters ########## */
	
	public function getId(){ return $this->id; }
	public function getNom(){ return $this->nom; }
	public function getAdresse(){ return $this->adresse; }
	public function getCP(){ return $this->cp; }
	public function getVille(){ return $this->ville; }
	public function getSite(){ return $this->site; }
	public function getThematique(){ return $this->thematique; }
	public function getInfos(){ return $this->infos; }
	public function setId($p){ $this->id = StringOperation::operation($p, true); }
	public function setNom($p){ $this->nom = StringOperation::operation($p, true); }
	public function setAdresse($p){ $this->adresse = StringOperation::operation($p, true, true); }
	public function setCP($p){ $this->cp = StringOperation::operation($p, true); }
	public function setVille($p){ $this->ville = StringOperation::operation($p, true, false, true); }
	public function setSite($p){ $this->site = StringOperation::operation($p, true); }
	public function setThematique($p){ $this->thematique = StringOperation::operation($p, true, false, true, true); }
	public function setInfos($p){ $this->infos = StringOperation::operation($p, true, true); }
	
}

?>