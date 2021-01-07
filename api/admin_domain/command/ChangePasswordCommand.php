<?php


class ChangePasswordCommand
{

    public $oldPassword;
    public $newPassword;

    /**
     * @param $data
     *
     * @return ChangePasswordCommand
     */
    public static function init($data){
        $commande = new ChangePasswordCommand();
        $commande->oldPassword = $data["oldPassword"];
        $commande->newPassword = $data["newPassword"];
        return $commande;
    }
}