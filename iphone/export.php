<?php
require_once('../inclusions/configuration.php');
require_once('../inclusions/auto_chargement_classes.php');
require_once("../inclusions/fonctions.php");

$BDD = new BDD();
$columns = "student_idbooster, student_promo, student_prenom, student_nom";/*/"student_idbooster, student_promo, student_prenom, student_nom, student_portable, student_msn, student_skype, student_twitter, student_facebook, student_autorisation, student_visites, DATE_FORMAT(student_derniere_visite,'Le %d/%m/%y') AS sdt_derniere_visite, DATE_FORMAT(student_derniere_maj,'Le %d/%m/%y') AS sdt_derniere_maj";*/

$finalarr['tbl'] = "TB_STUDENTS";
$studentvalues = $BDD -> select($columns, "TB_STUDENTS");
$finalarr['values'] = $studentvalues;

$jsonStudents = json_encode($finalarr);
echo html_entity_decode($jsonStudents);
//str_replace('"','\"',);
?>