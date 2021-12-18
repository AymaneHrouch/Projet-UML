<?php
require_once 'respo_config.php';

$sql = "select organisme, adresse, type, sujet, description from stage where id=:id";
global $pdo;
$result = $pdo->prepare($sql);
$result->execute(array(
    'id' => $_GET["id"]
));
$data = $result->fetch();
include 'header.php';
?>
    <div class="container">
        <h2>Infos du stage</h2>
        <?php 
        if(!$data) {
            echo '<div class="container">Invalid Id.</div>';
            return;
        }
        echo "<p>Organisme: ". $data["organisme"] ." </p>";
        echo "<p>Adresse: ". $data["adresse"] ." </p>";
        echo "<p>type: ". $data["type"] ." </p>";
        echo "<p>sujet: ". $data["sujet"] ." </p>";
        echo "<p>description: ". $data["description"] ." </p>";
        $sql = "select date_debut, date_fin from plage_horaire where id_stage = :id_stage";
        $result = $pdo->prepare($sql);
        $result->execute(array(
            'id_stage' => $_GET["id"]
        ));
        echo "<p>Plages horaires Disponibles:</p>";
        while($data = $result->fetch())
            echo "<p>" . $data["date_debut"] . " à " . $data["date_fin"] . "</p>";
        ?>
    </div>
</body>
</html>