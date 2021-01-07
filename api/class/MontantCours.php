<?php


class MontantCours
{

    public $id;
    public $nombre;
    public $montant;

    /**
     * MontantCours constructor.
     * @param $id
     * @param $nombre
     * @param $montant
     */
    public function __construct($id, $nombre, $montant)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->montant = $montant;
    }

}