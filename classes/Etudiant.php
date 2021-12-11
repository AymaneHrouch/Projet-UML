<?php 

require_once __DIR__ . '/Personne.php';

class Etudiant extends Personne {
    public $cne;
    public $nom;
    public $stage = NULL;

    public function __construct(string $cni, string $nom, string $prenom, string $adresse="", $ddn="", Stage $stage=null)
    {
        parent::__construct($cni, $nom, $prenom, $adresse, $ddn);
        $this->stage = $stage;
    }
}

?>