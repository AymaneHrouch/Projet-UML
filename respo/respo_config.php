<?php
require_once __DIR__ . '/../config.php';
session_start(); 
if($_SESSION["mode"] !== "respo") {
    header('location: ../login.php');
}
?>