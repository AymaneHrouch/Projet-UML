<?php
require_once 'etudiant_config.php';
global $pdo;
$etudiant = $_SESSION["utilisateur"];
$page_title = 'Mon Stage';
include 'header.php';

if(isset($_POST["submit_rapport"])) {
    include 'upload.php';
}


if($_SERVER['REQUEST_METHOD']==='POST' && !isset($_POST["submit_rapport"])) {
    $query = $pdo->prepare('update demande set plage_horaire = :plage_horaire where etat_demande = 1 and cne_etudiant = :cne_etudiant');
    $query->execute(array(
        'cne_etudiant' => $etudiant->cne,
        'plage_horaire' => $_POST["plage_horaire_choisi"]
    ));
}

$query = $pdo->prepare('select id_stage from demande where etat_demande = 1 and cne_etudiant=:cne');
$query->execute(array(
    'cne' => $etudiant->cne
));
$id_stage = $query->fetch();
// if stage doesn't exist yet.
if(!$id_stage) {
    echo "<div class='container'>Vous n'avez pas encore un stage</div>";
    return;
}

$id_stage = $id_stage["id_stage"];
$q0 = ("select organisme, adresse, sujet, description from stage where id=:id_stage");
$res = $pdo->prepare($q0);
$res->execute(array(
    'id_stage' => $id_stage
));
$infos = $res->fetch();
$organisme = $infos['organisme'];
$adresse = $infos['adresse'];
$description = $infos['description'];
$sujet = $infos['sujet'];
?>

<div class="container">
    <h3>Félicitations! vous êtes approuvé à passer un stage.</h3>
    <p>Organisme: <?php echo $organisme ?></p>
    <p>Adresse: <?php echo $adresse ?></p>
    <p>Sujet: <?php echo $sujet ?></p>
    <p>Description: <?php echo $description ?></p>
    <?php 
        // si l'étudiant a choisi déjà la plage horaire.
        $query = $pdo->prepare('select plage_horaire from demande where etat_demande = 1 and cne_etudiant=:cne');
        $query->execute(array(
            'cne' => $etudiant->cne
        ));
        $plage_horaire = $query->fetch()["plage_horaire"];
        if($plage_horaire) {
            $q = "select date_debut, date_fin from plage_horaire where id = :id";
            $res = $pdo->prepare($q);
            $res->execute(array(
                'id' => $plage_horaire
            ));
            $data = $res->fetch();
            echo '<p>Plage horaire choisi: De ' . $data["date_debut"] . ' à ' . $data["date_fin"] . '</p>';
            

            // vérifier si l etudiant a deja depose le rapport
            $target_dir = "../rapports/";
            $q= "SELECT ID FROM DEMANDE WHERE CNE_ETUDIANT=:cne_etudiant AND ETAT_DEMANDE=1";
            $res = $pdo->prepare($q);
            $res->execute(array('cne_etudiant' => $etudiant->cne));
            $data = $res->fetch();
            $target_file = $target_dir . $etudiant->cne . "_" . $data["ID"] . ".pdf";
            if (!file_exists($target_file)):
    ?>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                Rapport:
                <input type="file" name="rapport" id="rapport_file">
                <input type="submit" value="Upload" name="submit_rapport">
                <?php if(isset($_POST["submit_rapport"]) && $upload_error): ?>
                    <span class="text-danger"><?php echo $upload_error ?></span>
                <?php elseif(isset($_POST["submit_rapport"]) && $upload_info): ?>
                    <span class="text-info"><?php echo $upload_info ?></span>
                <?php endif; ?>
            <?php else: ?>
                <?php $note_final = 0;
                function getNote($note) {
                    if($note) {
                       return $note . "/20"; 
                    } else return "En attente.";
                }

                $q = "select note1, note2, note3 from rapport where id_demande=(SELECT ID FROM DEMANDE WHERE CNE_ETUDIANT=:cne_etudiant AND ETAT_DEMANDE=1)";
                $res = $pdo->prepare($q);
                $res->execute(array('cne_etudiant' => $etudiant->cne));
                $data = $res->fetch();
                if(!in_array('-1', $data)) {
                    $note_final = ($data["note1"] + $data["note2"] + $data["note3"]) / 3;
                    $note_final = round($note_final, 2);
                }
                
                
                ?>
                <span>VOUS AVEZ DEPOSE LE RAPPORT</span>
                <br />
                <span>NOTE FINAL : <?php echo getNote($note_final); ?></span>
            <?php endif; ?>
            </form>
    <?php
            return;
        }
        $q = "select id, date_debut, date_fin from plage_horaire where id_stage = :id_stage";
        $res = $pdo->prepare($q);
        $res->execute(array(
            'id_stage' => $id_stage
        ));
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" onsubmit="return valider_choix()">
        <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Début</th>
                                <th scope="col">Fin</th>
                            </tr>
                            </thead>
                            <tbody>
                        <?php while($data = $res->fetch()) { 
                        ?>
                            <tr>
                                <td scope="col">
                                    <input class="form-check-input" type="radio" 
                                        name="plage_horaire_choisi" id="radio-<?php echo $data["id"]?>"
                                        value="<?php echo $data["id"] ?>"
                                        >
                                    <label class="form-check-label" for="radio-<?php echo $data["id"]?>"><-----</label>
                                </td>
                                <td scope="col"><?php echo $data["date_debut"] ?></td>
                                <td scope="col"><?php echo $data["date_fin"] ?></td>
                            </tr>
                        <?php } ?>
                            </tbody>
        </table>
        <button type="submit" class="btn btn-primary" id="submit">Communiquer Choix</button>
    </form>
</div>
<script>
    function valider_choix(){
        no_input_is_checked = Array.from(document.querySelectorAll("input")).every(e => e.checked === false);
        if(no_input_is_checked) {
            alert("vous n'avez pas selectioné un choix!!");
            return false;
        }
        return true;
    }
</script>
<?php include 'footer.php' ?>