<?php
function AfficherLesStages($bResponsable = false)
{
    include_once 'config.php';
    $result = $pdo->query('select stage.id, nom, adresse, date_debut, date_fin from organisme, stage where stage.id_organisme = organisme.id');
    
    echo '
    les stages disponibles:<br />
    <table>
    <tr>
    <th>Nom de l\'organisme</th>
    <th>Adresse</th>
    <th>Date de debut</th>
    <th>Date de fin</th>
    </tr>';
    
    if ($bResponsable)
    {
        echo '<a href="ajouter_stage.php">New</a>';
    }
    
    while($data = $result->fetch()) {
        echo "
        <tr>
        <td>{$data["nom"]}</td>
        <td>{$data["adresse"]}</td>
        <td>{$data["date_debut"]}</td>
        <td>{$data["date_fin"]}</td>";
        if($bResponsable)
        {
            echo "
                <td><a href=\"modifier_stage.php?id=".$data['id']."\">Modifier</a></td>
                <td><a href=\"supprimer_stage.php?id=".$data['id']."\">Supprimer</a></td>
            ";
        }
        echo "</tr>";
    }
}
?>