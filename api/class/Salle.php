<?php


class Salle
{

    public $id;
    public $libelle;
    public $capacite;

    /**
     * Salle constructor.
     * @param $id
     * @param $libelle
     * @param $capacite
     */
    public function __construct($id, $libelle, $capacite)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->capacite = $capacite;
    }


}