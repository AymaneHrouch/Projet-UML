<?php 
require_once 'etudiant_config.php';
$page_title = "Liste Des Demandes";
include 'header.php';


function get_Etat(int $i){
    if ($i==-1) {
        return 'En attente';
    } else if ($i==0) {
        return 'Annulé';
    }
    else if ($i==1) {
        return 'Confirmé';
    }
    else {
        throw new ErrorException("invalide input.");
    }
}
?>

<div class="container">
    <h3 class="mb-4">Liste des demandes</h3>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Date Envoyé</th>
                <th scope="col">Text du demande</th>
                <th scope="col">Etat</th>
            </tr>
        </thead>
        <tbody>
<?php
    $result = $pdo->prepare('select date_envoye, demande_ecrit, etat_demande from demande where cne_etudiant=:cne_etudiant');
    $result->execute(array(
        'cne_etudiant' => $_SESSION["utilisateur"]->cne
    ));
    while($data = $result->fetch()) {
        ?>
        <tr>
            <td><?php echo $data["date_envoye"] ?></td>
            <td><?php echo $data["demande_ecrit"] ?></td>
            <th><?php echo get_Etat($data["etat_demande"]) ?></th>
        </tr>
        <?php
    }
?>
        </tbody>
    </table>
</div>



<?php
include 'footer.php';
?>