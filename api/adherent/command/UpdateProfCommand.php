<?php


class UpdateProfCommand
{
    public $idProf;
    public $nom;
    public $prenom;
    public $mail;
    public $telephone;


    /**
     * @param $id
     * @param $data
     *
     * @return UpdateProfCommand
     */
    public static function init($id,$data){
        if ($id != $data['idProf']){
            throw new assoEception("Identifiant du professeur incorrect impossible de le mettre à jour", 400);
        }
        $commande = new UpdateProfCommand();
        $commande->idProf = $data['idProf'];
        $commande->nom = $data['nom'];
        $commande->prenom = $data['prenom'];
        $commande->mail = $data['mail'];
        $commande->telephone = $data['telephone'];

        return $commande;
    }


}