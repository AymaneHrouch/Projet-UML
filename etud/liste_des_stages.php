<?php
require_once 'etudiant_config.php';
$page_title = "Liste Des Stages";
?>

<?php include 'header.php'; ?>
<div class="container">
    <h3 class="mb-4">Les Stages Agrées par l'ENSA</h3>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Organisme</th>
                <th scope="col">Adresse</th>
                <th scope="col">Sujet</th>
                <th scope="col">Type</th>
            </tr>
        </thead>
        <tbody>
<?php
    $result = $pdo->query('select organisme, adresse, sujet, type from stage');
    while($data = $result->fetch()) {
        ?>
        <tr>
            <td><?php echo $data["organisme"] ?></td>
            <td><?php echo $data["adresse"] ?></td>
            <td><?php echo $data["sujet"] ?></td>
            <td><?php echo $data["type"] ?></td>
        </tr>
        <?php
    }
?>
        </tbody>
    </table>
</div>
</body>
</html>