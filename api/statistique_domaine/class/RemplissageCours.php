<?php


class RemplissageCours
{
    public $lundi;
    public $mardi;
    public $mercredi;
    public $jeudi;
    public $vendredi;
    public $samedi;
    public $dimanche;

    /**
     * RemplissageCours constructor.
     */
    public function __construct()
    {
        $this->lundi = array();
        $this->mardi = array();
        $this->mercredi = array();
        $this->jeudi = array();
        $this->vendredi = array();
        $this->samedi = array();
        $this->dimanche = array();
    }


}

class ColumnChartCours {
    public $effectif;
    public $limite;
    public $pourcentage;
    public $libelleType;
    public $heureDebut;
    public $heureFin;

    /**
     * ColumnChartCours constructor.
     * @param $effectif
     * @param $limite
     * @param $libelleType
     * @param $heureDebut
     * @param $heureFin
     */
    public function __construct($effectif, $limite, $libelleType, $heureDebut, $heureFin)
    {
        $this->effectif = $effectif;
        $this->limite = $limite;
        $this->libelleType = $libelleType;
        $this->heureDebut = $heureDebut;
        $this->heureFin = $heureFin;
        $this->pourcentage = round((($effectif/$limite)*100),1);
    }
}