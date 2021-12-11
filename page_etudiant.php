<?php
include 'config.php';
include __DIR__ . '/classes/Etudiant.php';

session_start();

$etudiant =  $_SESSION["utilisateur"];
echo "hello dear " . $etudiant->nom;
echo "<br />";
$result = $pdo->query('select nom, adresse, date_debut, date_fin from organisme, stage where stage.id_organisme = organisme.id');
echo "les stages disponibles:<br />";
while($data = $result->fetch()) {
    echo $data["nom"] . " " . $data["adresse"] . "<br />";
}

?>