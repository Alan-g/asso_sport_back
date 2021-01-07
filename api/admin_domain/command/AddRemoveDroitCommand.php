<?php


class AddRemoveDroitCommand
{

    public  $idDroit;
    public $idRole;

    /**
     * @param $data
     * @param $idRole
     *
     * @return AddRemoveDroitCommand
     */
    public static function init($data, $idRole){
        $commande = new AddRemoveDroitCommand();
        $commande->idRole =$idRole;
        $commande->idDroit = $data["idDroit"];
        return $commande;
    }

    /**
     * @param $idDroit
     * @param $idRole
     *
     * @return AddRemoveDroitCommand
     */
    public static function initDelete($idDroit, $idRole){
        $commande = new AddRemoveDroitCommand();
        $commande->idRole =$idRole;
        $commande->idDroit = $idDroit;
        return $commande;
    }

}