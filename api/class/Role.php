<?php


class Role
{

    /**
     * @return mixed
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }
    public $id;
    public $libelle;

    /**
     * Role constructor.
     * @param $id
     * @param $libelle
     */
    public function __construct($id,$libelle)
    {
        $this->id = $id;
        $this->libelle = $libelle;
    }
}