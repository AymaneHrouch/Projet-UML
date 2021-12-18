<?php 
require_once 'respo_config.php';
$page_title = "Gestion Des Stages";
include 'header.php';


// function get_Etat(int $i){
//     if ($i==-1) {
//         return 'Pas Encore';
//     } else if ($i==0) {
//         return 'Annulé';
//     }
//     else if ($i==1) {
//         return 'Confirmé';
//     }
//     else {
//         throw new ErrorException("invalide input.");
//     }
// }

function is_confirmed(int $i) {
    global $pdo;
    $sql = "SELECT ETAT_DEMANDE FROM DEMANDE WHERE ID=:id";
    $res = $pdo->prepare($sql);
    $res->execute(array(
        'id' => $i
    ));
    $data = $res->fetch();
    return $data["etat_demande"];
}

?>
<div class="container">
    <h3 class="mb-4">Liste des demandes</h3>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">CNE</th>
                <th scope="col">NOM</th>
                <th scope="col">PRENOM</th>
                <th scope="col">FILIERE</th>
                <th scope="col">DATE DE NAISSANCE</th>
                <th scope="col">DEMANDE ECRIT</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
<?php
    $result = $pdo->query('select demande.id, cne, nom, prenom, filiere, date_de_naissance, demande_ecrit, etat_demande, id_stage, plage_horaire from etudiant, demande where demande.cne_etudiant = etudiant.cne order by date_envoye asc;');
    while($data = $result->fetch()) {
        ?>
        <tr>
            <td><?php echo $data["cne"] ?></td>
            <td><?php echo $data["nom"] ?></td>
            <td><?php echo $data["prenom"] ?></td>
            <td><?php echo $data["filiere"] ?></td>
            <td><?php echo $data["date_de_naissance"] ?></td>
            <td><?php echo $data["demande_ecrit"] ?></td>
            <?php if($data["etat_demande"] == -1): ?>
            <td><a class="btn btn-primary" href="confirmer?id=<?php echo $data["id"] ?>">Confirmer</a></td>
            <td><a class="btn btn-danger" href="annuler?id=<?php echo $data["id"] ?>">Annuler</a></td>
            <?php elseif($data["etat_demande"] == 0): ?>
            <td>Demande Annulé</td>
            <?php 
            // verifier si l etudiant a deja un stage, si oui, c'est pas la peine de donner l'option pour confirmer ce stage.
            $q = "select id from demande where etat_demande=1 and cne_etudiant=:cne";
            $res = $pdo->prepare($q);
            $res->execute(array('cne' => $data["cne"]));
            if(!$res->fetch()):
            ?>
            <td><a class="btn btn-primary" href="confirmer?id=<?php echo $data["id"] ?>">Confirmer</a></td>
            <?php else: ?>
            <td>Etudiant a déjà un stage.</td>
            <?php endif; ?>
            <?php elseif ($data["etat_demande"] == 1 && $data["plage_horaire"] == 0): ?>
            <td><a class="btn btn-primary" href="envoyer_stage.php?id_demande=<?php echo $data["id"] ?>">Envoyer Stage</a></td>
            <td><a class="btn btn-danger" href="annuler?id=<?php echo $data["id"] ?>">Annuler</a></td>
            <?php else: ?>
            <?php
                $sql = "select date_debut, date_fin from plage_horaire where id=:id";
                $res = $pdo->prepare($sql);
                $res->execute(array('id' => $data["plage_horaire"]));
                $d = $res->fetch();
            ?>
            <td>Inscrit à <a href="contenu?id=<?php echo $data["id_stage"] ?>">CE STAGE</a> <?php echo "De " . $d["date_debut"] . " à " . $d["date_fin"]?></td>
            <td><a onclick="return confirm('Etes vous sûr de vouloir annuler cette demande de stage?')" href="annuler?id=<?php echo $data["id"] ?>" class="btn btn-danger">Annuler</a></td>
            <?php endif; ?>
        </tr>
        <?php
    }
?>
        </tbody>
    </table>
</div>
</body>
</html>