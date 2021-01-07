<?php


class UpdateInscriptionCommand
{
    public $idAdherent;
    public $idInscription;
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
     * @param $data
     *
     * @return UpdateInscriptionCommand
     */
    public static function init($id,$data){
        if ($id != $data['idInscription']){
            throw new assoEception("Identifiant de l'inscription incorrect impossible de le mettre à jour", 400);
        }
        $commande = new UpdateInscriptionCommand();
        $commande->idInscription = $data['idInscription'];
        $commande->idAdherent = $data['idAdherent'];
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

        return $commande;
    }


}