<?php


class Annee
{

    public $id;
    public $libelle;
    public $actif;

    /**
     * Annee constructor.
     * @param $id
     * @param $libelle
     * @param $actif
     */
    public function __construct($id, $libelle, $actif)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->actif = $actif;
    }

}