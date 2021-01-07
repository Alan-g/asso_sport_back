<?php


class CoursDTO
{
    public $id;
    public $typeCours;
    public $salle;
    public $jour;
    public $heure_debut;
    public $heure_fin;
    public $prof;
    public $limite;
    public $effectif;
    public $idLink;

    /**
     * CoursDTO constructor.
     * @param $id
     * @param $typeCours
     * @param $salle
     * @param $jour
     * @param $heure_debut
     * @param $heure_fin
     * @param $prof
     * @param $limite
     * @param $effectif
     * @param $idLink
     */
    public function __construct($id, $typeCours, $salle, $jour, $heure_debut, $heure_fin, $prof, $limite, $effectif, $idLink)
    {
        $this->id = $id;
        $this->typeCours = $typeCours;
        $this->salle = $salle;
        $this->jour = $jour;
        $this->heure_debut = $heure_debut;
        $this->heure_fin = $heure_fin;
        $this->prof = $prof;
        $this->limite = $limite;
        $this->effectif = $effectif;
        $this->idLink = $idLink;
    }


}