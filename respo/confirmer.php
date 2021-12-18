<?php
require_once 'respo_config.php';
if($_GET["id"]) 
{
    $sql = "UPDATE DEMANDE SET ETAT_DEMANDE=1 WHERE id=:id";
    $res = $pdo->prepare($sql);
    $res->execute(array(
        'id' => $_GET["id"]
    ));
}

header('location: liste_des_demandes.php');
?>