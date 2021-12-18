<?php
require_once 'respo_config.php';
if($_GET["id"]) {
    $sql = "DELETE FROM STAGE WHERE id=:id";
    $res = $pdo->prepare($sql);
    $res->execute(array(
        'id' => $_GET["id"]
    ));

    $sql = "DELETE FROM PLAGE_horaire WHERE id_stage=:id";
    $res = $pdo->prepare($sql);
    $res->execute(array(
        'id' => $_GET["id"]
    ));
}



header('location: liste_des_stages.php');

?>