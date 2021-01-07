<?php


class CreateRoleCommand
{

    public $libelle;

    /**
     * @param $data
     *
     * @return CreateRoleCommand
     */
    public static function init($data){
        $commande = new CreateRoleCommand();
        $commande->libelle = $data["libelle"];
        return $commande;
    }


}