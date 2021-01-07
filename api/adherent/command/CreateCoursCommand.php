<?php


class CreateCoursCommand
{
    public $typeCoursId;
    public $idSalle;
    public $profId;
    public $jour;
    public $heureDebut;
    public $heurefin;
    public $limite;


    /**
     * @param $data
     *
     * @return CreateCoursCommand
     */
    public static function init($data)
    {
        $commande = new CreateCoursCommand();
        $commande->typeCoursId = $data['typeCoursId'];
        $commande->profId = $data['profId'];
        $commande->heureDebut = $data['heureDebut'];
        $commande->heurefin = $data['heurefin'];
        $commande->jour = $data['jour'];
        $commande->limite = $data['limite'];
        $commande->idSalle = $data['idSalle'];

        return $commande;
    }


}