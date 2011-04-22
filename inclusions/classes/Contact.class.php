<?php

/* Classe Contact
 * 		Permet de gerer toutes les infos d'une entreprise
 *  
 * @Attributs :
 *		$id | private | L'id du contact
 *		$nom | private | Le nom du contact
 *		$role | private | Le role du contact
 *		$telephone | private | Le telephone du contact
 *		$fax | private | Le fax du contact
 *		$email | private | L'email du contact
 *		$entreprise | private | L'entreprise du contact
 *		$BDD | private | La connexion a la BDD
 *		$newEntry | private | Si le contact est nouveau ou non
 *
 * @Methodes :
 *		__construct() | public | Initialise les attributs lors de la creation d'un objet
 *			@Parametres : $id = "0", $getInfos = true, $nom = "", $role = "", $telephone = "", $fax = "", $email = "", $entreprise = ""
 *		save() | public | Enregister le contact dans la BDD
 *		delete() | public | Supprime le contact de la BDD
 *		compareTo() | public | Compare deux contacts
 *			@Parametres : $c
 *			@Retour : True (Même contact) sinon False
 *		fusionWith() | public | Fusionne deux contacts
 *			@Parametres : $c
 *		fillEmpty() | private | Remplis les champs vide avec NON RENSEIGNE
 *		applyStyle() | private | Applique le style voulu aux variables
 *
 */
 
class Contact {

/* ########## Attributs ########## */

	private $id = 0;
	private $nom;
	private $role;
	private $telephone;
	private $fax;
	private $email;
	private $entreprise = 0;
	private $BDD;
	private $newEntry = 1;

/* ########## Constructeur ########## */

	public function __construct($BDD, $id = "0", $getInfos = true, $nom = "", $role = "", $telephone = "", $fax = "", $email = "", $entreprise = ""){
		$this->BDD = $BDD;
		if($id != 0 && $getInfos){
			$contact = $this->BDD->select(
				"*",
				"SBN_CONTACTS",
				"WHERE contact_id = :id", 
				array("id" => $id)
			);
			$contact = $contact[0];
			$this->id = $id;
			$this->nom = $contact->contact_nom;
			$this->role = $contact->contact_role;
			$this->telephone = $contact->contact_telephone;
			$this->fax = $contact->contact_fax;
			$this->email = $contact->contact_email;
			$this->entreprise = $contact->contact_entreprise;
			$this->newEntry = 0;
		} else if($id != 0){
			$this->id = $id;
			$this->nom = $nom;
			$this->role = $role;
			$this->telephone = $telephone;
			$this->fax = $fax;
			$this->email = $email;
			$this->entreprise = $entreprise;
			$this->newEntry = 0;
		} else {
			$this->nom = $nom;
			$this->role = $role;
			$this->telephone = $telephone;
			$this->fax = $fax;
			$this->email = $email;
			$this->entreprise = $entreprise;
		}
	}

/* ########## Sauvegarder ########## */

	public function save(){
		if(
			$this->entreprise != "" && 
			(
				$this->nom != "" || 
				$this->role != "" || 
				$this->telephone != "" || 
				$this->fax != "" || 
				$this->email != ""
			)
		){
			$this->fillEmpty();
			$this->applyStyle();
			if($this->entreprise != 0){
				if($this->newEntry){
					$this->BDD->insert(
						"SBN_CONTACTS",
						array(
							"contact_nom", 
							"contact_role", 
							"contact_telephone", 
							"contact_fax", 
							"contact_email", 
							"contact_entreprise"
						),
						array(
							":nom", 
							":role", 
							":telephone", 
							":fax", 
							":email", 
							":entreprise"
						),
						array(
							"nom" => $this->nom, 
							"role" => $this->role, 
							"telephone" => $this->telephone, 
							"fax" => $this->fax, 
							"email" => $this->email, 
							"entreprise" => $this->entreprise
						)
					);
				} else {
					$this->BDD->update(
						"SBN_CONTACTS",
						array(
							"contact_nom = :nom", 
							"contact_role = :role", 
							"contact_telephone = :telephone", 
							"contact_fax = :fax", 
							"contact_email = :email", 
							"contact_entreprise = :entreprise"
						),
						"contact_id = :id",
						array(
							"nom" => $this->nom, 
							"role" => $this->role, 
							"telephone" => $this->telephone, 
							"fax" => $this->fax, 
							"email" => $this->email, 
							"entreprise" => $this->entreprise, 
							"id" => $this->id
						)
					);
				}
			}
		}
	}

/* ########## Supprimer ########## */

