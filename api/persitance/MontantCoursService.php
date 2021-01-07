<?php


class MontantCoursService extends Database
{
    public function getAll()
    {
        $query = "SELECT * FROM tarif_cours ORDER BY nombre;";
        $result = $this->select($query);
        if (!$result) {
            return array();
        }
        $array = [];
        while ($montantCours = $result->fetch_object()) {
            array_push($array, new MontantCours($montantCours->id, $montantCours->nombre, $montantCours->montant));
        }
        return $array;
    }

    /**
     * @param $command CreateMontantCoursCommand
     */
    public function createMontantCours($command)
    {
        $query = "insert into association.tarif_cours (nombre,montant) values ('" . $command->nombre . "','" . $command->montant . "');";
        return $this->insert($query);
    }

    /**
     * @param $command UpdateMontantCoursCommand
     */
    public function updateMontantCours($idMontant,$command)
    {
        $query = "UPDATE association.tarif_cours SET montant  = '" . $command->montant . "' where id = ".$idMontant.";";
        return $this->insert($query);
    }

    public function deleteMontantCours($id)
    {
        $query = "DELETE FROM tarif_cours where id = '$id'";
        return $this->insert($query);
    }
}