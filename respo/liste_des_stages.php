<?php 
require_once 'respo_config.php';
$page_title = "Gestion Des Stages";
include 'header.php';
?>
<div class="container">
    <h3 class="mb-4">Les Stages Agrées par l'ENSA</h3>
    <a href="ajouter.php" class="btn btn-primary my-2">Ajouter</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Organisme</th>
                <th scope="col">Adresse</th>
                <th scope="col">Sujet</th>
                <th scope="col">Type</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
<?php
    $result = $pdo->query('select id, organisme, adresse, sujet, type from stage order by id asc');
    while($data = $result->fetch()) {
        ?>
        <tr>
            <td><?php echo $data["id"] ?></td>
            <td><?php echo $data["organisme"] ?></td>
            <td><?php echo $data["adresse"] ?></td>
            <td><?php echo $data["sujet"] ?></td>
            <td><?php echo $data["type"] ?></td>
            <td><a href="contenu.php?id=<?php echo $data["id"] ?>">Desc</a></td>
            <td><a href="modifier?id=<?php echo $data["id"] ?>">Modifier</a></td>
            <td><a href="supprimer.php?id=<?php echo $data["id"] ?>" onclick="return confirm('Vous êtes sur le point de supprimer ce stage définitivement. Etes vous sûr?')">Supprimer</a></td>
        </tr>
        <?php
    }
?>
        </tbody>
    </table>
</div>
</body>
</html>