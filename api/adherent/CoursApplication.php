<?php


class CoursApplication
{
    private $coursService;
    private $ProfService;
    private $anneService;
    private $salleService;

    public function __construct()
    {
        $this->coursService = new CoursService();
        $this->ProfService = new ProfService();
        $this->anneService = new AnneeService();
        $this->salleService = new SalleService();
    }

    /**
     * @return array
     */
    function getAllCours(){
        $cours = $this->coursService->getCours();
        $coursDTO = array();
        foreach ($cours as $cour) {
            $typeCours = $this->coursService->getTypeCoursById($cour->getIdTypeCours());
            $salle = $this->salleService->getSalleById($cour->getIdSalle());
            $prof = $this->ProfService->getProfById($cour->getIdProf());
            array_push($coursDTO, new CoursDTO($cour->id, $typeCours,$salle,$cour->jour, $cour->heure_debut, $cour->heure_fin, $prof, $cour->limite,$cour->effectif, $cour->getIdLink()));
        }
        return $this->sortCoursDTO($coursDTO);
    }


    /**
     * @param $id
     * @return CoursDTO
     */
    function getById($id){
        $cours = $this->coursService->getCoursById($id);
        $typeCours = $this->coursService->getTypeCoursById($cours->getIdTypeCours());
        $salle = $this->salleService->getSalleById($cours->getIdSalle());
        $prof = $this->ProfService->getProfById($cours->getIdProf());
        return new CoursDTO($cours->id, $typeCours, $salle, $cours->jour, $cours->heure_debut, $cours->heure_fin, $prof, $cours->limite,$cours->effectif, $cours->getIdLink());
    }

    /**
     * @param $idInscription
     */
    public function getByIdInscription($idInscription){
        $cours = $this->coursService->getCoursByInscription($idInscription);
        $coursDTO = array();
        foreach ($cours as $cour) {
            $typeCours = $this->coursService->getTypeCoursById($cour->getIdTypeCours());
            $salle = $this->salleService->getSalleById($cour->getIdSalle());
            $prof = $this->ProfService->getProfById($cour->getIdProf());
            array_push($coursDTO, new CoursDTO($cour->id, $typeCours, $salle, $cour->jour, $cour->heure_debut, $cour->heure_fin, $prof, $cour->limite,$cour->effectif, $cour->getIdLink()));
        }
        return $this->sortCoursDTO($coursDTO);

    }

    /**
     * @param $idProf
     */
    public function getByProf($idProf){
        $cours = $this->coursService->getCoursByIdProf($idProf);
        $coursDTO = array();
        foreach ($cours as $cour) {
            $typeCours = $this->coursService->getTypeCoursById($cour->getIdTypeCours());
            $salle = $this->salleService->getSalleById($cour->getIdSalle());
            $prof = $this->ProfService->getProfById($cour->getIdProf());
            array_push($coursDTO, new CoursDTO($cour->id, $typeCours, $salle, $cour->jour, $cour->heure_debut, $cour->heure_fin, $prof, $cour->limite,$cour->effectif, $cour->getIdLink()));
        }
        return $this->sortCoursDTO($coursDTO);

    }

    /**
     * @param UpdateCoursCommand $command
     */
    public function update(UpdateCoursCommand $command){
        $this->coursService->update(new Cours($command->idCours, $command->typeCoursId, $command->idSalle, $command->jour, $command->heureDebut, $command->heurefin, $command->profId, $command->limite, 0,null));
    }

    /**
     * @param CreateCoursCommand $command
     */
    public function create(CreateCoursCommand $command) {
        $annee= $this->anneService->getActif();
        $this->coursService->create(new Cours(null, $command->typeCoursId, $command->idSalle, $command->jour, $command->heureDebut, $command->heurefin, $command->profId, $command->limite, 0,$annee->libelle));
    }

    /**
     * @param $id
     */
    public function delete($id) {
        $this->coursService->delete($id);
    }

    private function sortCoursDTO($coursDTO){
        $coursDTOSort = array();
        foreach ($coursDTO as $item) {
            if (count($coursDTOSort) === 0 ){
                array_push($coursDTOSort,$item);
            }else {
                $add = false;
                for ($i = 0; $i < count($coursDTOSort); $i++){
                    $day = $this->getDayValue($item->jour);
                    $coursSort = $coursDTOSort[$i];
                    $daySort = $this->getDayValue($coursSort->jour);
                    if ($day < $daySort || ( $day === $daySort && $item->heure_debut < $coursSort->heure_debut )){
                        $var1 = $item;
                        $var2 = null;
                        for ($o = $i; $o < count($coursDTOSort); $o++){
                            $var2 = $coursDTOSort[$o];
                            $coursDTOSort[$o] = $var1;
                            $var1 = $var2;
                        }
                        array_push($coursDTOSort, $var1);
                        $add = true;
                        break;
                    }
                }
                if (!$add) {
                    array_push($coursDTOSort, $item);
                }
            }
        }
        return $coursDTOSort;
    }

    private function getDayValue($dayString) {
        $day = 0;
        if ($dayString === 'Mardi'){
            $day = 1;
        } else if($dayString === 'Mercredi') {
            $day = 2;
        } else if($dayString === 'Jeudi') {
            $day = 3;
        } else if($dayString === 'Vendredi') {
            $day = 4;
        } else if($dayString === 'Samedi') {
            $day = 5;
        } else if($dayString === 'Dimanche') {
            $day = 6;
        }
        return $day;
    }

}