<?php


class ExtractionApplication
{

    private $extractionService;
    private $coursApplication;

    /**
     * StatistiqueApplication constructor.
     */
    public function __construct()
    {
        $this->extractionService = new ExtractionService();
        $this->coursApplication = new CoursApplication();
    }

    /**
     * @return array
     */
    public function getAdherentInscri(){
        return $this->extractionService->getAdherentInscri();
    }

    /**
     * @return array
     */
    public function getAdherentInscriParCours(){
        $cours = $this->coursApplication->getAllCours();
        $array = array();
        foreach ($cours as $cour){
            $extractions = $this->extractionService->getAdherentInscriParCours($cour->id);
            array_push($array, new ExtractionAdherentCours($cour->typeCours->libelle, $cour->jour, $cour->heure_debut, $cour->heure_fin , $extractions, $cour->prof->prenom . ' ' . strtoupper($cour->prof->nom)));
        }
        return $array;
    }



}