<?php


class UpdateUserCommand
{
    public $idRole;
    public $username;

    /**
     * @param $data
     *
     * @return UpdateUserCommand
     */
    public static function init($data){
        $commande = new UpdateUserCommand();
        $commande->idRole = $data["idRole"];
        $commande->username = $data["username"];
        return $commande;
    }
}