<?php


class CoursService extends Database
{

    /**
     * @param $cours Cours
     */
    public function create($cours) {
        $query = "INSERT INTO `cours`( `id_salle`,`id_type`, `jour`, `heure_debut`, `heure_fin`, `id_prof`, `limite`, `id_annee`) VALUES (".($cours->getIdSalle() === "" ? 'null' : $cours->getIdSalle()).",'".$cours->getIdTypeCours()."','".$cours->getJour()."','".$cours->getHeureDebut()."','".$cours->getHeureFin()."','".$cours->getIdProf()."','".$cours->getLimite()."',(SELECT id from annee where libelle = '".$cours->annee."'))";
         return $this->insert($query);
    }

    /**
     * @param $cours TypeCours
     */
    public function createTypeCours($cours) {
        $query = "INSERT INTO `type_cours`( `libelle`) VALUES ('".$cours->getLibelle()."')";
        return $this->insert($query);
    }

    /**
     * @param $id
     */
    public function delete($id) {
        $query = "DELETE FROM cours WHERE id = '$id'";
        $this->insert($query);
    }


    public function getTypeCours()
    {
        $query = "SELECT * FROM type_cours where active = 1;";
        $result = $this->select($query);
        if (!$result) {
            return array();
        }
        $array = [];
        while ($cours = $result->fetch_object()) {
            array_push($array, new TypeCours($cours->id, $cours->libelle));
        }
        return $array;
    }

    public function getTypeCoursById($id) {
        $query = "SELECT * FROM type_cours WHERE id = '$id';";
        $result = $this->select($query);
        if (!$result){
            return null;
        }
        $cours = $result->fetch_object();
        return new TypeCours($cours->id,$cours->libelle);

    }

    public function getTypeCoursByLibelle($libelle) {
        $query = "SELECT * FROM type_cours WHERE libelle = '$libelle';";
        $result = $this->select($query);
        if (!$result){
            return null;
        }
        $cours = $result->fetch_object();
        return new TypeCours($cours->id,$cours->libelle);

    }

    public function updateTypeCours($id, $libelle) {
        $query = "UPDATE type_cours SET libelle = '$libelle' WHERE id = $id;";
        return $this->insert($query);
    }

    public function deleteTypeCours($id) {
        $query = "UPDATE type_cours SET active = false WHERE id = $id;";
        return $this->insert($query);
    }

    public function activateTypeCours($id) {
        $query = "UPDATE type_cours SET active = true WHERE id = $id;";
        return $this->insert($query);
    }

    public function linkExist($idCours, $idInscription)
    {
        $query = "SELECT * FROM `inscription_cours`WHERE id_cours = '$idCours' and id_inscription = '$idInscription'";
        $result =  $this->select($query);
        if ($result) {
            return true;
        } else {
            return null;
        }
    }

    public function link($idCours, $idInscription)
    {
        $query = "INSERT INTO `inscription_cours`(`id_cours`, `id_inscription`) VALUE ('$idCours','$idInscription')";
        return $this->insert($query);
    }

    public function updateLink($idLink, $idCours, $idInscription)
    {
        $query = "UPDATE `inscription_cours` SET `id_cours` = '$idCours' WHERE  `id_inscription` = '$idInscription' and id = '$idLink'";
        return $this->insert($query);
    }
    public function removeLink($idCours, $idInscription)
    {
        $query = "DELETE FROM  `inscription_cours` WHERE id_inscription = '$idInscription' and id_cours = '$idCours'";
        return $this->insert($query);
    }

    /**
     * @param $cours Cours
     */
    public function update($cours) {
        $query = "UPDATE `cours` SET `id_salle` = ".($cours->getIdSalle() === null ? 'null' : $cours->getIdSalle()).",`id_type` = '".$cours->getIdTypeCours()."',`jour` = '".$cours->getJour()."', `heure_debut` = '".$cours->getHeureDebut()."',`heure_fin` = '".$cours->getHeureFin()."', `id_prof` = '".$cours->getIdProf()."', `limite` = '".$cours->getLimite()."' WHERE id = '".$cours->id."';";
        return $this->insert($query);
    }

    public function getCoursByInscription($idInscription) {
        //TODO fix effectif si utilisé
        $query = "SELECT cours.*,inscription_cours.id as idLink, count(id_cours) as effectif, annee.libelle as annee FROM cours INNER JOIN inscription_cours ON inscription_cours.id_cours = cours.id INNER JOIN annee ON annee.id = cours.id_annee WHERE  id_inscription = '$idInscription' GROUP by inscription_cours.id_cours, cours.id;";
        $result = $this->select($query);
        if (!$result){
            return [];
        }
        $array = [];
        while ($cours = $result->fetch_object()){
            $coursCreate = new Cours($cours->id,$cours->id_type,$cours->id_salle,$cours->jour,$cours->heure_debut,$cours->heure_fin,$cours->id_prof,$cours->limite,$cours->effectif,$cours->annee);
            $coursCreate->setIdLink($cours->idLink);
            array_push($array,$coursCreate);
        }
        return $array;
    }


    public function getCoursById($id) {
        $query = "select cours.*, count(id_cours) as effectif from cours left join inscription_cours on inscription_cours.id_cours = cours.id where cours.id = '$id' GROUP by inscription_cours.id_cours, cours.id;";
        $result = $this->select($query);
        if (!$result){
            return null;
        }
        $cours = $result->fetch_object();
    return new Cours($cours->id,$cours->id_type,$cours->id_salle,$cours->jour,$cours->heure_debut,$cours->heure_fin,$cours->id_prof,$cours->limite,$cours->effectif, $cours->id_annee);

    }

    /**
     * @param $idProf
     * @return array
     */
    public function getCoursByIdProf($idProf) {
        $query = "select cours.*, count(id_cours) as effectif from cours left join inscription_cours on inscription_cours.id_cours = cours.id where cours.id_prof = '$idProf' GROUP by inscription_cours.id_cours, cours.id;";
        $result = $this->select($query);
        if (!$result){
            return [];
        }
        $array = [];
        while ($cours = $result->fetch_object()){
            $coursCreate = new Cours($cours->id,$cours->id_type,$cours->id_salle,$cours->jour,$cours->heure_debut,$cours->heure_fin,$cours->id_prof,$cours->limite,$cours->effectif, $cours->id_annee);
            array_push($array,$coursCreate);
        }
        return $array;
    }

    public function getCours() {
        $query = "select cours.*, count(id_cours) as effectif from cours left join inscription_cours on inscription_cours.id_cours = cours.id INNER JOIN annee on annee.id = id_annee where actif = true GROUP by inscription_cours.id_cours, cours.id;";
        $result = $this->select($query);
        if (!$result){
            return array();
        }
        $array = [];
        while ($cours = $result->fetch_object()){
            array_push($array,new Cours($cours->id,$cours->id_type,$cours->id_salle,$cours->jour,$cours->heure_debut,$cours->heure_fin,$cours->id_prof,$cours->limite,$cours->effectif, $cours->id_annee));
        }
        return $array;
    }
}