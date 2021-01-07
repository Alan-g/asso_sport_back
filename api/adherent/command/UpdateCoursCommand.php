<?php


class UpdateCoursCommand
{
    public $idCours;
    public $typeCoursId;
    public $idSalle;
    public $profId;
    public $jour;
    public $heureDebut;
    public $heurefin;
    public $limite;


    /**
     * @param $id
     * @param $data
     *
     * @return UpdateCoursCommand
     */
    public static function init($id, $data)
    {
        if ($id != $data['idCours']) {
            throw new assoEception("Identifiant du cours incorrect impossible de le mettre à jour", 400);
        }
        $commande = new UpdateCoursCommand();
        $commande->idCours= $data['idCours'];
        $commande->typeCoursId = $data['typeCoursId'];
        $commande->profId = $data['profId'];
        $commande->heureDebut = $data['heureDebut'];
        $commande->heurefin = $data['heurefin'];
        $commande->limite = $data['limite'];
        $commande->jour = $data['jour'];
        $commande->idSalle = $data['idSalle'];


        return $commande;
    }


}