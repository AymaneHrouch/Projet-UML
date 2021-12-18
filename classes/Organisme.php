<?php
    class Organisme
    {
        public function __construct(int $id, string $nom, string $adresse)
        {
            $this->id = $id;
            $this->nom = $nom;
            $this->$adresse = $adresse;
        }
        
        public $id;
        public $nom;
        public $adresse;
    }
?>


select organisme_id from stage where id = stage_id
select * from organisme where id = organisme_id;