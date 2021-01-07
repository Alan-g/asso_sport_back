<?php


class PaiementApplication
{

    private $paiementService;

    public function __construct()
    {
        $this->paiementService = new PaiementService();
    }

    function getByName($nomPayeur){
        return $this->paiementService->getByName($nomPayeur);
    }

    /**
     * @param $idInscription
     * @return array|null
     */
    function getByIdInscription($idInscription){
        return $this->paiementService->getPaiementByInscription($idInscription);
    }
}