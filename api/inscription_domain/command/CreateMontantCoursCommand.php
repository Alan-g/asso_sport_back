<?php


class CreateMontantCoursCommand
{
    public $nombre;
    public $montant;


    /**
     * @param $data
     *
     * @return CreateMontantCoursCommand
     */
    public static function init($data){
        $commande = new CreateMontantCoursCommand();
        $commande->nombre = $data['nombre'];
        $commande->montant = $data['montant'];

        return $commande;
    }


}