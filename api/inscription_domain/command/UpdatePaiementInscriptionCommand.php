<?php


class UpdatePaiementInscriptionCommand
{
    public $paiements;
    public $idInscription;

    /**
     * @param $data
     *
     * @return UpdatePaiementInscriptionCommand
     */
    public static function init($id,$data){
        $commande = new UpdatePaiementInscriptionCommand();
        if ($id != $data['idInscription']){
            throw new assoEception("Identifiant de l'inscription incorrect impossible de le mettre à jour", 400);
        }
        $paiementArray = array();
        foreach ($data['paiements'] as $paiement){
            array_push($paiementArray,new Paiement( $paiement['id'], $paiement['nom_payeur'], $paiement['montant'], $paiement['banque'], $paiement['dateEncaissement'], $paiement['numeroCheque'],$data['annee']));
        }
        $commande->paiements = $paiementArray;
        $commande->idInscription = $data['idInscription'];


        return $commande;
    }


}