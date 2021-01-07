<?php


class UpdateAdherentCommand
{
    public $idAdherent;
    public $genre;
    public $nom;
    public $prenom;
    public $adresse1;
    public $adresse2;
    public $adresse3;
    public $code_postal;
    public $commune;
    public $telephone;
    public $mail;
    public $date_naissance;

    /**
     * @param $id
     * @param $data
     *
     * @return UpdateAdherentCommand
     */
    public static function init($id,$data){
        if ($id != $data['idAdherent']){
            throw new assoEception("Identifiant de l'adhérent incorrect impossible de le mettre à jour", 400);
        }
        $commande = new UpdateAdherentCommand();
        $commande->idAdherent = $data['idAdherent'];
        $commande->genre = $data['genre'];
        $commande->nom = $data['nom'];
        $commande->prenom = $data['prenom'];
        $commande->adresse1 = $data['adresse1'];
        $commande->adresse2 = $data['adresse2'];
        $commande->adresse3 = $data['adresse3'];
        $commande->code_postal = $data['code_postal'];
        $commande->telephone = $data['telephone'];
        $commande->mail = $data['mail'];
        $commande->commune = $data['commune'];
        $commande->date_naissance = $data['date_naissance'];

        return $commande;
    }


}