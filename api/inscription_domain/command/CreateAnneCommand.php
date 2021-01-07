<?php


class CreateAnneCommand
{

    public $libelle;
    public $profs;
    public $cours;


    /**
     * @param $data
     *
     * @return CreateAnneCommand
     */
    public static function init($data){
        $commande = new CreateAnneCommand();
        $commande->libelle = $data['libelle'];
        $commande->profs = $data['profs'];
        $commande->cours = $data['cours'];

        return $commande;
    }

}