<?php 

class Stage {
    public $id;
    public $organisme;
    public $note;

    function _construst(int $id) {
        $this->id = $id;
    }

    function get_details() {
        echo "hhhhhhhhhhhhh" .  $this->id . "xxxxxxxxxxxxxx";
        $sql = "select infos from stage where id=2";
        global $pdo;
        $result = $pdo->query($sql);
        return $result->fetch();
    }
}
?>