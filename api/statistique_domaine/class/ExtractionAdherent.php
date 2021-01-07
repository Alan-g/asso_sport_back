<?php


class ExtractionAdherent
{

    public $nom;
    public $prenom;
    public $mail;
    public $tel;

    /**
     * ExtractionAdherent constructor.
     * @param $nom
     * @param $prenom
     * @param $mail
     * @param $tel
     */
    public function __construct($nom, $prenom, $mail, $tel)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
        $this->tel = $tel;
    }

}