	public function delete(){
		if($this->id != 0){
			$this->BDD->delete(
				"SBN_CONTACTS",
				"contact_id = :id",
				array("id" => $this->id)
			);
		}
	}

/* ########## Comparer ########## */

	public function compareTo($c){
		$same = true;
		
		$temp = $c->getNom();
		if(
			strtolower($this->nom) != strtolower($temp) && 
			!empty($this->nom) && 
			!empty($temp)
		){
			$same = false;
		}
		
		$temp = $c->getRole();
		if(
			strtolower($this->role) != strtolower($temp) && 
			!empty($this->role) && 
			!empty($temp)
		){
			$same = false;
		}
		
		$temp = $c->getTelephone();
		if(
			strtolower($this->telephone) != strtolower($temp) && 
			!empty($this->telephone) && 
			!empty($temp)
		){
			$same = false;
		}
		
		$temp = $c->getFax();
		if(
			strtolower($this->fax) != strtolower($temp) && 
			!empty($this->fax) && 
			!empty($temp)
		){
			$same = false;
		}
		
		$temp = $c->getEmail();
		if(
			strtolower($this->email) != strtolower($temp) && 
			!empty($this->email) && 
			!empty($temp)
		){
			$same = false;
		}
		
		$temp = $c->getEntreprise();
		if(
			strtolower($this->entreprise) != strtolower($temp) && 
			!empty($this->entreprise) && 
			!empty($temp)
		){
			$same = false;
		}
		return $same;
	}
	
/* ########## Fusion ########## */

	public function fusionWith($c){
		
		$temp = $c->getNom();
		if(
			strtolower($this->nom) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->nom) && 
			!empty($temp)))
		){
			$c->setNom($this->nom);
		}
		
		$temp = $c->getRole();
		if(
			strtolower($this->role) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->role) && 
			!empty($temp)))
		){
			$c->setRole($this->role);
		}
		
		$temp = $c->getTelephone();
		if(
			strtolower($this->telephone) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->telephone) && 
			!empty($temp)))
		){
			$c->setTelephone($this->telephone);
		}
		
		$temp = $c->getFax();
		if(
			strtolower($this->fax) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->fax) && 
			!empty($temp)))
		){
			$c->setFax($this->fax);
		}
		
		$temp = $c->getEmail();
		if(
			strtolower($this->email) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->email) && 
			!empty($temp)))
		){
			$c->setEmail($this->email);
		}
		
		$temp = $c->getEntreprise();
		if(
			strtolower($this->entreprise) != strtolower($temp) && 
			(empty($temp) ||
			(!empty($this->entreprise) && 
			!empty($temp)))
		){
			$c->setEntreprise($this->entreprise);
		}
		
		$c->save();
		
	}
	
/* ########## FillEmpty ########## */

	public function fillEmpty(){
		if(empty($this->nom)){
			$this->nom = "NON RENSEIGNE";
		}
		
		if(empty($this->role)){
			$this->role = "NON RENSEIGNE";
		}
		
		if(empty($this->telephone)){
			$this->telephone = "NON RENSEIGNE";
		}
		
		if(empty($this->fax)){
			$this->fax = "NON RENSEIGNE";
		}
		
		if(empty($this->email)){
			$this->email = "NON RENSEIGNE";
		}
	}
	
/* ########## ApplyStyle ########## */

	private function applyStyle(){
		$this->id = StringOperation::operation($this->id, true);
		$this->nom = StringOperation::operation($this->nom, true, true);
		$this->role = StringOperation::operation($this->role, true, true);
		$this->telephone = StringOperation::operation($this->telephone, true);
		$this->fax = StringOperation::operation($this->fax, true);
		$this->email = StringOperation::operation($this->email, true, false, true);
		$this->entreprise = StringOperation::operation($this->entreprise, true);
	}
	
/* ########## Getters et Setters ########## */
	
	public function getId(){ return $this->id; }
	public function getNom(){ return $this->nom; }
	public function getRole(){ return $this->role; }
	public function getTelephone(){ return $this->telephone; }
	public function getFax(){ return $this->fax; }
	public function getEmail(){ return $this->email; }
	public function getEntreprise(){ return $this->entreprise; }
	public function setId($p){ $this->id = StringOperation::noBackslash($p); }
	public function setNom($p){ $this->nom = StringOperation::noBackslash($p); }
	public function setRole($p){ $this->role = StringOperation::noBackslash($p); }
	public function setTelephone($p){ $this->telephone = StringOperation::noBackslash($p); }
	public function setFax($p){ $this->fax = StringOperation::noBackslash($p); }
	public function setEmail($p){ $this->email = StringOperation::noBackslash($p); }
	public function setEntreprise($p){ $this->entreprise = StringOperation::noBackslash($p); }
	
}

?>