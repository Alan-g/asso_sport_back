<?php


class ExtractionAdherentCours
{

    public $coursLibelle;
    public $courJour;
    public $courDateDebut;
    public $courDateFin;
    public $extractions;
    public $prof;

    /**
     * ExtractionAdherentCours constructor.
     * @param $coursLibelle
     * @param $courJour
     * @param $courDateDebut
     * @param $courDateFin
     * @param $extractions
     */
    public function __construct($coursLibelle, $courJour, $courDateDebut, $courDateFin, $extractions,$prof)
    {
        $this->coursLibelle = $coursLibelle;
        $this->courJour = $courJour;
        $this->courDateDebut = $courDateDebut;
        $this->courDateFin = $courDateFin;
        $this->extractions = $extractions;
        $this->prof = $prof;
    }


}