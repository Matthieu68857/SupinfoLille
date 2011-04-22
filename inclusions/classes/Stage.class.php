<?php

/* Classe Stage
 * 		Permet de gerer toutes les infos d'une entreprise
 *  
 * @Attributs :
 *		$id | private | L'id du stage
 *		$description | private | La description du stage
 *		$date | private | La date du stage
 *		$fichier | private | Le fichier du stage
 *		$entreprise | private | L'entreprise du stage
 *		$BDD | private | La connexion a la BDD
 *		$newEntry | private | Si le stage est nouveau ou non
 *
 * @Methodes :
 *		__construct() | public | Initialise les attributs lors de la creation d'un objet
 *			@Parametres : $id = "0", $getInfos = true, $description = "", $date = "", $fichier = "", $entreprise = ""
 *		save() | public | Enregister le stage dans la BDD
 *		delete() | public | Supprime le stage de la BDD
 *		compareTo() | public | Compare deux stages
 *			@Parametres : $s
 *			@Retour : True (Même stage) sinon False
 *
 */
 
class Stage {

/* ########## Attributs ########## */

	private $id = 0;
	private $description;
	private $date;
	private $fichier;
	private $entreprise = 0;
	private $BDD;
	private $newEntry = 1;

/* ########## Constructeur ########## */

	public function __construct($BDD, $id = "0", $getInfos = true, $description = "", $date = "", $fichier = "", $entreprise = ""){
		$this->BDD = $BDD;
		if($id != 0 && $getInfos){
			$stage = $this->BDD->select(
				"*",
				"SBN_STAGES",
				"WHERE stage_id = :id", 
				array("id" => $id)
			);
			$stage = $stage[0];
			$this->id = StringOperation::operation($id, true);
			$this->description = StringOperation::operation($stage->stage_description, true);
			$this->date = StringOperation::operation($stage->stage_date, true);
			$this->fichier = StringOperation::operation($stage->stage_fichier, true);
			$this->entreprise = StringOperation::operation($stage->stage_entreprise, true);
			$this->newEntry = 0;
		} else if($id != 0){
			$this->id = StringOperation::operation($id, true);
			$this->description = StringOperation::operation($description, true);
			$this->date = StringOperation::operation($date, true);
			$this->fichier = StringOperation::operation($fichier, true);
			$this->entreprise = StringOperation::operation($entreprise, true);
			$this->newEntry = 0;
		} else {
			$this->description = StringOperation::operation($description, true);
			if($date == ""){
				$this->date = date("Ymd");
			} else {
				$this->date = StringOperation::operation($date, true);
			}
			$this->fichier = StringOperation::operation($fichier, true);
			$this->entreprise = StringOperation::operation($entreprise, true);
		}
	}

/* ########## Sauvegarder ########## */

	public function save(){
		if($this->entreprise != 0){
			if($this->newEntry){
				$this->BDD->insert(
					"SBN_STAGES",
					array("stage_description", "stage_date", "stage_fichier", "stage_entreprise"),
					array(":description", ":date", ":fichier", ":entreprise"),
					array("description" => $this->description, "date" => $this->date, "fichier" => $this->fichier, "entreprise" => $this->entreprise)
				);
			} else {
				$this->BDD->update(
					"SBN_STAGES",
					array("stage_description = :description", "stage_date = :date", "stage_fichier = :fichier", "stage_entreprise = :entreprise"),
					"stage_id = :id",
					array("description" => $this->description, "date" => $this->date, "fichier" => $this->fichier, "entreprise" => $this->entreprise, "id" => $this->id)
				);
			}
		}
		
	}

/* ########## Supprimer ########## */

	public function delete(){
		if($this->id != 0){
			$this->BDD->delete(
				"SBN_STAGES",
				"stage_id = :id",
				array("id" => $this->id)
			);
			if($this->fichier != ""){
				exec("rm ../../sbn/fichiers/" . $this->fichier);
			}
		}
	}
	
/* ########## Comparer ########## */

	public function compareTo($s){
		$same = true;
		if($this->description != $s->getDescription()){
			$same = false;
		}
		if($this->date != $s->getTheDate()){
			$same = false;
		}
		if($this->fichier != $s->getFichier()){
			$same = false;
		}
		if($this->entreprise != $s->getEntreprise()){
			$same = false;
		}
		return $same;
	}
	
/* ########## Getters et Setters ########## */
	
	public function getId(){ return $this->id; }
	public function getDescription(){ return $this->description; }
	public function getTheDate(){ return $this->date; }
	public function getFichier(){ return $this->fichier; }
	public function getEntreprise(){ return $this->entreprise; }
	public function setId($p){ $this->id = StringOperation::noBackslash($p); }
	public function setDescription($p){ $this->description = StringOperation::noBackslash($p); }
	public function setDate($p){ $this->date = StringOperation::noBackslash($p); }
	public function setFichier($p){ $this->fichier = StringOperation::noBackslash($p); }
	public function setEntreprise($p){ $this->entreprise = StringOperation::noBackslash($p); }
	
}

?>