<?php
require_once 'respo_config.php';
$page_title = "Modifier Stage";
if(!isset($_GET["id"])) {
    header('location: liste_des_stages.php');
}

if(isset($_GET["ph_to_del"])) {
    $q = "delete from plage_horaire where id=:id";
    $res = $pdo->prepare($q);
    $res->execute(array('id' => $_GET["ph_to_del"]));
}

if(isset($_GET["create_new_ph"])) {
    $q = "insert into plage_horaire(id_stage) values(:id_stage)";
    $res = $pdo->prepare($q);
    $res->execute(array('id_stage' => $_GET["id"]));
}

include 'header.php';


$success = 0;
if($_SERVER["REQUEST_METHOD"] === "POST") {
    global $pdo;
    $arr = array(
        'id' => $_GET["id"],
        'organisme' => $_POST["organisme"],
        'adresse' => $_POST["adresse"],
        'type' => $_POST["type"],
        'sujet' => $_POST["sujet"],
        'description' => $_POST["description"]
    );
    $sql = "UPDATE stage SET organisme=:organisme, adresse=:adresse, type=:type, sujet=:sujet, description=:description where id=:id";
    $res = $pdo->prepare($sql);
    $res->execute($arr);
    $success = 1;

    if (isset($_POST['date_debut']) && count($_POST['date_debut']) > 0)
    {
        $x = 0;
        foreach ($_POST['date_debut'] as $key=>$row)
        {
            if($row !== '' and $_POST["date_fin"][$key] !== '') {
                $sql = "UPDATE plage_horaire SET date_debut=:date_debut, date_fin=:date_fin, id_stage=:id_stage WHERE id=:id";
                $res = $pdo->prepare($sql);
                $res->execute(array(
                    'id' => $_POST["ph_id"][$key],
                    'date_debut' => $row,
                    'date_fin' => $_POST["date_fin"][$key],
                    'id_stage' => $_GET["id"]
                ));
            }
        }
    }
}


$q = "select * from stage where id=:id";
$res = $pdo->prepare($q);
$res->execute(array('id' => $_GET["id"]));
$data = $res->fetch();
?>
<div class="container text-center ajouter-form">
    <form action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $_GET["id"] ?>" method="post">
        <div>
            <label for="organisme">Organisme</label>
            <input type="text" id="organisme" name="organisme" value="<?php echo $data["organisme"] ?>">
        </div>

        <div>
            <label for="adresse">adresse</label>
            <input type="text" name="adresse" id="adresse" value="<?php echo $data["adresse"] ?>">
        </div>

        <div>
            <label for="type">type</label>
            <input type="text" name="type" id="type" value="<?php echo $data["type"] ?>">
        </div>

        <div>
            <label for="sujet">sujet</label>
            <input type="text" name="sujet" id="sujet" value="<?php echo $data["sujet"] ?>">
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description" name="description" id="description" cols="50" rows="4"><?php echo $data["description"] ?></textarea>
        </div>

        <div>
            <label>Les Plages horaires: <a href="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $_GET["id"] . "&create_new_ph=1" ?>" class="btn btn-primary">Ajouter Plage horaire:</a></label>
            <table>
                <tbody id="ph">
                <?php 
                    $q = "select id, date_debut, date_fin from plage_horaire where id_stage=:id";
                    $res = $pdo->prepare($q);
                    $res->execute(array('id' => $_GET["id"]));
                    $x = 0;
                    while ($ph_data = $res->fetch())
                    {
                ?>
                <tr>
                        <td>
                            <label for="date_debut"></label>
                            <input type="text" hidden value="<?php echo $ph_data["id"] ?>" name="ph_id[<?php $x ?>]">
                            <input id="date_debut_<?php echo $ph_data["id"] ?>" type="date" name="date_debut[<?php echo $x; ?>]" value="<?php echo $ph_data["date_debut"] ?>">
                        </td>
                        <td>
                            <label for="date_fin"></label>
                            <input id="date_fin_<?php echo $ph_data["id"] ?>" type="date" name="date_fin[<?php echo $x; ?>]" value="<?php echo $ph_data["date_fin"] ?>">
                        </td>
                        <td>
                            <a class="btn btn-danger" href="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $_GET["id"] . "&ph_to_del=" . $ph_data["id"] ?>">supprimer</a>
                        </td>
                </tr>
                <?php 
                $x ++;
                    }
                ?>
                </tbody>
            </table>
        </div>
        <br />
        <button type="submit" class="btn btn-primary">Modifier</button>
        <?php if($success): ?>
        <span class="text-success">Vous avez modifié ce stage avec succes</span>
        <?php endif; ?>
    </form>
</div>