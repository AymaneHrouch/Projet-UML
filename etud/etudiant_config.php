<?php
require_once __DIR__ . '/../classes/Etudiant.php';
require_once __DIR__ . '/../config.php';
session_start(); 
$etudiant =  $_SESSION["utilisateur"];
if($_SESSION["mode"] !== "etud") {
    header('location: ../login.php');
}
?>