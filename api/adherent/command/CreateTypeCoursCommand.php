<?php


class CreateTypeCoursCommand
{
    public $libelle;


    /**
     * @param $data
     *
     * @return CreateTypeCoursCommand
     */
    public static function init($data)
    {
        $commande = new CreateTypeCoursCommand();
        $commande->libelle = $data['libelle'];

        return $commande;
    }


}