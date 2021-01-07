<?php


class Prof
{
    /**
     * Prof constructor.
     * @param $id
     * @param $nom
     * @param $prenom
     * @param $annee
     * @param $mail
     * @param $telephone
     */
    public function __construct($id, $nom, $prenom, $annee, $mail, $telephone)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->annee = $annee;
        $this->mail = $mail;
        $this->telephone = $telephone;
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

    public $id;
    public $nom;
    public $prenom;
    public $annee;
    public $mail;
    public $telephone;


}