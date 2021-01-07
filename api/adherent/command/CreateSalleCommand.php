<?php


class CreateSalleCommand
{
    public $libelle;
    public $capacite;


    /**
     * @param $data
     *
     * @return CreateSalleCommand
     */
    public static function init($data)
    {
        $commande = new CreateSalleCommand();
        $commande->libelle = $data['libelle'];
        $commande->capacite = $data['capacite'];

        return $commande;
    }


}