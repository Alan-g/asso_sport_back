<?php


class Adherent
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
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @return mixed
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }

    /**
     * @return mixed
     */
    public function getAdresse2()
    {
        return $this->adresse2;
    }

    /**
     * @return mixed
     */
    public function getAdresse3()
    {
        return $this->adresse3;
    }

    /**
     * @return mixed
     */
    public function getCodePostal()
    {
        return $this->code_postal;
    }

    /**
     * @return mixed
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @return mixed
     */
    public function getDateNaissance()
    {
        return $this->date_naissance;
    }
    public $id;
    public $genre;
    public $nom;
    public $prenom;
    public $adresse1;
    public $adresse2;
    public $adresse3;
    public $code_postal;
    public $commune;
    public $telephone;
    public $mail;
    public $date_naissance;

    /**
     * Adherent constructor.
     * @param $genre
     * @param $nom
     * @param $prenom
     * @param $adresse1
     * @param $adresse2
     * @param $adresse3
     * @param $code_postal
     * @param $commune
     * @param $téléphone
     * @param $mail
     * @param $date_naissance
     */
    public function __construct($id,$genre, $nom, $prenom, $adresse1, $adresse2, $adresse3, $code_postal, $commune, $téléphone, $mail, $date_naissance)
    {
        $this->id = $id;
        $this->genre = $genre;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse1 = $adresse1;
        $this->adresse2 = $adresse2;
        $this->adresse3 = $adresse3;
        $this->code_postal = $code_postal;
        $this->commune = $commune;
        $this->telephone = $téléphone;
        $this->mail = $mail;
        $this->date_naissance = $date_naissance;
    }
}