<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

include_once "page_stage.php";
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(!isset($_GET["CNE"]))
    {
        header("location: page_demandes.php");
    }

    AfficherLesStages();
    $sql = "SELECT nom FROM etudiant WHERE CNE = :CNE";
    $que = $pdo->prepare($sql);
    $que->execute(array('CNE' => $_GET['CNE']));
    $nom = $fetch = $que->fetch()['nom'];
}
else if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    include_once "Responasble.php";
    $respo = new Responsable();
    $respo->AffecterStage($_POST['CNE'], $_POST['stage']);
    $sql = "DELETE FROM demande WHERE CNE = :CNE";
    $que = $pdo->prepare($sql);
    $que->execute(array(
        'CNE' => $_POST["CNE"]
    ));
    header("location: page_demandes.php");
}
?>

<form action="" method = "POST">
    <label for="stage">Stage à affecter pour <?php echo $nom ?></label>
    <input type="hidden" name="CNE" id="CNE" value="<?php echo $_GET['CNE'] ?>">;
    <input type="number" name="stage" id="stage" required>
    <input type="submit" value="Submit">
</form>