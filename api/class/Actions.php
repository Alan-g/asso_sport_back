<?php


class Actions
{

    public $id;
    public $libelle;
    public $description;
    public $trigramme;

    /**
     * Actions constructor.
     * @param $id
     * @param $libelle
     * @param $description
     */
    public function __construct($id, $libelle, $description,$trigramme)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->trigramme = $trigramme;
    }

}