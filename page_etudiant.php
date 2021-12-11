<?php
include __DIR__ . '/classes/Etudiant.php';

session_start();

$etudiant =  $_SESSION["utilisateur"];
echo "hello dear " . $etudiant->nom;
echo "<br />";
include_once 'page_stage.php';
AfficherLesStages(true); //TODO: Should be false or empty, this is only for testing purposes

?>