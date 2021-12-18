<?php
require_once __DIR__ . '/../config.php';
session_start(); 
if(!substr($_SESSION["mode"], 0, 4) === 'prof') {
    header('location: ../login.php');
}
?>
