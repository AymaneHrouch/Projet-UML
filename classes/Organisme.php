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