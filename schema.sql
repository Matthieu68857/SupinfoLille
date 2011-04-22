SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_STUDENTS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_STUDENTS` (
  `student_idbooster` INT NOT NULL ,
  `student_pass` VARCHAR(100) NOT NULL ,
  `student_promo` CHAR(2) NOT NULL ,
  `student_prenom` VARCHAR(25) NOT NULL ,
  `student_nom` VARCHAR(25) NOT NULL ,
  `student_portable` CHAR(10) NULL DEFAULT NULL ,
  `student_msn` VARCHAR(100) NULL DEFAULT NULL ,
  `student_skype` VARCHAR(100) NULL DEFAULT NULL ,
  `student_twitter` VARCHAR(100) NULL DEFAULT NULL ,
  `student_facebook` VARCHAR(100) NULL DEFAULT NULL ,
  `student_visites` INT NOT NULL DEFAULT 0 ,
  `student_derniere_visite` DATETIME NOT NULL DEFAULT NULL ,
  `student_sondage_reponses` TEXT NULL DEFAULT NULL ,
  `student_solde_cafeteria` DECIMAL(10,2) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`student_idbooster`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_NEWS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_NEWS` (
  `news_id` INT NOT NULL AUTO_INCREMENT ,
  `news_auteur` INT NOT NULL ,
  `news_titre` VARCHAR(200) NOT NULL ,
  `news_contenu` TEXT NOT NULL ,
  `news_date` DATE NOT NULL ,
  PRIMARY KEY (`news_id`) ,
  INDEX `fk_TB_NEWS_TB_STUDENTS` (`news_auteur` ASC) ,
  CONSTRAINT `fk_TB_NEWS_TB_STUDENTS`
    FOREIGN KEY (`news_auteur` )
    REFERENCES `TB_STUDENTS` (`student_idbooster` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_CONNECTES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_CONNECTES` (
  `student_idbooster` INT NOT NULL ,
  `connecte_ip` VARCHAR(15) NOT NULL ,
  `connecte_timestamp` TIMESTAMP NOT NULL ,
  `connecte_notification` TIMESTAMP NOT NULL ,
  CONSTRAINT `fk_TB_CONNECTES_TB_STUDENTS1`
    FOREIGN KEY (`student_idbooster` )
    REFERENCES `TB_STUDENTS` (`student_idbooster` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_CAFETERIA_PRODUITS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_CAFETERIA_PRODUITS` (
  `produit_id` INT NOT NULL AUTO_INCREMENT ,
  `produit_nom` VARCHAR(45) NOT NULL ,
  `produit_prix` DECIMAL(10,2) NOT NULL ,
  `produit_quantite` INT NOT NULL ,
  `produit_type` ENUM('Boissons chaudes','Boissons froides','Sucreries') NOT NULL ,
  PRIMARY KEY (`produit_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_CAFETERIA_HISTORIQUE`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_CAFETERIA_HISTORIQUE` (
  `historique_id` INT NOT NULL AUTO_INCREMENT ,
  `student_idbooster` INT NOT NULL ,
  `produit_id` INT NOT NULL ,
  `historique_date` DATETIME NOT NULL ,
  PRIMARY KEY (`historique_id`) ,
  INDEX `fk_TB_CAFETERIA_HISTORIQUE_TB_STUDENTS1` (`student_idbooster` ASC) ,
  INDEX `fk_TB_CAFETERIA_HISTORIQUE_TB_CAFETERIA_PRODUITS1` (`produit_id` ASC) ,
  CONSTRAINT `fk_TB_CAFETERIA_HISTORIQUE_TB_STUDENTS1`
    FOREIGN KEY (`student_idbooster` )
    REFERENCES `TB_STUDENTS` (`student_idbooster` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TB_CAFETERIA_HISTORIQUE_TB_CAFETERIA_PRODUITS1`
    FOREIGN KEY (`produit_id` )
    REFERENCES `TB_CAFETERIA_PRODUITS` (`produit_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_BADGES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_BADGES` (
  `badge_id` INT NOT NULL AUTO_INCREMENT ,
  `badge_nom` VARCHAR(45) NOT NULL ,
  `badge_validation` TEXT NOT NULL ,
  `badge_date_creation` DATE NOT NULL ,
  `badge_date_fin` DATE NOT NULL ,
  PRIMARY KEY (`badge_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_STUDENTS_has_BADGES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_STUDENTS_has_BADGES` (
  `student_idbooster` INT NOT NULL ,
  `badge_id` INT NOT NULL ,
  `date_obtention` DATETIME NOT NULL ,
  PRIMARY KEY (`student_idbooster`, `badge_id`) ,
  INDEX `fk_TB_STUDENTS_has_BADGES_TB_STUDENTS1` (`student_idbooster` ASC) ,
  INDEX `fk_TB_STUDENTS_has_BADGES_TB_BADGES1` (`badge_id` ASC) ,
  CONSTRAINT `fk_TB_STUDENTS_has_BADGES_TB_STUDENTS1`
    FOREIGN KEY (`student_idbooster` )
    REFERENCES `TB_STUDENTS` (`student_idbooster` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TB_STUDENTS_has_BADGES_TB_BADGES1`
    FOREIGN KEY (`badge_id` )
    REFERENCES `TB_BADGES` (`badge_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_MATIERES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_MATIERES` (
  `matiere_id` INT NOT NULL AUTO_INCREMENT ,
  `matiere_nom` VARCHAR(45) NOT NULL ,
  `matiere_nom_complet` TEXT NOT NULL ,
  `matiere_cursus` CHAR(2) NOT NULL ,
  PRIMARY KEY (`matiere_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_DOCUMENTS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_DOCUMENTS` (
  `document_id` INT NOT NULL AUTO_INCREMENT ,
  `document_nom` VARCHAR(45) NOT NULL ,
  `document_chemin` TEXT NOT NULL ,
  `document_extension` VARCHAR(5) NOT NULL ,
  `document_date` DATETIME NOT NULL ,
  `document_telechargements` INT NOT NULL ,
  `document_status` INT NOT NULL ,
  `student_id` INT NOT NULL ,
  `matiere_id` INT NOT NULL ,
  PRIMARY KEY (`document_id`) ,
  INDEX `fk_TB_DOCUMENTS_TB_STUDENTS1` (`student_id` ASC) ,
  INDEX `fk_TB_DOCUMENTS_TB_MATIERES1` (`matiere_id` ASC) ,
  CONSTRAINT `fk_TB_DOCUMENTS_TB_STUDENTS1`
    FOREIGN KEY (`student_id` )
    REFERENCES `TB_STUDENTS` (`student_idbooster` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TB_DOCUMENTS_TB_MATIERES1`
    FOREIGN KEY (`matiere_id` )
    REFERENCES `TB_MATIERES` (`matiere_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_CATEGORIES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_CATEGORIES` (
  `categorie_id` INT NOT NULL AUTO_INCREMENT ,
  `categorie_nom` VARCHAR(25) NOT NULL ,
  `categorie_admin` TINYINT NOT NULL ,
  PRIMARY KEY (`categorie_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_GROUPES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_GROUPES` (
  `groupe_id` INT NOT NULL AUTO_INCREMENT ,
  `groupe_nom` VARCHAR(25) NOT NULL ,
  PRIMARY KEY (`groupe_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_GROUPES_has_CATEGORIES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_GROUPES_has_CATEGORIES` (
  `groupe_id` INT NOT NULL ,
  `categorie_id` INT NOT NULL ,
  PRIMARY KEY (`groupe_id`, `categorie_id`) ,
  INDEX `fk_TB_GROUPES_has_CATEGORIES_TB_GROUPES1` (`groupe_id` ASC) ,
  INDEX `fk_TB_GROUPES_has_CATEGORIES_TB_CATEGORIES1` (`categorie_id` ASC) ,
  CONSTRAINT `fk_TB_GROUPES_has_CATEGORIES_TB_GROUPES1`
    FOREIGN KEY (`groupe_id` )
    REFERENCES `TB_GROUPES` (`groupe_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TB_GROUPES_has_CATEGORIES_TB_CATEGORIES1`
    FOREIGN KEY (`categorie_id` )
    REFERENCES `TB_CATEGORIES` (`categorie_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_STUDENTS_has_GROUPES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_STUDENTS_has_GROUPES` (
  `student_idbooster` INT NOT NULL ,
  `groupe_id` INT NOT NULL ,
  PRIMARY KEY (`student_idbooster`, `groupe_id`) ,
  INDEX `fk_TB_STUDENTS_has_GROUPES_TB_STUDENTS1` (`student_idbooster` ASC) ,
  INDEX `fk_TB_STUDENTS_has_GROUPES_TB_GROUPES1` (`groupe_id` ASC) ,
  CONSTRAINT `fk_TB_STUDENTS_has_GROUPES_TB_STUDENTS1`
    FOREIGN KEY (`student_idbooster` )
    REFERENCES `TB_STUDENTS` (`student_idbooster` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TB_STUDENTS_has_GROUPES_TB_GROUPES1`
    FOREIGN KEY (`groupe_id` )
    REFERENCES `TB_GROUPES` (`groupe_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_EVENEMENTS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_EVENEMENTS` (
  `evenement_id` INT NOT NULL AUTO_INCREMENT ,
  `evenement_titre` VARCHAR(100) NOT NULL ,
  `evenement_ss_titre` VARCHAR(100) NOT NULL ,
  `evenement_date` DATE NOT NULL ,
  `evenement_participants` INT NOT NULL DEFAULT 0 ,
  `evenement_description` TEXT NOT NULL ,
  PRIMARY KEY (`evenement_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_EVENEMENTS_PARTICIPATIONS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_EVENEMENTS_PARTICIPATIONS` (
  `evenement_id` INT NOT NULL ,
  `student_idbooster` INT NOT NULL ,
  PRIMARY KEY (`evenement_id`, `student_idbooster`) ,
  INDEX `fk_TB_EVENEMENTS_PARTICIPATIONS_TB_STUDENTS1` (`student_idbooster` ASC) ,
  INDEX `fk_TB_EVENEMENTS_PARTICIPATIONS_TB_EVENEMENTS1` (`evenement_id` ASC) ,
  CONSTRAINT `fk_TB_EVENEMENTS_PARTICIPATIONS_TB_STUDENTS1`
    FOREIGN KEY (`student_idbooster` )
    REFERENCES `TB_STUDENTS` (`student_idbooster` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TB_EVENEMENTS_PARTICIPATIONS_TB_EVENEMENTS1`
    FOREIGN KEY (`evenement_id` )
    REFERENCES `TB_EVENEMENTS` (`evenement_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_PROJETS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_PROJETS` (
  `projet_id` INT NOT NULL AUTO_INCREMENT ,
  `projet_nom` VARCHAR(100) NOT NULL ,
  `projet_nb_membres` INT NOT NULL DEFAULT 1 ,
  `projet_icone` TEXT NOT NULL ,
  `projet_categorie` VARCHAR(100) NOT NULL ,
  `projet_description` TEXT NOT NULL ,
  `projet_competences` TEXT NOT NULL ,
  `projet_difficulte` INT NOT NULL ,
  `projet_auteur` INT NOT NULL ,
  PRIMARY KEY (`projet_id`) ,
  INDEX `fk_TB_PROJETS_TB_STUDENTS1` (`projet_auteur` ASC) ,
  CONSTRAINT `fk_TB_PROJETS_TB_STUDENTS1`
    FOREIGN KEY (`projet_auteur` )
    REFERENCES `TB_STUDENTS` (`student_idbooster` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_PROJETS_PARTICIPATIONS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_PROJETS_PARTICIPATIONS` (
  `projet_id` INT NOT NULL ,
  `student_idbooster` INT NOT NULL ,
  PRIMARY KEY (`projet_id`, `student_idbooster`) ,
  INDEX `fk_TB_PROJETS_PARTICIPATIONS_TB_PROJETS1` (`projet_id` ASC) ,
  INDEX `fk_TB_PROJETS_PARTICIPATIONS_TB_STUDENTS1` (`student_idbooster` ASC) ,
  CONSTRAINT `fk_TB_PROJETS_PARTICIPATIONS_TB_PROJETS1`
    FOREIGN KEY (`projet_id` )
    REFERENCES `TB_PROJETS` (`projet_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TB_PROJETS_PARTICIPATIONS_TB_STUDENTS1`
    FOREIGN KEY (`student_idbooster` )
    REFERENCES `TB_STUDENTS` (`student_idbooster` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_SONDAGES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_SONDAGES` (
  `sondage_id` INT NOT NULL AUTO_INCREMENT ,
  `sondage_question` TEXT NOT NULL ,
  `sondage_date_debut` DATE NOT NULL ,
  `sondage_date_fin` DATE NOT NULL ,
  `sondage_type` VARCHAR(30) NOT NULL ,
  `sondage_actif` INT NOT NULL ,
  PRIMARY KEY (`sondage_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_SONDAGES_CHOIX`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_SONDAGES_CHOIX` (
  `sondage_choix_id` INT NOT NULL AUTO_INCREMENT ,
  `sondage_choix` TEXT NOT NULL ,
  `sondage_choix_votes` INT NOT NULL ,
  `sondage_id` INT NOT NULL ,
  PRIMARY KEY (`sondage_choix_id`) ,
  INDEX `fk_TB_SONDAGES_CHOIX_TB_SONDAGES1` (`sondage_id` ASC) ,
  CONSTRAINT `fk_TB_SONDAGES_CHOIX_TB_SONDAGES1`
    FOREIGN KEY (`sondage_id` )
    REFERENCES `TB_SONDAGES` (`sondage_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `SBN_ENTREPRISES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `SBN_ENTREPRISES` (
  `entreprise_id` INT NOT NULL AUTO_INCREMENT ,
  `entreprise_nom` VARCHAR(45) NOT NULL ,
  `entreprise_adresse` TEXT NULL DEFAULT NULL ,
  `entreprise_cp` INT NULL DEFAULT NULL ,
  `entreprise_ville` VARCHAR(45) NULL DEFAULT NULL ,
  `entreprise_site` TEXT NULL DEFAULT NULL ,
  `entreprise_thematique` TEXT NULL DEFAULT NULL ,
  `entreprise_infos` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`entreprise_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `SBN_CONTACTS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `SBN_CONTACTS` (
  `contact_id` INT NOT NULL AUTO_INCREMENT ,
  `contact_nom` VARCHAR(45) NULL DEFAULT NULL ,
  `contact_role` VARCHAR(45) NULL DEFAULT NULL ,
  `contact_telephone` VARCHAR(45) NULL DEFAULT NULL ,
  `contact_fax` VARCHAR(45) NULL DEFAULT NULL ,
  `contact_email` VARCHAR(45) NULL DEFAULT NULL ,
  `contact_entreprise` INT NOT NULL ,
  PRIMARY KEY (`contact_id`) ,
  INDEX `fk_SBN_CONTACTS_SBN_ENTREPRISES1` (`contact_entreprise` ASC) ,
  CONSTRAINT `fk_SBN_CONTACTS_SBN_ENTREPRISES1`
    FOREIGN KEY (`contact_entreprise` )
    REFERENCES `SBN_ENTREPRISES` (`entreprise_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `SBN_STAGES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `SBN_STAGES` (
  `stage_id` INT NOT NULL AUTO_INCREMENT ,
  `stage_description` TEXT NOT NULL ,
  `stage_date` VARCHAR(45) NOT NULL ,
  `stage_fichier` TEXT NULL DEFAULT NULL ,
  `stage_entreprise` INT NOT NULL ,
  PRIMARY KEY (`stage_id`) ,
  INDEX `fk_SBN_STAGES_SBN_ENTREPRISES1` (`stage_entreprise` ASC) ,
  CONSTRAINT `fk_SBN_STAGES_SBN_ENTREPRISES1`
    FOREIGN KEY (`stage_entreprise` )
    REFERENCES `SBN_ENTREPRISES` (`entreprise_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `SBN_DOUBLONS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `SBN_DOUBLONS` (
  `doublon_id` INT NOT NULL AUTO_INCREMENT ,
  `doublon_entreprise` INT NOT NULL ,
  PRIMARY KEY (`doublon_id`) ,
  INDEX `fk_SBN_DOUBLONS_SBN_ENTREPRISES1` (`doublon_entreprise` ASC) ,
  CONSTRAINT `fk_SBN_DOUBLONS_SBN_ENTREPRISES1`
    FOREIGN KEY (`doublon_entreprise` )
    REFERENCES `SBN_ENTREPRISES` (`entreprise_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_ENTRAIDES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_ENTRAIDES` (
  `entraide_id` INT NOT NULL ,
  `entraide_question` TEXT NOT NULL ,
  `entraide_auteur` VARCHAR(45) NOT NULL ,
  `entraide_date` DATETIME NOT NULL ,
  `entraide_details` TEXT NOT NULL ,
  `entraide_resolu` INT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`entraide_id`) )
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `TB_ENTRAIDES_REPONSES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `TB_ENTRAIDES_REPONSES` (
  `entraide_reponse_id` INT NOT NULL ,
  `entraide_id` INT NOT NULL ,
  `entraide_reponse` TEXT NOT NULL ,
  `entraide_reponse_auteur` VARCHAR(45) NOT NULL ,
  `entraide_reponse_date` DATETIME NOT NULL ,
  PRIMARY KEY (`entraide_reponse_id`) ,
  INDEX `fk_TB_ENTRAIDES_REPONSES_TB_ENTRAIDES1` (`entraide_id` ASC) ,
  CONSTRAINT `fk_TB_ENTRAIDES_REPONSES_TB_ENTRAIDES1`
    FOREIGN KEY (`entraide_id` )
    REFERENCES `TB_ENTRAIDES` (`entraide_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `SBN_VW_DOUBLONS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `SBN_VW_DOUBLONS` (`entreprise_id` INT, `entreprise_nom` INT, `entreprise_adresse` INT, `entreprise_cp` INT, `entreprise_ville` INT, `entreprise_site` INT, `entreprise_thematique` INT, `entreprise_infos` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `VW_AUTORISATIONS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `VW_AUTORISATIONS` (`student_idbooster` INT, `student_prenom` INT, `student_nom` INT, `categorie_nom` INT, `categorie_admin` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `VW_INFOS_CONSOS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `VW_INFOS_CONSOS` (`student_idbooster` INT, `student_nom` INT, `student_prenom` INT, `nb_badge` INT, `nb_conso` INT, `nb_maitre` INT, `nb_produit` INT, `nb_derniers` INT, `nb_cheese` INT, `nb_coca` INT, `nb_kinderbueno` INT, `nb_kinderchocolat` INT, `nb_cafe` INT, `nb_barre` INT, `nb_mars` INT, `nb_bonbon` INT, `nb_canette` INT, `nb_misterfreez` INT, `nb_dg` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `VW_MAITRES`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `VW_MAITRES` (`produit_id` INT, `produit_nom` INT, `student_idbooster` INT, `student_nom` INT, `student_prenom` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `VW_TOP_CLIENTS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `VW_TOP_CLIENTS` (`student_nom` INT, `student_prenom` INT, `student_idbooster` INT, `depenses` INT, `achats` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `VW_TOP_PRODUITS`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `VW_TOP_PRODUITS` (`produit_nom` INT, `depenses` INT, `achats` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- procedure addBadge
-- -----------------------------------------------------
DELIMITER $$

DELIMITER $$
CREATE PROCEDURE addBadge(p_student INT, p_badge INT)
BEGIN
  INSERT INTO TB_STUDENTS_has_BADGES (student_idbooster, badge_id, date_obtention)
  VALUES (p_student, p_badge, CURDATE());
END;

$$

$$
DELIMITER ;


DELIMITER ;SHOW WARNINGS;

-- -----------------------------------------------------
-- function getNbDiffProduits10Achats
-- -----------------------------------------------------
DELIMITER $$

DELIMITER $$






CREATE FUNCTION `getNbDiffProduits10Achats`(p_student INT) RETURNS int(11)
BEGIN
  DECLARE nb_diff INT;

  SELECT COUNT(*) INTO nb_diff 
  FROM (
         SELECT * 
         FROM (
               SELECT * 
               FROM TB_CAFETERIA_HISTORIQUE 
               WHERE student_idbooster = p_student ORDER BY historique_date DESC LIMIT 0,10
         ) derniers_produits 
         GROUP BY produit_id
       ) nb_derniers;

  RETURN nb_diff;
END;

$$

$$
DELIMITER ;


DELIMITER ;SHOW WARNINGS;

-- -----------------------------------------------------
-- function getNbDiffProduitsTousAchats
-- -----------------------------------------------------
DELIMITER $$

DELIMITER $$






CREATE FUNCTION `getNbDiffProduitsTousAchats`(p_student INT) RETURNS int(11)
BEGIN
  DECLARE nb_diff INT;

  SELECT COUNT(*) INTO nb_diff FROM (SELECT produit_id, COUNT(*) FROM TB_CAFETERIA_HISTORIQUE WHERE student_idbooster = p_student GROUP BY produit_id) produits;

  RETURN nb_diff;
END

$$

$$
DELIMITER ;


DELIMITER ;SHOW WARNINGS;

-- -----------------------------------------------------
-- procedure checkBadgesValidation
-- -----------------------------------------------------
DELIMITER $$

DELIMITER $$






CREATE PROCEDURE checkBadgesValidation()
BEGIN

-- ################################################
-- ################# DECLARATIONS #################
-- ################################################

  DECLARE idbooster INT;
  DECLARE nom VARCHAR(255);
  DECLARE prenom VARCHAR(255);
  
  DECLARE resultat TEXT DEFAULT '';

  DECLARE badge_americain INT;
  DECLARE badge_bonjourlesriches INT;
  DECLARE badge_kinderlover INT;
  DECLARE badge_fanboy INT;
  DECLARE badge_italien INT;
  DECLARE badge_barre INT;
  DECLARE badge_martien INT;
  DECLARE badge_maitre INT;
  DECLARE badge_puitsansfond INT;
  DECLARE badge_grandmaitre INT;
  DECLARE badge_stomatophobie INT;
  DECLARE badge_suceurcertified INT;
  DECLARE badge_conquistador INT;
  DECLARE badge_pokemaniac INT;
  DECLARE badge_indianajones INT;
  DECLARE badge_gourmand INT;
  DECLARE badge_goinfre INT;
  DECLARE badge_goinfrex INT;
  DECLARE badge_dgfan INT;

  DECLARE total_produits INT;
  DECLARE total_badges INT;
  DECLARE total_consos INT;

  DECLARE nb_badge INT;
  DECLARE nb_conso INT;
  DECLARE nb_maitre INT;
  DECLARE nb_produit INT;
  DECLARE nb_derniers INT;
  DECLARE nb_cheese INT;
  DECLARE nb_coca INT;
  DECLARE nb_kinderbueno INT;
  DECLARE nb_kinderchocolat INT;
  DECLARE nb_cafe INT;
  DECLARE nb_barre INT;
  DECLARE nb_mars INT;
  DECLARE nb_bonbon INT;
  DECLARE nb_canette INT;
  DECLARE nb_misterfreez INT;
  DECLARE nb_dg INT;

  DECLARE no_more_rows BOOLEAN;

-- Declaration du curseur qui contiendra tous les etudiants
  DECLARE cursor_students CURSOR FOR
    SELECT * FROM VW_INFOS_CONSOS;
  DECLARE CONTINUE HANDLER FOR NOT FOUND
  SET no_more_rows = TRUE;

-- ################################################
-- ################### PROGRAMME ##################
-- ################################################ 

  SELECT COUNT(*) INTO total_produits FROM TB_CAFETERIA_PRODUITS;

  OPEN cursor_students;

  the_loop: LOOP

    FETCH cursor_students 
    INTO idbooster, nom, prenom, nb_badge, nb_conso, nb_maitre, nb_produit, nb_derniers, nb_cheese, nb_coca, nb_kinderbueno, nb_kinderchocolat, nb_cafe, nb_barre, nb_mars, nb_bonbon, nb_canette, nb_misterfreez, nb_dg;

    IF no_more_rows THEN
        CLOSE cursor_students;
        LEAVE the_loop;
    END IF;

-- ################### Americain (1) ########################## OK
    SELECT COUNT(*) INTO badge_americain FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 1;
    IF badge_americain = 0 THEN
      IF nb_cheese >= 3 AND nb_coca >= 20 THEN
        CALL addBadge(idbooster, 1);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Américain'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Américain'); 
        END IF;
      END IF;
    END IF;

-- ################### Bonjour les riches (2) ################## OK
    SELECT COUNT(*) INTO badge_bonjourlesriches FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 2;
    IF badge_bonjourlesriches = 0 THEN
      IF nb_produit = total_produits THEN
        CALL addBadge(idbooster, 2);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Bonjour les riches'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Bonjour les riches'); 
        END IF;
      END IF;
    END IF;

-- ################### Kinder Lover (3) ######################## OK
    SELECT COUNT(*) INTO badge_kinderlover FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 3;
    IF badge_kinderlover = 0 THEN
      IF nb_kinderchocolat >= 20 AND nb_kinderbueno >= 15 THEN
        CALL addBadge(idbooster, 3);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Kinder Lover'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Kinder Lover'); 
        END IF;
      END IF;
    END IF;

-- ################### Fanboy (4) ############################## OK
    SELECT COUNT(*) INTO badge_fanboy FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 4;
    IF badge_fanboy = 0 THEN
      IF nb_derniers = 1 AND nb_conso >= 10 THEN
        CALL addBadge(idbooster, 4);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Fanboy'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Fanboy'); 
        END IF;
      END IF;
    END IF;

-- ################### Italien (6) ############################# OK
    SELECT COUNT(*) INTO badge_italien FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 6;
    IF badge_italien = 0 THEN
      IF nb_cafe >= 25 THEN
        CALL addBadge(idbooster, 6);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Italien'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Italien'); 
        END IF;
      END IF;
    END IF;

-- ################### Barre (8) ############################### OK
    SELECT COUNT(*) INTO badge_barre FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 8;
    IF badge_barre = 0 THEN
      IF nb_barre >= 40 THEN
        CALL addBadge(idbooster, 8);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Barré'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Barré'); 
        END IF;
      END IF;
    END IF;

-- ################### Martien (9) ############################# OK
    SELECT COUNT(*) INTO badge_martien FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 9;
    IF badge_martien = 0 THEN
      IF nb_mars >= 15 THEN
        CALL addBadge(idbooster, 9);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Martien'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Martien'); 
        END IF;
      END IF;    
    END IF;

-- ################### Maitre (10) ############################# OK
    SELECT COUNT(*) INTO badge_maitre FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 10;
    IF badge_maitre = 0 THEN
      IF nb_maitre >= 2 THEN
        CALL addBadge(idbooster, 10);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Maître'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Maître'); 
        END IF;
      END IF;
    END IF;

-- ################### Puit sans fond (11) ##################### OK
    SELECT COUNT(*) INTO badge_puitsansfond FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 11;
    IF badge_puitsansfond = 0 THEN
      IF nb_canette >= 30 THEN
        CALL addBadge(idbooster, 11);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Puit sans fond'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Puit sans fond'); 
        END IF;
      END IF;
    END IF;

-- ################### Grand Maitre (12) ####################### OK
    SELECT COUNT(*) INTO badge_grandmaitre FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 12;
    IF badge_grandmaitre = 0 THEN
      IF nb_maitre >= 4 THEN
        CALL addBadge(idbooster, 12);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Grand Maître'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Grand Maître'); 
        END IF;
      END IF;
    END IF;

-- ################### Stomatophobie (13) ###################### OK
    SELECT COUNT(*) INTO badge_stomatophobie FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 13;
    IF badge_stomatophobie = 0 THEN
      IF nb_bonbon >= 20 THEN
        CALL addBadge(idbooster, 13);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Stomatophobie'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Stomatophobie'); 
        END IF;
      END IF;
    END IF;

-- ################### Suceur Certified (15) ################### OK
    SELECT COUNT(*) INTO badge_suceurcertified FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 15;
    IF badge_suceurcertified = 0 THEN
      IF nb_misterfreez >= 25 THEN
        CALL addBadge(idbooster, 15);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Suceur Certified'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Suceur Certified'); 
        END IF;
      END IF;
    END IF;

-- ################### Conquistador (16) ####################### OK
    SELECT COUNT(*) INTO badge_conquistador FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 16;
    IF badge_conquistador = 0 THEN
      IF nb_badge >= 5 THEN
        CALL addBadge(idbooster, 16);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Conquistador'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Conquistador'); 
        END IF;
      END IF;
    END IF;

-- ################### Pokémaniac (17) ######################### OK
    SELECT COUNT(*) INTO badge_pokemaniac FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 17;
    IF badge_pokemaniac = 0 THEN
      IF nb_badge >= 8 THEN
        CALL addBadge(idbooster, 17);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Pokémaniac'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Pokémaniac'); 
        END IF;
      END IF;
    END IF;

-- ################### Indianna Jones (18) ##################### OK
    SELECT COUNT(*) INTO badge_indianajones FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 18;
    IF badge_indianajones = 0 THEN
      IF nb_badge >= 15 THEN
        CALL addBadge(idbooster, 18);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Indianna Jones'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Indianna Jones'); 
        END IF;
      END IF;
    END IF;

-- ################### Gourmand (19) ########################### OK
    SELECT COUNT(*) INTO badge_gourmand FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 19;
    IF badge_gourmand = 0 THEN
      IF nb_conso >= 50 THEN
        CALL addBadge(idbooster, 19);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Gourmand'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Gourmand'); 
        END IF;
      END IF;
    END IF;

-- ################### Goinfre (20) ############################ OK
    SELECT COUNT(*) INTO badge_goinfre FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 20;
    IF badge_goinfre = 0 THEN
      IF nb_conso >= 100 THEN
        CALL addBadge(idbooster, 20);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Goinfre'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Goinfre'); 
        END IF;
      END IF;
    END IF;

-- ################### Goinfrex (21) ########################### OK
    SELECT COUNT(*) INTO badge_goinfrex FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 21;
    IF badge_goinfrex = 0 THEN
      IF nb_conso >= 200 THEN
        CALL addBadge(idbooster, 21);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge Goinfrex'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge Goinfrex'); 
        END IF;
      END IF;
    END IF;
    
-- ################### DG Fan (22) ###################### OK
    SELECT COUNT(*) INTO badge_dgfan FROM TB_STUDENTS_has_BADGES WHERE student_idbooster = idbooster AND badge_id = 22;
    IF badge_dgfan = 0 THEN
      IF nb_dg >= 40 THEN
        CALL addBadge(idbooster, 22);
        IF resultat != '' THEN
        	SET resultat = CONCAT(resultat, ' | ', prenom, ' ', nom, ' remporte le badge DG Fan'); 
        ELSE
        	SET resultat = CONCAT(prenom, ' ', nom, ' remporte le badge DG Fan'); 
        END IF;
      END IF;
    END IF;

  END LOOP the_loop;
  
  SELECT resultat;

END;$$

$$
DELIMITER ;


DELIMITER ;SHOW WARNINGS;

-- -----------------------------------------------------
-- View `SBN_VW_DOUBLONS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SBN_VW_DOUBLONS`;
SHOW WARNINGS;
DELIMITER $$
CREATE  OR REPLACE VIEW SBN_VW_DOUBLONS AS 
select e.entreprise_id AS entreprise_id,
       e.entreprise_nom AS entreprise_nom,
       e.entreprise_adresse AS entreprise_adresse,
       e.entreprise_cp AS entreprise_cp,
       e.entreprise_ville AS entreprise_ville,
       e.entreprise_site AS entreprise_site,
       e.entreprise_thematique AS entreprise_thematique,
       e.entreprise_infos AS entreprise_infos 
FROM SBN_DOUBLONS d 
JOIN SBN_ENTREPRISES e ON d.doublon_entreprise = e.entreprise_id
ORDER BY e.entreprise_nom;
$$
DELIMITER ;

;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `VW_AUTORISATIONS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VW_AUTORISATIONS`;
SHOW WARNINGS;
DELIMITER $$
CREATE  OR REPLACE VIEW VW_AUTORISATIONS AS 
SELECT s.student_idbooster AS student_idbooster,
       s.student_prenom AS student_prenom,
       s.student_nom AS student_nom,
       c.categorie_nom AS categorie_nom,
       c.categorie_admin AS categorie_admin 
FROM TB_STUDENTS s 
JOIN TB_STUDENTS_has_GROUPES sg on s.student_idbooster = sg.student_idbooster 
JOIN TB_GROUPES g on sg.groupe_id = g.groupe_id 
JOIN TB_GROUPES_has_CATEGORIES gc on g.groupe_id = gc.groupe_id 
JOIN TB_CATEGORIES c on gc.categorie_id = c.categorie_id;
$$
DELIMITER ;

;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `VW_INFOS_CONSOS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VW_INFOS_CONSOS`;
SHOW WARNINGS;
DELIMITER $$
CREATE  OR REPLACE VIEW VW_INFOS_CONSOS AS 
SELECT s.student_idbooster AS student_idbooster,
		s.student_nom AS student_nom,
		s.student_prenom AS student_prenom,
		(
			SELECT COUNT(*) 
			FROM TB_STUDENTS_has_BADGES 
			WHERE (TB_STUDENTS_has_BADGES.student_idbooster = s.student_idbooster)
		) AS nb_badge,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE (TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster)
		) AS nb_conso,
		(
			SELECT COUNT(*) 
			FROM VW_MAITRES 
			WHERE (VW_MAITRES.student_idbooster = s.student_idbooster)
		) AS nb_maitre,
		getNbDiffProduitsTousAchats(s.student_idbooster) AS nb_produit,
		getNbDiffProduits10Achats(s.student_idbooster) AS nb_derniers,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id = 36
		) AS nb_cheese,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id in (11,12,14)
		) AS nb_coca,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id = 31
		) AS nb_kinderbueno,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id = 34
		) AS nb_kinderchocolat,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id in (1,4,5,6)
		) AS nb_cafe,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id in (24,25,26,32)
		) AS nb_barre,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id = 26
		) AS nb_mars,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id in (35,21,23)
		) AS nb_bonbon,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id in (11,12,14,15,16,17,18,19,20,33,10)
		) AS nb_canette,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id = 37
		) AS nb_misterfreez,
		(
			SELECT COUNT(*) 
			FROM TB_CAFETERIA_HISTORIQUE 
			WHERE TB_CAFETERIA_HISTORIQUE.student_idbooster = s.student_idbooster 
			AND TB_CAFETERIA_HISTORIQUE.produit_id in (1,2,3,4,5,6,7,8,9,10)
		) AS nb_dg 
FROM TB_STUDENTS s;
$$
DELIMITER ;

;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `VW_MAITRES`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VW_MAITRES`;
SHOW WARNINGS;
DELIMITER $$
CREATE  OR REPLACE VIEW VW_MAITRES AS 
SELECT p.produit_id AS produit_id,
		p.produit_nom AS produit_nom,
		s.student_idbooster AS student_idbooster,
		s.student_nom AS student_nom,
		s.student_prenom AS student_prenom 
FROM TB_CAFETERIA_PRODUITS p 
JOIN TB_STUDENTS s 
WHERE s.student_idbooster = 
		(
			SELECT ss.student_idbooster AS student_idbooster 
			FROM TB_CAFETERIA_HISTORIQUE hh 
			JOIN TB_CAFETERIA_PRODUITS pp on hh.produit_id = pp.produit_id
			JOIN TB_STUDENTS ss on hh.student_idbooster = ss.student_idbooster 
			WHERE hh.produit_id = p.produit_id 
			GROUP BY ss.student_idbooster ORDER BY count(0) desc limit 0,1
		) 
ORDER BY p.produit_nom;
$$
DELIMITER ;

;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `VW_TOP_CLIENTS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VW_TOP_CLIENTS`;
SHOW WARNINGS;
DELIMITER $$
CREATE  OR REPLACE VIEW VW_TOP_CLIENTS AS 
SELECT s.student_nom AS student_nom,
		s.student_prenom AS student_prenom,
		h.student_idbooster AS student_idbooster,
		round(sum(p.produit_prix),2) AS depenses,
		count(p.produit_prix) AS achats 
FROM TB_CAFETERIA_HISTORIQUE h 
JOIN TB_CAFETERIA_PRODUITS p ON h.produit_id = p.produit_id 
JOIN TB_STUDENTS s ON h.student_idbooster = s.student_idbooster 
GROUP BY h.student_idbooster 
ORDER BY round(sum(p.produit_prix),2) DESC;
$$
DELIMITER ;

;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `VW_TOP_PRODUITS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `VW_TOP_PRODUITS`;
SHOW WARNINGS;
DELIMITER $$
CREATE  OR REPLACE VIEW VW_TOP_PRODUITS AS 
select p.produit_nom AS produit_nom,
		round(sum(p.produit_prix),2) AS depenses,
		count(p.produit_prix) AS achats 
FROM TB_CAFETERIA_HISTORIQUE h 
JOIN TB_CAFETERIA_PRODUITS p ON h.produit_id = p.produit_id 
JOIN TB_STUDENTS s ON h.student_idbooster = s.student_idbooster 
GROUP BY p.produit_nom 
ORDER BY round(sum(p.produit_prix),2) DESC;
$$
DELIMITER ;

;
SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;