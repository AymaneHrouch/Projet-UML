<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once 'config.php';
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    $sql = "SELECT id_organisme FROM stage WHERE id=:id";
    $que =  $pdo->prepare($sql);
    $que->execute(array(
        'id' => $_POST["id"]
    ));
    $id_org = $que->fetch()['id_organisme'];
    $sql = "UPDATE organisme SET nom=:nom, adresse=:adresse WHERE id=:id";
    $que = $pdo->prepare($sql);
    $que->execute(array(
        'nom' => $_POST["nom"],
        'adresse' => $_POST["adresse"],
        'id' => $id_org
    ));

    $sql = "UPDATE stage SET date_debut=:date_debut, date_fin=:date_fin WHERE id=:id";
    $que = $pdo->prepare($sql);
    $que->execute(array(
        'date_debut' => $_POST["date_debut"],
        'date_fin' => $_POST["date_fin"],
        'id' => $id
    ));
    header("location: page_etudiant.php"); //TODO: Testing purposes delete later...
}
else if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(!isset($_GET["id"]) || $_GET["id"] == "" || !is_numeric($_GET["id"])) {
        header("location: modifier_stage.php");
    }
    $sql = "SELECT date_debut, date_fin, id_organisme FROM stage WHERE id=:id";
    $que = $pdo->prepare($sql);
    $que->execute(array(
        'id' => $_GET['id']
    ));
    $result = $que->fetch();
    $date_debut = $result['date_debut'];
    $date_fin = $result['date_fin'];
    $id_org = $result['id_organisme'];
    $sql = "SELECT nom, adresse FROM organisme WHERE id=:id";
    $que = $pdo->prepare($sql);
    $que->execute(array(
        'id' => $id_org
    ));
    $result = $que->fetch();
    $nom = $result['nom'];
    $adresse = $result['adresse'];
}
?>

<form action="" method="post">
  <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>"> 
  <label: for="nom">Nom de l'organisme</label>
  <input type="text" id="nom" name="nom" value="<?php echo $nom ?>" required><br><br>
  <label for="adresse">Adresse:</label>
  <input type="text" id="adresse" name="adresse" value="<?php echo $adresse ?>" required><br><br>
  <label for="date_debut">Date de Debut:</label>
  <input type="date" id="date_debut" name="date_debut" value="<?php echo $date_debut ?>" required><br><br>
  <label for="date_fin">Date de Fin:</label>
  <input type="date" id="date_fin" name="date_fin" value="<?php echo $date_fin ?>" required><br><br>
  <input type="submit" value="Submit">
</form>

    