<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<table>
    <tr>
        <th>CNE</th>
        <th>NOM</th>
        <th>Filiere</th>
        <th></th>
    </tr>
<?php
include_once "config.php";
$sql = "SELECT CNE FROM demande";
$result = $pdo->query($sql);
while ($row = $result->fetch()) {
    $sql = "SELECT nom, filiere FROM etudiant WHERE CNE = :CNE";
    $que = $pdo->prepare($sql);
    $que->execute(array('CNE' => $row['nom']));
    $etudiant = $que->fetch();
    $nom = $etudiant['nom'];
    $filiere = $etudiant['filiere'];

    echo "
    <tr>
        <td>{$CNE}</td>
        <td>{$nom}</td>
        <td>{$filier}</td>
        <td><a href =\"admettere.php?CNE={$CNE}\">Accepter</a></td>
    </tr>";
}
?>
</table>