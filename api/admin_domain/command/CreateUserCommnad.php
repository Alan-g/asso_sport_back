<?php


class CreateUserCommnad
{

    public $idRole;
    public $username;
    public $password;

    /**
     * @param $data
     *
     * @return CreateUserCommnad
     */
    public static function init($data){
        $commande = new CreateUserCommnad();
        $commande->idRole = $data["idRole"];
        $commande->username = $data["username"];
        $commande->password = $data["password"];
        return $commande;
    }
}