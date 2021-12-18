<?php
session_start();
if(!$_SESSION["loggedin"]) {
    header('location: login.php');
}

if($_SESSION["mode"] == 'etud') {
    header('location: ./etud/liste_des_stages.php');
} else if($_SESSION["mode"] === 'respo') {
    header('location: ./respo/liste_des_stages.php');
} else if(substr($_SESSION["mode"], 0, 4) === 'prof') {
    header('location: ./prof/index.php');
}

?>