<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once 'config.php';
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(!isset($_GET["id"]) || $_GET["id"] == "" || !is_numeric($_GET["id"])) {
        header("location: page_etudiant.php"); //TODO: Delete this
    }
    $sql = "DELETE FROM stage WHERE id=:id";
    $que = $pdo->prepare($sql);
    $que->execute(array(
        'id' => $_GET['id']
    ));
    header("location: page_etudiant.php"); //TODO: Testing purposes delete later...
}
?>