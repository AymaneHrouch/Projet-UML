<?php
$page_title = "ENSA STAGES - PROF ESPACE";
require_once 'prof_config.php';
include 'header.php';
$prof_number = substr($_SESSION["mode"], 4, 1);
$success = 0;
if(isset($_GET["rapport_id"]) && isset($_GET["nv_note"])) {
    $q = "";
    switch ($prof_number) {
        case '1':
            $q = "update rapport set note1 = :nv_note where id=:id";
            break;
        case '2':
            $q = "update rapport set note2 = :nv_note where id=:id";
            break;
        case '3':
            $q = "update rapport set note3 = :nv_note where id=:id";
            break;
    }
    $res = $pdo->prepare($q);
    $res->execute(array('nv_note' => $_GET["nv_note"], 'id' => $_GET["rapport_id"]));
    $success = 1;
}


?>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Rapport</th>
                <th scope="col">Note</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <?php if($success): ?>
        <?php endif; ?>
        <tbody>
        <?php
            $q = "";
            switch ($prof_number) {
                case '1':
                    $q = "select id, filename, note1 from rapport order by id asc";
                    break;
                case '2':
                    $q = "select id, filename, note2 from rapport order by id asc";
                    break;
                case '3':
                    $q = "select id, filename, note3 from rapport order by id asc";
                    break;
            }
            $res = $pdo->query($q);
            while($data = $res->fetch())
            {
        ?>
            <tr>
                <td><a href="../rapports/<?php echo $data["filename"] . ".pdf" ?>"><?php echo "rapport_" . $data["id"] ?></a></td>
                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="get">
                <td><input type="number" step="0.01" value="<?php echo $data[2] ?>" name="nv_note" max="20"></td>
                <input type="text" hidden name="rapport_id" value="<?php echo $data["id"] ?>">
                <?php if($success && $_GET["rapport_id"] == $data["id"]):?>
                    <td><button class="btn btn-success px-4" id="sauv_msg">Sauvegardé!!</button></td>               
                <?php else: ?>
                    <td><button class="btn btn-primary px-5">NOTER</button></td>
                <?php endif; ?>
                </form>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>
<script>
    setTimeout(() => {
        document.getElementById("sauv_msg").innerHTML = "NOTER"
        document.getElementById("sauv_msg").classList.remove("btn-success")
        document.getElementById("sauv_msg").classList.remove("px-4")
        document.getElementById("sauv_msg").classList.add("btn-primary")
        document.getElementById("sauv_msg").classList.add("px-5")
    }, 3000);
</script>