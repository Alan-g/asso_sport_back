<?php


class Remboursement
{
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    public $id;
    public $montant;
    public $date;

    /**
     * Remboursement constructor.
     * @param $id
     * @param $montant
     * @param $date
     */
    public function __construct($id, $montant, $date)
    {
        $this->id = $id;
        $this->montant = $montant;
        $this->date = $date;
    }
}