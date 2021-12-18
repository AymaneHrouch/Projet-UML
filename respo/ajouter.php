<?php
require_once 'respo_config.php';
$page_title = "Ajouter Stage";
include 'header.php';
$success = 0;
if($_SERVER["REQUEST_METHOD"] === "POST") {
    global $pdo;
    $sql = "INSERT INTO stage(organisme, adresse, type, sujet, description) VALUES(:organisme, :adresse, :type, :sujet, :description)";
    $res = $pdo->prepare($sql);
    $res->execute(array(
        'organisme' => $_POST["organisme"],
        'adresse' => $_POST["adresse"],
        'type' => $_POST["type"],
        'sujet' => $_POST["sujet"],
        'description' => $_POST["description"]
    ));
    $success = 1;
    $sql = "select max(id) from stage limit 1";
    $res = $pdo->query($sql);
    $id_new_stage = $res->fetch()["max(id)"];
    if (count($_POST['date_debut']) > 0)
    {
        $x = 0;
        foreach ($_POST['date_debut'] as $key=>$row)
        {
            if($row !== '' and $_POST["date_fin"][$key] !== '') {
                $sql = "INSERT INTO plage_horaire(date_debut, date_fin, id_stage) VALUES(:date_debut, :date_fin, :id_stage)";
                $res = $pdo->prepare($sql);
                $res->execute(array(
                    'date_debut' => $row,
                    'date_fin' => $_POST["date_fin"][$key],
                    'id_stage' => $id_new_stage
                ));
            }
        }
    }
    
}
?>
<div class="container text-center ajouter-form">
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <div>
            <label for="organisme">Organisme</label>
            <input type="text" id="organisme" name="organisme">
        </div>

        <div>
            <label for="adresse">adresse</label>
            <input type="text" name="adresse" id="adresse">
        </div>

        <div>
            <label for="type">type</label>
            <input type="text" name="type" id="type">
        </div>

        <div>
            <label for="sujet">sujet</label>
            <input type="text" name="sujet" id="sujet">
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description" name="description" id="description" cols="50" rows="4"></textarea>
        </div>

        <div>
            <label>Les Plages horaires: <button type="button" class="btn btn-primary" onclick="ajouter_ph()">Ajouter Plage horaire:</button></label>
            <table>
                <tbody id="ph">
                <tr>
                        <td>
                            <label for="date_debut"></label>
                            <input id="date_debut" type="date" name="date_debut[0]">
                        </td>
                        <td>
                            <label for="date_fin"></label>
                            <input id="date_fin" type="date" name="date_fin[0]">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br />
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <?php if($success): ?>
        <span class="text-success">Vous avez ajouté un stage avec succes</span>
        <?php endif; ?>
    </form>
</div>
<script>
    x = 0;
    const delete_ph = e => {
        e.target.parentElement.parentElement.remove()
        x--;
    }
    const ajouter_ph = () => {
        console.log(x++)
       $('#ph').append(`
       <tr>
            <td>
                <label for="date_debut[${x}]"></label>
                <input id="date_debut[${x}]" type="date" name="date_debut[${x}]">
            </td>
            <td>
                <label for="date_fin[${x}]"></label>
                <input id="date_fin[${x}]" type="date" name="date_fin[${x}]">
            </td>
            <td>
                <a class="btn btn-danger" onclick="delete_ph(event)">supprimer</a>
            </td>
        </tr>
       `)
    }
</script>