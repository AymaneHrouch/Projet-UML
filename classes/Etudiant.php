<?php 

require_once __DIR__ . '/Personne.php';

class Etudiant {
    public $cne;
    public $stage;
    public $prenom;
    public $nom;


    public function __construct(string $cne)
    {
        $this->cne = $cne;
        $this->load_info();
    }

    public function load_info() {
        global $pdo;
        $sql = "select cne, prenom, nom from etudiant where cne='" . $this->cne . "'";
        $sth = $pdo->prepare($sql);
        $sth->execute(array(
            'cne' => $this->cne
        ));
        $data = $sth->fetch();
        $this->cne = $data["cne"];
        $this->prenom = $data["prenom"];
        $this->nom = $data["nom"];
    }
    
    public function demanderStage() {
        global $pdo;
        $sql = "INSERT INTO demande(cne_etudiant) VALUES(:cne)";
        $que = $pdo->prepare($sql);
        $que->execute(array(
            'cne' => $this->cne
        ));
        return 1;
    }

    public function communiquerChoix(int $id) {
        global $pdo;
        $sql = "UPDATE stage_choix SET choisi = 1 WHERE id = " . $id;
        $pdo->exec($sql);
        return 1;
    }

    public function a_choisi() {
        require_once __DIR__ . '/../config.php';
        $sql = "select id, id_stage from stage_choix where choisi = 1 and cne_etudiant = '" . $this->cne . "'";
        global $pdo;
        $result = $pdo->query($sql);
        return $result->fetch();
    }
}
?>