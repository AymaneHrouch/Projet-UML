<?php

class Responsable
{
    public $CNI;
    function AffecterStage(string $CNE, int $id_stage)
    {
        include_once "config.php";
        $sql = "UPDATE etudiant SET id_stage = :id_stage WHERE CNE = :CNE";
        $que = $pdo->prepare($sql);
        $que->execute(array(
            'id_stage' => $id_stage,
            'CNI' => $CNE
        ));
    }
}
?>