<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    require_once 'config.php';
    $sql = "INSERT INTO organisme(nom, adresse) VALUES(:nom, :adresse)";
    $que = $pdo->prepare($sql);
    $que->execute(array(
        'nom' => $_POST["nom"],
        'adresse' => $_POST["adresse"],
    ));
    $sql = "SELECT id FROM organisme WHERE nom = :nom AND adresse = :adresse";
    $que = $pdo->prepare($sql);
    $que->execute(array(
        'nom' => $_POST["nom"],
        'adresse' => $_POST["adresse"],
    ));
    $id = $que->fetch()['id'];

    $sql = "INSERT INTO stage(date_debut, date_fin, id_organisme) VALUES(:date_debut, :date_fin, :id_organisme)";
    $que = $pdo->prepare($sql);
    $que->execute(array(
        'date_debut' => $_POST["date_debut"],
        'date_fin' => $_POST["date_fin"],
        'id_organisme' => $id
    ));
    header("location: page_etudiant.php"); //TODO: Testing purposes delete later...
}
?>

<form action="" method="post">
  <label: for="nom">Nom de l'organisme</label>
  <input type="text" id="nom" name="nom" required><br><br>
  <label for="adresse">Adresse:</label>
  <input type="text" id="adresse" name="adresse" required><br><br>
  <label for="date_debut">Date de Debut:</label>
  <input type="date" id="date_debut" name="date_debut" required><br><br>
  <label for="date_fin">Date de Fin:</label>
  <input type="date" id="date_fin" name="date_fin" required><br><br>
  <input type="submit" value="Submit">
</form>

    