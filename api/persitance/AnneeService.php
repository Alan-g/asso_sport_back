<?php


class AnneeService extends Database
{


   public function getAll(){
       $query = "select * from annee  ORDER BY libelle DESC;";
       $result = $this->select($query);
       if (!$result){
           return array();
       }
       $array = [];
       while ($annee = $result->fetch_object()){
           array_push($array,new Annee($annee->id,$annee->libelle,$annee->actif === '1' ? true : false));
       }
       return $array;
   }

    /**
     * @return Annee|null
     */
    public function getActif(){
        $query = "select * from annee where actif = 1  ORDER BY libelle DESC;";
        $result = $this->select($query);
        if (!$result){
            return null;
        }
        $annee = $result->fetch_object();
        return new Annee($annee->id,$annee->libelle,$annee->actif === '1' ? true : false);
    }

    /**
     * @param Annee $annee
     *
     * @return int
     */
   public function create(Annee $annee) {
       $query = "INSERT INTO annee (libelle,actif) VALUE ('".$annee->libelle."', ". ($annee->actif ? "true" : "false") .");";
       $id = $this->insert($query);
       return $id;
   }

   public function disableSaison(){
       $query = "UPDATE annee SET actif = false;";
       $this->insert($query);
   }
}