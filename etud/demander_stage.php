<?php
require_once 'etudiant_config.php';
$success = 0;


if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    global $pdo;
    $sql = "INSERT INTO demande(cne_etudiant, demande_ecrit, date_envoye) VALUES(:cne, :demande_ecrit, CURRENT_TIMESTAMP)";
    $que = $pdo->prepare($sql);
    $que->execute(array(
        'cne' => $etudiant->cne,
        'demande_ecrit' => $_POST['demande_ecrit'],
    ));

    $success = 1;
}

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
    <?php include "header.php"; ?>
    <div class="container">
        <?php 
            $query = $pdo->prepare('select id_stage from demande where etat_demande = 1 and cne_etudiant=:cne');
            $query->execute(array(
                'cne' => $etudiant->cne
            ));
            $id_stage = $query->fetch();

            // if stage doesn't exist yet.
            if($id_stage) {
                echo "Vous avez dèjà un stage, pour envoyer une demande veuillez contacter le responsable le plutot possible pour l'annuler.";
                return;
            }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <textarea class="form-control" name="demande_ecrit" rows="10" cols="50"></textarea>
            <button type="submit" class="btn btn-primary">Demander un stage</button>
            <?php if($success): ?>
                <span class="text-success">Votre demande a été bien envoyé!</span>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>