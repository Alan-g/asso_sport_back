<?php


class Paiement
{
    /**
     * @return mixed
     */
    public function getDateEncaissement()
    {
        return $this->dateEncaissement;
    }

    /**
     * @return mixed
     */
    public function getNumeroCheque()
    {
        return $this->numeroCheque;
    }
    /**
     * Paiement constructor.
     * @param $id
     * @param $nom_payeur
     * @param $montant
     * @param $banque
     * @param $dateEncaissement
     * @param $numeroCheque
     * @param $annee
     */
    public function __construct($id, $nom_payeur, $montant, $banque, $dateEncaissement, $numeroCheque, $annee)
    {
        $this->id = $id;
        $this->nom_payeur = $nom_payeur;
        $this->montant = $montant;
        $this->banque = $banque;
        $this->dateEncaissement = $dateEncaissement;
        $this->numeroCheque = $numeroCheque;
        $this->annee = $annee;
    }

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
    public function getNomPayeur()
    {
        return $this->nom_payeur;
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
    public function getBanque()
    {
        return $this->banque;
    }
    public $id;
    public $nom_payeur;
    public $montant;
    public $banque;
    public $dateEncaissement;
    public $numeroCheque;
    public $annee;

}