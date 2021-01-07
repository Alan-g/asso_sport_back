<?php


class MontantCoursApplication
{
    private $montantCoursService;

    public function __construct()
    {
        $this->montantCoursService = new MontantCoursService();
    }


    /**
     * @param CreateMontantCoursCommand $command
     */
    public function createMontantCours(CreateMontantCoursCommand $command){
        $this->montantCoursService->createMontantCours($command);
    }

    /**
     * @param $idMontant
     * @param UpdateMontantCoursCommand $command
     */
    public function updateMontantCours($idMontant,UpdateMontantCoursCommand $command){
        $this->montantCoursService->updateMontantCours($idMontant, $command);
    }

    /**
     * @param $idMontant
     */
    public function deleteMontantCours($idMontant){
        $this->montantCoursService->deleteMontantCours($idMontant);
    }
}