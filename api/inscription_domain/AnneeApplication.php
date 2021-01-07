<?php


class AnneeApplication
{

    private $anneeService;
    private $coursService;
    private $profService;

    public function __construct()
    {
        $this->anneeService = new AnneeService();
        $this->coursService = new CoursService();
        $this->profService = new ProfService();
    }


    /**
     * @return array<Annee>
     */
    public function getAll(){
        return $this->anneeService->getAll();
    }

    /**
     * @param CreateAnneCommand $command
     */
    public function create(CreateAnneCommand $command){
        $this->anneeService->disableSaison();
        $idAnnee = $this->anneeService->create(new Annee(null ,$command->libelle, true));
        if ($command->profs !== "") {
            foreach ($command->profs as $profId) {
                $prof = $this->profService->getProfById($profId);
                $prof->annee = $command->libelle;
                $this->profService->create($prof);
            }
        }
        if ($command->cours !== "") {
            foreach ($command->cours as $courId) {
                $cour = $this->coursService->getCoursById($courId);
                $cour->annee = $command->libelle;
                $this->coursService->create($cour);
            }
        }
    }
}