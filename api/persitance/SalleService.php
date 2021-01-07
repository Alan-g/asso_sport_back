<?php


class SalleService extends Database
{

    /**
     * @param $cours Salle
     */
    public function createSalle($salle) {
        $query = "INSERT INTO `salle`( `libelle`, `capacite`) VALUES ('".$salle->libelle."', ".$salle->capacite.")";
        return $this->insert($query);
    }


    public function getSalle()
    {
        $query = "SELECT * FROM salle where active = 1;";
        $result = $this->select($query);
        if (!$result) {
            return array();
        }
        $array = [];
        while ($salle = $result->fetch_object()) {
            array_push($array, new Salle($salle->id, $salle->libelle, $salle->capacite));
        }
        return $array;
    }

    public function getSalleById($id) {
        $query = "SELECT * FROM salle WHERE id = '$id';";
        $result = $this->select($query);
        if (!$result){
            return null;
        }
        $salle = $result->fetch_object();
        return new Salle($salle->id, $salle->libelle, $salle->capacite);

    }

    public function getSalleByLibelle($libelle) {
        $query = "SELECT * FROM salle WHERE libelle = '$libelle';";
        $result = $this->select($query);
        if (!$result){
            return null;
        }
        $salle = $result->fetch_object();
        return new Salle($salle->id, $salle->libelle, $salle->capacite);

    }

    public function updateSalle($id, $libelle, $capacite) {
        $query = "UPDATE salle SET libelle = '$libelle', capacite = '$capacite' WHERE id = $id;";
        return $this->insert($query);
    }

    public function deleteSalle($id) {
        $query = "UPDATE salle SET active = false WHERE id = $id;";
        return $this->insert($query);
    }

    public function activateSalle($id) {
        $query = "UPDATE salle SET active = true WHERE id = $id;";
        return $this->insert($query);
    }
}