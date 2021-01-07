<?php


class CreateProfCommand
{
    public $nom;
    public $prenom;
    public $mail;
    public $telephone;


    /**
     * @param $id
     * @param $data
     *
     * @return CreateProfCommand
     */
    public static function init($data){
        $commande = new CreateProfCommand();
        $commande->nom = $data['nom'];
        $commande->prenom = $data['prenom'];
        $commande->mail = $data['mail'];
        $commande->telephone = $data['telephone'];

        return $commande;
    }


}