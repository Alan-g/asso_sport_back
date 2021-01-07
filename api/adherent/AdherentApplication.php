<?php


class AdherentApplication
{
    private $adherentService;

    public function __construct()
    {
        $this->adherentService = new AdherentService();
    }

    function getByNameWithoutInscription($nomPrenom){
        return $this->adherentService->getByNameWithoutInscription($nomPrenom);
    }

    function getByNameWithParam($nomPrenom, $arrayParam){
        return $this->adherentService->getByNameWithParam($nomPrenom, $arrayParam);
    }

    function getByName($nomPrenom){
        return $this->adherentService->getByName($nomPrenom);
    }

    function getById($id){
        return $this->adherentService->getById($id);
    }


    /**
     * @param $id
     * @return array|null
     */
    function getByCoursId($id){
        return $this->adherentService->getbyCoursId($id);
    }

    /**
     * @param UpdateAdherentCommand $command
     */
    function update(UpdateAdherentCommand $command) {
        $this->adherentService->update(new Adherent($command->idAdherent,$command->genre,$command->nom,$command->prenom,$command->adresse1,$command->adresse2, $command->adresse3,$command->code_postal, $command->commune,$command->telephone,$command->mail,$command->date_naissance));
    }


}