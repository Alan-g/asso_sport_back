<?php


class InscriptionService extends Database
{

    /**
     * @param $inscription Inscription
     */
    public function create($inscription){
        $certif = $inscription->getCertificat() === false ? 'false' : 'true';
        $envelop = $inscription->getEnveloppe()=== false ? 'false' : 'true';
        $reglement = $inscription->getReglement() === false ? 'false' : 'true';
        $comiteEntreprise = $inscription->getComiteEntreprise() === false ? 'false' : 'true';
        $autorisation = $inscription->getAutorisationParental() === false ? 'false' : 'true';
        $reglement_int = $inscription->getReglementInterieur() === false ? 'false' : 'true';
        $essai = $inscription->getEssai() === false ? 'false' : 'true';
        $carteMra = $inscription->getCartMra() === false ? 'false' : 'true';
        $dateEnvoi = !$inscription->getDateEnvoiCe() ? "null" : "'".$inscription->getDateEnvoiCe()."'";
        $commentaire = str_replace("'", "\'",$inscription->getCommentaire());
        $query = "INSERT INTO `inscription`(`id_adherent`, `id_annee`, `certificat`, `enveloppe`, `reglement`, `comite_entreprise`, `autorisation_parental`, `commentaire`, `montant`, `questionnaire_sante`, `date_envoi_ce`, `reglement_interieur`, `essai`, `cart_mra`) VALUE ('".$inscription->getIdAdherent()."',(select id from annee where libelle = '".$inscription->getAnnee()."'),".$certif.",".$envelop.",".$reglement.",".$comiteEntreprise.",".$autorisation.",'".$commentaire."','".$inscription->getMontant()."','".$inscription->getQuestionnaireSante()."',".$dateEnvoi.",".$reglement_int.",".$essai.",".$carteMra.")";
        return $this->insert($query);
    }

    /**
     * @param $inscription
     * @return mixed Inscription
     */
    public function update($inscription){

        $certif = $inscription->getCertificat() === false ? 'false' : 'true';
        $envelop = $inscription->getEnveloppe() === false ? 'false' : 'true';
        $reglement = $inscription->getReglement() === false ? 'false' : 'true';
        $comiteEntreprise = $inscription->getComiteEntreprise() === false ? 'false' : 'true';
        $autorisation = $inscription->getAutorisationParental() === false ? 'false' : 'true';
        $reglement_int = $inscription->getReglementInterieur() === false ? 'false' : 'true';
        $essai = $inscription->getEssai() === false ? 'false' : 'true';
        $carteMra = $inscription->getCartMra() === false ? 'false' : 'true';
        $dateEnvoi = !$inscription->getDateEnvoiCe() ? "null" : "'".$inscription->getDateEnvoiCe()."'";
        $commentaire = str_replace("'", "\'",$inscription->getCommentaire());

        $query = "UPDATE `inscription` SET `certificat` = ".$certif.", `enveloppe` = ".$envelop.", `reglement` = ".$reglement.", `comite_entreprise` = ".$comiteEntreprise.", `autorisation_parental` = ".$autorisation.", `commentaire` = '".$commentaire."', `montant` = '".$inscription->getMontant()."', `questionnaire_sante` = '".$inscription->getQuestionnaireSante()."', `date_envoi_ce` = ".$dateEnvoi.", `reglement_interieur` = ".$reglement_int.", `essai` = ".$essai.", `cart_mra` = ".$carteMra." WHERE id = '".$inscription->id."' and id_adherent = '".$inscription->getIdAdherent()."'";
        return $this->insert($query);
    }

    public function getByIdAdherentAndAnnee($idAdherent, $anne){
        $query = "SELECT inscription.*, annee.libelle as annee FROM inscription INNER JOIN annee on annee.id = inscription.id_annee WHERE id_adherent = '$idAdherent' and annee.libelle = '$anne'";
        $result = $this->select($query);
        if (!$result){
            return null;
        }
        $inscription = $result->fetch_object();
        return new Inscription($inscription->id,$inscription->id_adherent,$inscription->annee,$inscription->certificat,$inscription->enveloppe,$inscription->reglement,$inscription->comite_entreprise,$inscription->autorisation_parental,$inscription->commentaire,$inscription->montant,$inscription->questionnaire_sante,$inscription->date_envoi_ce,$inscription->reglement_interieur,$inscription->essai,$inscription->cart_mra);
    }

    public function getByIdAdherent($idAdherent) {
        $query = "SELECT inscription.*, annee.libelle as annee FROM inscription INNER JOIN annee on annee.id = inscription.id_annee WHERE id_adherent = '$idAdherent'";
        $result = $this->select($query);
        if (!$result){
            return array();
        }
        $array = [];
        while ($inscription = $result->fetch_object()){
            array_push($array,new Inscription($inscription->id,$inscription->id_adherent,$inscription->annee,$inscription->certificat,$inscription->enveloppe,$inscription->reglement,$inscription->comite_entreprise,$inscription->autorisation_parental,$inscription->commentaire,$inscription->montant,$inscription->questionnaire_sante,$inscription->date_envoi_ce,$inscription->reglement_interieur,$inscription->essai,$inscription->cart_mra));
        }
        return $array;
    }

    public function getByAnnee($anne){
        $query = "SELECT inscription.*, annee.libelle as annee FROM inscription  INNER JOIN annee on annee.id = inscription.id_annee WHERE annee.libelle = '$anne'";
        $result = $this->select($query);
        if (!$result){
            return null;
        }
        return $this->convert($result);
    }

    private function convert($rows){
        $array = [];
        while ($inscription = $rows->fetch_all()){
            $inscription->fetch_object();
            array_push($array,new Inscription($inscription->id,$inscription->id_adherent,$inscription->annee,$inscription->certificat,$inscription->enveloppe,$inscription->reglement,$inscription->comite_entreprise,$inscription->autorisation_parental,$inscription->commentaire,$inscription->montant,$inscription->questionnaire_sante,$inscription->date_envoi_ce,$inscription->reglement_interieur,$inscription->essai,$inscription->cart_mra));
        }
        return $array;
    }
}