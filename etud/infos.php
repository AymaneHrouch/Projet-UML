<?php
require_once __DIR__ . '/../classes/Etudiant.php';

session_start(); 
$etudiant =  $_SESSION["utilisateur"];
require_once __DIR__ . '/../config.php';

$sql = "select organisme.nom, organisme.adresse, stage.infos from organisme, stage where stage.id_organisme = organisme.id and stage.id=" . $_GET["id"];
global $pdo;
$result = $pdo->query($sql);
$data = $result->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./../assets/common/css/style.css" />
    <link rel="stylesheet" href="./../assets/libs/font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="./../assets/libs/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/jpg" href="./../assets/common/img/logo.svg" />
    <title>Liste Des Stages</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">ENSA STAGES</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://google.com/">Features</a>
        </li>
        </ul>
    </div>
    </nav>
    <h1 class="text-center mb-4 p-2">Bienvenue <span style="color:red"><?php echo $etudiant->prenom . " " . $etudiant->nom ?></span></h1>
    <div class="container">
        <h2>Infos sur le stage de <?php echo $data["nom"] . " à " . $data["adresse"]?></h2>
        <p><?php echo $data["infos"] ?></p>
    </div>
</body>
</html>