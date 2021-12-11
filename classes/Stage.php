<?php 

class Stage {
    public $id;
    public $organisme;
    public $note;

    function _construst(int $id, Organisme $organisme, float $note) {
        $this->id = $id;
        $this->organisme = $organisme;
        $this->note = $note;
    }
}
?>