<?php 
require_once 'respo_config.php';
require_once '../classes/Etudiant.php';


if($_SERVER["REQUEST_METHOD"] === 'POST') {
    $sql = "UPDATE DEMANDE SET id_stage=:id_stage WHERE id=:id_demande";
    $res = $pdo->prepare($sql);
    $res->execute(array(
        'id_demande' => $_GET["id_demande"],
        'id_stage' => $_POST["id_stage_choisi"]
    ));
    header ('location: liste_des_demandes.php');
    // echo var_dump($_POST["id_stage_choisi"]);
}

$sql = "select cne_etudiant from demande where id=:id";
$res = $pdo->prepare($sql);
$res->execute(array(
    'id' => $_GET["id_demande"]
));
$data = $res->fetch();

$e = new Etudiant($data["cne_etudiant"]);
$page_title = "Gestion Des Stages";
include 'header.php';
?>
<div class="container">
    <h3 class="mb-4"><?php echo "Envoyer un stage à l'etudiant " . $e->nom . " " . $e->prenom ?></h3>
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>?id_demande=<?php echo $_GET["id_demande"] ?>" method="post">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Id</th>
                    <th scope="col">Organisme</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Sujet</th>
                    <th scope="col">Type</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
        <?php
            $result = $pdo->query('select id, organisme, adresse, sujet, type from stage order by id asc');
            while($data = $result->fetch()) {
        ?>
            <tr>
                <td>
                    <input class="form-check-input" type="radio" 
                        name="id_stage_choisi" id="radio-<?php echo $data["id"]?>"
                        value="<?php echo $data["id"] ?>"
                >
                </td>
                <td><?php echo $data["id"] ?></td>
                <td><?php echo $data["organisme"] ?></td>
                <td><?php echo $data["adresse"] ?></td>
                <td><?php echo $data["sujet"] ?></td>
                <td><?php echo $data["type"] ?></td>
                <td><a href="contenu.php?id=<?php echo $data["id"] ?>">Desc</a></td>
            </tr>
            <?php
        }
    ?>
            </tbody>
        </table>
        <button class="btn btn-primary">Envoyer</button>
    </form>
</div>
</body>
</html>