<?php


class UpdateMontantCoursCommand
{
    public $montant;


    /**
     * @param $data
     *
     * @return UpdateMontantCoursCommand
     */
    public static function init($data){
        $commande = new UpdateMontantCoursCommand();
        $commande->montant = $data['montant'];

        return $commande;
    }


}