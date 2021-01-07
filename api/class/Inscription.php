<?php


class Inscription
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
    public function getIdAdherent()
    {
        return $this->idAdherent;
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
    public function getCertificat()
    {
        return $this->certificat;
    }

    /**
     * @return mixed
     */
    public function getEnveloppe()
    {
        return $this->enveloppe;
    }

    /**
     * @return mixed
     */
    public function getReglement()
    {
        return $this->reglement;
    }

    /**
     * @return mixed
     */
    public function getComiteEntreprise()
    {
        return $this->comite_entreprise;
    }

    /**
     * @return mixed
     */
    public function getAutorisationParental()
    {
        return $this->autorisation_parental;
    }

    /**
     * @return mixed
     */
    public function getCommentaire()
    {
        return $this->commentaire;
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
    public function getQuestionnaireSante()
    {
        return $this->questionnaire_sante;
    }

    /**
     * @return mixed
     */
    public function getDateEnvoiCe()
    {
        return $this->date_envoi_ce;
    }

    /**
     * @return mixed
     */
    public function getReglementInterieur()
    {
        return $this->reglement_interieur;
    }

    /**
     * @return mixed
     */
    public function getEssai()
    {
        return $this->essai;
    }

    /**
     * @return mixed
     */
    public function getCartMra()
    {
        return $this->cart_mra;
    }

    public $id;
    public $idAdherent;
    public $annee;
    public $certificat;
    public $enveloppe;
    public $reglement;
    public $comite_entreprise;
    public $autorisation_parental;
    public $commentaire;
    public $montant;
    public $questionnaire_sante;
    public $date_envoi_ce;
    public $reglement_interieur;
    public $essai;
    public $cart_mra;

    /**
     * Inscription constructor.
     * @param $id
     * @param $idAdherent
     * @param $annee
     * @param $certificat
     * @param $enveloppe
     * @param $reglement
     * @param $comite_entreprise
     * @param $autorisation_parental
     * @param $commentaire
     * @param $montant
     * @param $questionnaire_sante
     * @param $date_envoi_ce
     * @param $reglement_interieur
     * @param $essai
     * @param $cart_mra
     */
    public function __construct($id, $idAdherent, $annee, $certificat, $enveloppe, $reglement, $comite_entreprise, $autorisation_parental, $commentaire, $montant, $questionnaire_sante, $date_envoi_ce, $reglement_interieur, $essai, $cart_mra)
    {
        $this->id = $id;
        $this->idAdherent = $idAdherent;
        $this->annee = $annee;
        $this->certificat = $certificat;
        $this->enveloppe = $enveloppe;
        $this->reglement = $reglement;
        $this->comite_entreprise = $comite_entreprise;
        $this->autorisation_parental = $autorisation_parental;
        $this->commentaire = $commentaire;
        $this->montant = $montant;
        $this->questionnaire_sante = $questionnaire_sante;
        $this->date_envoi_ce = $date_envoi_ce;
        $this->reglement_interieur = $reglement_interieur;
        $this->essai = $essai;
        $this->cart_mra = $cart_mra;
    }


}