<?php


class InscriptionApplication
{
    private $coursService;
    private $adherentService;
    private $paiementService;
    private $inscriptionService;

    public function __construct()
    {
        $this->coursService = new CoursService();
        $this->adherentService = new AdherentService();
        $this->paiementService = new PaiementService();
        $this->inscriptionService = new InscriptionService();
    }

    public function create(CreateInscriptionCommand $command){
        $idAdherent = $command->idAdherent;
        if ($command->idAdherent) {
            $this->adherentService->update(new Adherent($command->idAdherent,$command->genre,$command->nom,$command->prenom,$command->adresse1,$command->adresse2, $command->adresse3,$command->code_postal, $command->commune,$command->telephone,$command->mail,$command->date_naissance));
        } else {
            $idAdherent = $this->adherentService->create(new Adherent(null,$command->genre,$command->nom,$command->prenom,$command->adresse1,$command->adresse2, $command->adresse3,$command->code_postal, $command->commune,$command->telephone,$command->mail,$command->date_naissance));
        }
        $idInscription = $this->inscriptionService->create(new Inscription(null,$idAdherent,$command->annee,$command->certificat, $command->enveloppe,$command->reglement,$command->comite_entreprise,$command->autorisation_parental,$command->commentaire,$command->montant,$command->questionnaire_sante,$command->date_envoi_ce,$command->reglement_interieur, $command->essai,$command->cart_mra));

        foreach ($command->idCours as $idCour) {
            $this->coursService->link($idCour, $idInscription);
        }
        foreach ($command->paiements as $paiement){
            $idPaiement = $paiement->id;
            if ($paiement->id === null) {
                $idPaiement = $this->paiementService->create($paiement);
            }
            $this->paiementService->link($idPaiement, $idInscription);
        }
    }

    public function update(UpdateInscriptionCommand $command){
        $this->inscriptionService->update(new Inscription($command->idInscription,$command->idAdherent,null,$command->certificat, $command->enveloppe,$command->reglement,$command->comite_entreprise,$command->autorisation_parental,$command->commentaire,$command->montant,$command->questionnaire_sante,$command->date_envoi_ce,$command->reglement_interieur, $command->essai,$command->cart_mra));
    }

    public function updatePaiement(UpdatePaiementInscriptionCommand $command){
        foreach ($command->paiements as $paiement){
            $idPaiement = $paiement->id;
            if ($paiement->id === null) {
                $idPaiement = $this->paiementService->create($paiement);
                $this->paiementService->link($idPaiement, $command->idInscription);
            } else {
                $this->paiementService->update($paiement);

                if (!$this->paiementService->linkExist($idPaiement, $command->idInscription)){
                    $this->paiementService->link($idPaiement, $command->idInscription);
                }
            }
        }
    }

    /**
     * @param $id
     */
    public function getByIdAdherent($id){
        return $this->inscriptionService->getByIdAdherent($id);
    }

    /**
     * @param $id
     * @param $annee
     */
    public function getByIdAdherentAndAnnee($id,$annee){
        return $this->inscriptionService->getByIdAdherentAndAnnee($id,$annee);
    }

    /**
     * @param AddCoursInscriptionCommand $command
     */
    public function addCours(AddCoursInscriptionCommand $command){
        foreach ($command->idCours as $cour) {
            $this->coursService->link($cour, $command->idInscription);
        }
    }

    /**
     * @param RemoveCoursInscriptionCommand $command
     */
    public function removeCours(RemoveCoursInscriptionCommand $command){
        foreach ($command->idCours as $cour) {
            $this->coursService->removeLink($cour, $command->idInscription);
        }
    }

}