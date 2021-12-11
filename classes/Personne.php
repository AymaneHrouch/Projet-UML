<?php 

abstract class Personne {
    public $nom;
    public $prenom;
    public $adresse;
    public $dateDeNaissance;

    function __construct($cni, $nom, $prenom, $adresse="", $dateDeNaissance="") {
        $this->cni = $cni;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->dateDeNaissance = $dateDeNaissance;
    }
};





















?>