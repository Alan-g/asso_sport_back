<?php


class PaiementService extends Database
{

    /**
     * @param $paiement Paiement
     */
    public function create($paiement)
    {
        $query = "INSERT INTO `paiement`(`nom_payeur`, `montant`, `banque`,`date_encaissement`, `numero_cheque`, `id_annee`) VALUE ('" . $paiement->getNomPayeur() . "','" . $paiement->getMontant() . "','" . $paiement->getBanque() . "','" . $paiement->getDateEncaissement() . "','" . $paiement->getNumeroCheque() . "', (select id from annee  where libelle = '". $paiement->annee ."'))";
        return $this->insert($query);
    }

    /**
     * @param $paiement Paiement
     */
    public function update($paiement)
    {
        $query = "UPDATE `paiement` set `nom_payeur` =  '" . $paiement->getNomPayeur() . "',`montant` = '" . $paiement->getMontant() . "', `banque` = '" . $paiement->getBanque() . "',`date_encaissement` = '" . $paiement->getDateEncaissement() . "', `numero_cheque` = '" . $paiement->getNumeroCheque() . "' where id = '". $paiement->id ."'";
        return $this->insert($query);
    }


    public function link($idPaiement, $idInscription)
    {
        $query = "INSERT INTO `inscription_paiement`(`id_paiment`, `id_inscription`) VALUE ('$idPaiement','$idInscription')";
        return $this->insert($query);
    }
    public function linkExist($idPaiement, $idInscription)
    {
        $query = "SELECT * FROM `inscription_paiement`WHERE id_paiment = '$idPaiement' and id_inscription = '$idInscription'";
        $result =  $this->select($query);
        if ($result) {
            return true;
        } else {
            return null;
        }
    }

    public function getPaiementByInscription($idInscription)
    {
        $query = "SELECT paiement.* FROM paiement INNER JOIN inscription_paiement ON inscription_paiement.id_paiment = paiement.id WHERE  inscription_paiement.id_inscription = '$idInscription'";
        $result = $this->select($query);
        if (!$result) {
            return [];
        }
        $array = [];
        while ($paiement = $result->fetch_object()) {
            array_push($array, new Paiement($paiement->id, $paiement->nom_payeur, $paiement->montant, $paiement->banque, $paiement->date_encaissement, $paiement->numero_cheque, $paiement->id_annee));
        }
        return $array;
    }

    public function getByName($nom)
    {
        if (trim($nom) === "") {
            return null;
        }
        $query = "SELECT paiement.* FROM paiement INNER JOIN annee on annee.id = paiement.id_annee  WHERE  nom_payeur like '%$nom%' and annee.actif = true";
        $result = $this->select($query);
        if (!$result) {
            return null;
        }
        $array = [];
        while ($paiement = $result->fetch_object()) {
            array_push($array, new Paiement($paiement->id, $paiement->nom_payeur, $paiement->montant, $paiement->banque, $paiement->date_encaissement, $paiement->numero_cheque, $paiement->id_annee));
        }
        return $array;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM paiement  WHERE  id = '$id'";
        $result = $this->select($query);
        if (!$result) {
            return null;
        }
        $paiement = $result->fetch_object();
        return new Paiement($paiement->id, $paiement->nom_payeur, $paiement->montant, $paiement->banque, $paiement->date_encaissement, $paiement->numero_cheque, $paiement->id_annee);
    }

}