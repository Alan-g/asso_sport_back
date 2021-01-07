<?php


class RemoveCoursInscriptionCommand
{
    public $idCours;
    public $idInscription;

    /**
     * @param $data
     *
     * @return RemoveCoursInscriptionCommand
     */
    public static function init($id,$data){
        $commande = new RemoveCoursInscriptionCommand();
        if ($id != $data['idInscription']){
            throw new assoEception("Identifiant de l'inscription incorrect impossible de le mettre à jour", 400);
        }
        $coursArray = array();
        foreach ($data['idCours'] as $cour){
            array_push($coursArray,$cour);
        }
        $commande->idCours = $coursArray;
        $commande->idInscription = $data['idInscription'];


        return $commande;
    }


}