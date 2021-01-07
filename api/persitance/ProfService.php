<?php


class ProfService extends Database
{
    /**
     * @param $prof Prof
     */
    public function create($prof)
    {
        $query = "INSERT INTO `prof`(`nom`, `prenom`, `id_annee`,`mail`,`telephone`) VALUES ('" . $prof->getNom() . "','" . $prof->getPrenom() . "', (SELECT id from annee where libelle = '".$prof->annee."'), " . ($prof->mail === "" ? "null" : "'".$prof->mail."'") . ", " . ($prof->telephone === "" ? "null" : "'".$prof->telephone."'") . ")";
        return $this->insert($query);
    }

    /**
     * @param $prof Prof
     */
    public function update($prof)
    {
        $query = "UPDATE `prof` SET `nom` = '" . $prof->getNom() . "', `prenom` = '" . $prof->getPrenom() . "', `mail` = " .($prof->mail === null || $prof->mail === "" ? "null" : "'".$prof->mail."'") . ", `telephone` = " . ($prof->telephone === null || $prof->telephone === ""  ? "null" : "'".$prof->telephone."'") . " where id = ".$prof->id . ";";
        return $this->insert($query);
    }

    public function delete($id)
    {
        $query = "DELETE FROM `prof` where id = '$id'";
        return $this->insert($query);
    }

    public function getAll()
    {
        $query = "SELECT prof.*, annee.libelle as annee FROM prof inner join annee on annee.id = id_annee where actif = true;";
        $result = $this->select($query);
        if (!$result) {
            return array();
        }
        $array = [];
        while ($prof = $result->fetch_object()) {
            array_push($array, new Prof($prof->id, $prof->nom, $prof->prenom, $prof->annee, $prof->mail, $prof->telephone));
        }
        return $array;
    }

    /**
     * @param $id
     * @return Prof
     */
    public function getProfById($id)
    {
        $query = "SELECT * FROM prof where id = '$id';";
        $result = $this->select($query);
        if (!$result) {
            return null;
        }
        $prof = $result->fetch_object();
        return new Prof($prof->id, $prof->nom, $prof->prenom, $prof->id_annee, $prof->mail, $prof->telephone);

    }
}