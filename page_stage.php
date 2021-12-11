<?php
function AfficherLesStages($bResponsable = false)
{
    include 'config.php';
    $result = $pdo->query('select nom, adresse, date_debut, date_fin from organisme, stage where stage.id_organisme = organisme.id');
    
    echo "les stages disponibles:<br />";

    echo "<table>";
    echo "<tr>";
    echo "<th>Nom de l'organism</th>";
    echo "<th>Adresse</th>";
    echo "<th>Date de debut</th>";
    echo "<th>Date de fin</th>";
    echo "</tr>";

    while($data = $result->fetch()) {
        echo "<tr>";
        echo "<td>{$data["nom"]}</td>";
        echo "<td>{$data["adresse"]}</td>";
        echo "<td>{$data["date_debut"]}</td>";
        echo "<td>{$data["date_fin"]}</td>";
        echo "</tr>";
    }
}
?>