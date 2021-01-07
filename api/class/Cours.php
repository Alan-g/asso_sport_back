<?php


class Cours
{
    /**
     * @return mixed
     */
    public function getIdSalle()
    {
        return $this->id_salle;
    }

    /**
     * @return mixed
     */
    public function getEffectif()
    {
        return $this->effectif;
    }

    /**
     * @return mixed
     */
    public function getAnnee()
    {
        return $this->annee;
    }
    /**
     * @return mixed
     */
    public function getIdLink()
    {
        return $this->idLink;
    }

    /**
     * @param mixed $idLink
     */
    public function setIdLink($idLink)
    {
        $this->idLink = $idLink;
    }
    /**
     * @return mixed
     */
    public function getIdTypeCours()
    {
        return $this->id_type_cours;
    }

    /**
     * @return mixed
     */
    public function getHeureDebut()
    {
        return $this->heure_debut;
    }

    /**
     * @return mixed
     */
    public function getHeureFin()
    {
        return $this->heure_fin;
    }

    /**
     * @return mixed
     */
    public function getIdProf()
    {
        return $this->id_prof;
    }

    /**
     * @return mixed
     */
    public function getLimite()
    {
        return $this->limite;
    }
    /**
     * Cours constructor.
     * @param $id
     * @param $id_type_cours
     * @param $id_salle
     * @param $jour
     * @param $heure_debut
     * @param $heure_fin
     * @param $id_prof
     * @param $limte
     * @param $effectif
     * @param $annee
     */
    public function __construct($id, $id_type_cours,$id_salle, $jour, $heure_debut, $heure_fin, $id_prof, $limte, $effectif, $annee)
    {
        $this->id = $id;
        $this->id_type_cours = $id_type_cours;
        $this->id_salle = $id_salle;
        $this->jour = $jour;
        $this->heure_debut = $heure_debut;
        $this->heure_fin = $heure_fin;
        $this->id_prof = $id_prof;
        $this->limite = $limte;
        $this->idLink = null;
        $this->effectif = $effectif;
        $this->annee =  $annee;
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
    public function getJour()
    {
        return $this->jour;
    }

    public $id;
    public $id_type_cours;
    public $id_salle;
    public $jour;
    public $heure_debut;
    public $heure_fin;
    public $id_prof;
    public $limite;
    public $idLink;
    public $effectif;
    public $annee;



}