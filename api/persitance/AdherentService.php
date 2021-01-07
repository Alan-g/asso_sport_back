<?php


class AdherentService extends Database
{

    /**
     * @param $adherent Adherent
     */
    public function create($adherent){
        $adr = $adherent->getAdresse1() !== '' ? "'".str_replace("'", "\'", $adherent->getAdresse1())."'" : "null";
        $adr2 = $adherent->getAdresse2() !== '' ? "'".str_replace("'", "\'", $adherent->getAdresse2())."'" : "null";
        $adr3 = $adherent->getAdresse3() !== '' ? "'".str_replace("'", "\'", $adherent->getAdresse3())."'" : "null";
        $commune = $adherent->getCommune() !== '' ? "'".str_replace("'", "\'", $adherent->getCommune())."'" : "null";
        $email = $adherent->getMail() !== '' ? "'".$adherent->getMail()."'" : "null";
        $tel = $adherent->getTelephone() === '' ? 'null' : "'".$adherent->getTelephone()."'";
        $date = $adherent->getDateNaissance() !== '' ? "'".$adherent->getDateNaissance()."'" : "null";
        $query = "INSERT INTO adherent (genre,nom,prenom,adresse1,adresse2,adresse3,code_postal,commune,telephone,mail,date_naissance) VALUE ('".$adherent->getGenre()."','".$adherent->getNom()."','".$adherent->getPrenom()."',".$adr.",".$adr2.",".$adr3.",'".$adherent->getCodePostal()."',".$commune.",".$tel.",".$email.",".$date.");";
        $id = $this->insert($query);
        return $id;
    }
    /**
     * @param $adherent Adherent
     */
    public function update($adherent){
        $adr = $adherent->getAdresse1() !== '' ? "'".str_replace("'", "\'", $adherent->getAdresse1())."'" : "null";
        $adr2 = $adherent->getAdresse2() !== '' ? "'".str_replace("'", "\'", $adherent->getAdresse2())."'" : "null";
        $adr3 = $adherent->getAdresse3() !== '' ? "'".str_replace("'", "\'", $adherent->getAdresse3())."'" : "null";
        $commune = $adherent->getCommune() !== '' ? "'".str_replace("'", "\'", $adherent->getCommune())."'" : "null";
        $email = $adherent->getMail() !== '' ? "'".$adherent->getMail()."'" : "null";
        $tel = $adherent->getTelephone() === '' ? 'null' : "'".$adherent->getTelephone()."'";
        $date = $adherent->getDateNaissance() !== '' ? "'".$adherent->getDateNaissance()."'" : "null";
        $query = "UPDATE adherent SET genre = '".$adherent->getGenre()."',nom = '".$adherent->getNom()."',prenom = '".$adherent->getPrenom()."',adresse1 = ".$adr.",adresse2 = ".$adr2.",adresse3 = ".$adr3.",code_postal = '".$adherent->getCodePostal()."',commune = ".$commune.",telephone = ".$tel.",mail = ".$email.",date_naissance = ".$date." WHERE id = '$adherent->id';";
        $id = $this->insert($query);
        return $id;
    }

    public function getByNameWithoutInscription($nomPrenom){
        $where = "and CONCAT(nom,' ',prenom) like '%$nomPrenom%'";
        $result = $this->select("SELECT adherent.* FROM adherent left join inscription on inscription.id_adherent = adherent.id where inscription.id is null ".$where." ORDER BY nom;");
        if (!$result){
            return null;
        }
        $array = [];
        while ($adherent = $result->fetch_object()){
            array_push($array,new Adherent($adherent->id,$adherent->genre,$adherent->nom,$adherent->prenom,$adherent->adresse1,$adherent->adresse2,$adherent->adresse3,$adherent->code_postal, $adherent->commune,$adherent->telephone,$adherent->mail,$adherent->date_naissance));
        }
        return $array;
    }

