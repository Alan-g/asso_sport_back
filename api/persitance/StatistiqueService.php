<?php


class StatistiqueService extends Database
{

    /**
     * @return array
     */
    function nombreAdherentAnnee(){
        $query = "select COUNT(inscription.id) as nombre ,libelle from annee left join inscription on inscription.id_annee = annee.id group by libelle;";
        $result = $this->select($query);
        if (!$result) {
            return array();
        }
        $array = [];
        while ($stat = $result->fetch_object()) {
            array_push($array, new ColumnChart($stat->libelle, $stat->nombre));
        }
        return $array;
    }

    /**
     * @return array
     */
    function pyramideAge(){
        $query = "select count(*) as nombre, TIMESTAMPDIFF(year,adherent.date_naissance,CURDATE()) as age from inscription inner join adherent on adherent.id = inscription.id_adherent where id_annee = (select id from annee where annee.actif = 1) and adherent.date_naissance is not null group by age order by age;";
        $result = $this->select($query);
        if (!$result) {
            return array();
        }
        $array = [];
        while ($stat = $result->fetch_object()) {
            $array[$stat->age] = $stat->nombre;
        }
        return $array;
    }

    /**
     * @return ColumnChart
     */
    function nombreAdherentAnneeActif(){
        $query = "select COUNT(inscription.id) as nombre ,libelle from annee left join inscription on inscription.id_annee = annee.id where annee.actif = 1 group by libelle;";
        $result = $this->select($query);
        if (!$result) {
            return null;
        }
        $stat = $result->fetch_object();
        return new ColumnChart($stat->libelle, $stat->nombre);
    }

    /**
     * @return PieChart
     */
    function repartitionSexeAnneeActif(){
        $query = "select COUNT(*) as nombre, if ( STRCMP(adherent.genre,\"MR\")  = 0, \"Homme\", if ( STRCMP(adherent.genre, \"MME\") = 0,\"Femme\",genre)) as libelle from inscription inner join adherent on adherent.id = inscription.id_adherent where id_annee = (select id from annee where annee.actif = 1) group by adherent.genre;";
        $result = $this->select($query);
        if (!$result) {
            return array();
        }
        $array = [];
        while ($stat = $result->fetch_object()) {
            $array[$stat->libelle] =  $stat->nombre;
        }
        return new PieChart($array);
    }

    /**
     * @return int
     */
    function newAdherentAnneeActif(){
        $query = "select count(*) as nombre from inscription actions where id_annee = (select id from annee where annee.actif = 1) and id_adherent not in (select id_adherent from inscription where id_annee in (select id from annee where annee.actif != 1));";
        $result = $this->select($query);
        if (!$result) {
            return 0;
        }
        $stat = $result->fetch_object();

        return $stat->nombre;
    }

    /**
     * @return int
     */
    function essaiAnneeActif(){
        $query = "select COUNT(*) as nombre from inscription where id_annee = (select id from annee where annee.actif = 1) and essai = 1;";
        $result = $this->select($query);
        if (!$result) {
            return 0;
        }
        $stat = $result->fetch_object();

        return $stat->nombre;
    }

    /**
     * @return int
     */
    function oldAdherentAnneeActif(){
        $query = "select count(*) from inscription where id_adherent in (select id_adherent from inscription where id_annee = (select id from annee where annee.actif = 1)) and id_annee != (select id from annee where annee.actif = 1) group by id_adherent;";
        $result = $this->select($query);
        if (!$result) {
            return 0;
        }
        return $result->num_rows;
    }


}