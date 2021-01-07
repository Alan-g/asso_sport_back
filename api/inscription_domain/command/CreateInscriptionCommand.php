<?php


class CreateInscriptionCommand
{
    public $idAdherent;
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

    public $idCours;

    public $paiements;

    /**
     * @param $data
     *
     * @return CreateInscriptionCommand
     */
    public static function init($data){
        $commande = new CreateInscriptionCommand();
        $commande->idAdherent = $data['idAdherent'];
        $commande->genre = $data['genre'];
        $commande->nom = $data['nom'];
        $commande->prenom = $data['prenom'];
        $commande->adresse1 = $data['adresse1'];
        $commande->adresse2 = $data['adresse2'];
        $commande->adresse3 = $data['adresse3'];
        $commande->code_postal = $data['code_postal'];
        $commande->telephone = $data['telephone'];
        $commande->mail = $data['mail'];
        $commande->commune = $data['commune'];
        $commande->date_naissance = $data['date_naissance'];

        $commande->annee = $data['annee'];
        $commande->certificat = $data['certificat'];
        $commande->enveloppe = $data['enveloppe'];
        $commande->reglement = $data['reglement'];
        $commande->comite_entreprise = $data['comite_entreprise'];
        $commande->autorisation_parental = $data['autorisation_parental'];
        $commande->commentaire = $data['commentaire'];
        $commande->montant = $data['montant'];
        $commande->questionnaire_sante = $data['questionnaire_sante'];
        $commande->date_envoi_ce = $data['date_envoi_ce'];
        $commande->reglement_interieur = $data['reglement_interieur'];
        $commande->essai = $data['essai'];
        $commande->cart_mra = $data['cart_mra'];

        $coursArray = array();
        foreach ($data['idCours'] as $cour){
            array_push($coursArray,$cour);
        }
        $commande->idCours = $coursArray;

        $paiementArray = array();
        foreach ($data['paiements'] as $paiement){
            array_push($paiementArray,new Paiement( $paiement['id'], $paiement['nom_payeur'], $paiement['montant'], $paiement['banque'], $paiement['dateEncaissement'], $paiement['numeroCheque'],$commande->annee));
        }
        $commande->paiements = $paiementArray;

        return $commande;
    }


}