    public function getByNameWithParam($nomPrenom, $arrayParam){
        $where = "and CONCAT(nom,' ',prenom) like '%$nomPrenom%'";
        $leftJoin = "";
        foreach ($arrayParam as $key => $value) {
            if ($key !== 'inscrit') {
                if ($value === 'Positif' || $value === 'Négatif'){
                    $where .= " and " . $key . "= '" . $value . "'";
                } else {
                    if ($key === 'annee') {
                        $where .= " and id_annee = (select id from annee where libelle = '" . $value . "')";
                    } else if ($key === "cours"){
                        $leftJoin = " left join inscription_cours on inscription.id = inscription_cours.id_inscription ";
                        $where .= " and inscription_cours.id_cours = ".$value;
                    }else {
                        $where .= " and " . $key . " = " . ($value === 'oui' ? 'true' : 'false');
                    }
                }
            }
        }
        $result = $this->select("SELECT adherent.* FROM adherent left join inscription on inscription.id_adherent = adherent.id ".$leftJoin." where inscription.id is not null ".$where." ORDER BY nom;");
        if (!$result){
            return null;
        }
        $array = [];
        while ($adherent = $result->fetch_object()){
            array_push($array,new Adherent($adherent->id,$adherent->genre,$adherent->nom,$adherent->prenom,$adherent->adresse1,$adherent->adresse2,$adherent->adresse3,$adherent->code_postal, $adherent->commune,$adherent->telephone,$adherent->mail,$adherent->date_naissance));
        }
        return $array;
    }

    public function getByName($nomPrenom){
        $where = "CONCAT(nom,' ',prenom) like '%$nomPrenom%'";
        $result = $this->select("SELECT adherent.* FROM adherent left join inscription on inscription.id_adherent = adherent.id where ".$where." ORDER BY nom");
        if (!$result){
            return null;
        }
        $array = [];
        while ($adherent = $result->fetch_object()){
            array_push($array,new Adherent($adherent->id,$adherent->genre,$adherent->nom,$adherent->prenom,$adherent->adresse1,$adherent->adresse2,$adherent->adresse3,$adherent->code_postal, $adherent->commune,$adherent->telephone,$adherent->mail,$adherent->date_naissance));
        }
        return $array;
    }

    public function getByCoursId($id){
        $result = $this->select("SELECT adherent.* FROM adherent inner join inscription on inscription.id_adherent = adherent.id inner join inscription_cours on  inscription.id = inscription_cours.id_inscription where inscription_cours.id_cours = '".$id."' ORDER BY nom");
        if (!$result){
            return [];
        }
        $array = [];
        while ($adherent = $result->fetch_object()){
            array_push($array,new Adherent($adherent->id,$adherent->genre,$adherent->nom,$adherent->prenom,$adherent->adresse1,$adherent->adresse2,$adherent->adresse3,$adherent->code_postal, $adherent->commune,$adherent->telephone,$adherent->mail,$adherent->date_naissance));
        }
        return $array;
    }



    public function getByFilter($annee,$certificat,$reglement,$enveloppe) {
        $where = " where inscription.annee = '".$annee."' ";
        if ($certificat != 'false') {
            $where.= " and inscription.certificat = false";
        }
        if ($reglement != 'false') {
            $where.= " and inscription.reglement = false";
        }
        if ($enveloppe != 'false') {
            $where.= " and inscription.enveloppe = false";
        }
        $query = "SELECT adherent.*,inscription.certificat,inscription.enveloppe,inscription.reglement from adherent INNER JOIN inscription on inscription.id_adherent = adherent.id ".$where;
        $result = $this->select($query);
        if (!$result){
            return null;
        }
        $array = [];
        while ($adherent = $result->fetch_object()){
            array_push($array,$adherent );
        }
        return $array;
    }
    public function getById($id){
        $result = $this->select("SELECT * FROM adherent WHERE id = '$id'");
        if (!$result){
            return null;
        }
        $adherent = $result->fetch_object();
        return new Adherent($adherent->id,$adherent->genre,$adherent->nom,$adherent->prenom,$adherent->adresse1,$adherent->adresse2,$adherent->adresse3,$adherent->code_postal, $adherent->commune,$adherent->telephone,$adherent->mail,$adherent->date_naissance);
    }
}