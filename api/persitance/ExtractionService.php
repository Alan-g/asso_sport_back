<?php


class ExtractionService extends Database
{

    /**
     * @return array
     */
    function getAdherentInscri(){
        $query = "select adherent.nom, adherent.prenom, adherent.mail, adherent.telephone from inscription inner join adherent on adherent.id = inscription.id_adherent where id_annee = (select id from annee where actif = 1);";
        $result = $this->select($query);
        if (!$result) {
            return array();
        }
        $array = [];
        while ($stat = $result->fetch_object()) {
            array_push($array, new ExtractionAdherent($stat->nom, $stat->prenom, $stat->mail, $this->formatTel($stat->telephone)));
        }
        return $array;
    }

    /**
     * @return array
     */
    function getAdherentInscriParCours($idCours){
        $query = "select adherent.nom, adherent.prenom, adherent.mail, adherent.telephone from inscription inner join adherent on adherent.id = inscription.id_adherent inner join inscription_cours on inscription_cours.id_inscription = inscription.id where inscription.id_annee = (select id from annee where actif = 1) and id_cours = $idCours;";
        $result = $this->select($query);
        if (!$result) {
            return array();
        }
        $array = [];
        while ($stat = $result->fetch_object()) {
            array_push($array, new ExtractionAdherent($stat->nom, $stat->prenom, $stat->mail, $this->formatTel($stat->telephone)));
        }
        return $array;
    }

    function formatTel($telephone){
        $telephone = str_replace(' ','',$telephone);
        $telephone = chunk_split($telephone, 2, ' ');
        return trim($telephone);
    }

}