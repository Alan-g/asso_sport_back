<?php


class StatistiqueApplication
{

    private $statistiqueService;
    private $coursApplication;

    /**
     * StatistiqueApplication constructor.
     */
    public function __construct()
    {
        $this->statistiqueService = new StatistiqueService();
        $this->coursApplication = new CoursApplication();
    }

    /**
     * @return array
     */
    public function getAdherentByAnnee(){
        return $this->statistiqueService->nombreAdherentAnnee();
    }

    /**
     * @return StatsAnnee
     */
    public function getSatistiqueAnnee(){
        $adherentTotal = $this->statistiqueService->nombreAdherentAnneeActif();
        $adherentNew = $this->statistiqueService->newAdherentAnneeActif();
        $adherentOld = $this->statistiqueService->oldAdherentAnneeActif();
        if ($adherentNew + $adherentOld != $adherentTotal->value){
            throw new assoEception('Erreur de calcul des statistiques de l\'année en cours veuillez contacter un administrateur',500);
        }
        $essai = $this->statistiqueService->essaiAnneeActif();
        $pie = $this->statistiqueService->repartitionSexeAnneeActif();

        return new StatsAnnee($adherentTotal->value, $adherentNew, $adherentOld, $essai, $pie->pie);
    }

    /**
     *
     */
    public function getRemplissageParDureeCours(){
        $cours = $this->coursApplication->getAllCours();
        $trie = array();
        foreach ($cours as $cour){
            if (array_key_exists(((strtotime($cour->heure_fin)  - strtotime($cour->heure_debut)) / 3600) ."h", $trie)) {
                $value = $trie[((strtotime($cour->heure_fin) - strtotime($cour->heure_debut)) / 3600) ."h"] + $cour->effectif;
                $trie[((strtotime($cour->heure_fin) - strtotime($cour->heure_debut)) / 3600) ."h"] = $value;

            }else {
                $trie[((strtotime($cour->heure_fin) - strtotime($cour->heure_debut)) / 3600) ."h"] = $cour->effectif;
            }
        }
        $pie = new PieChart($trie);
        return $pie;
    }

    /**
     *
     */
    public function getPyramideAge(){
        $agesNombre = $this->statistiqueService->pyramideAge();
        $trie = array();
        $trie["- 18"] = 0;
        $trie["18 - 25"] = 0;
        $trie["26 - 30"] = 0;
        $trie["31 - 40"] = 0;
        $trie["41 - 50"] = 0;
        $trie["51 - 60"] = 0;
        $trie["+ 60"] = 0;
        foreach ($agesNombre as $key => $value){
            if ($key < 18){
                $trie["- 18"] = $trie["- 18"] + $value;
            } else if ($key >= 18 && $key <= 25){
                $trie["18 - 25"] = $trie["18 - 25"] + $value;
            } else if ($key >= 26 && $key <= 30){
                $trie["26 - 30"] = $trie["26 - 30"] + $value;
            } else if ($key >= 31 && $key <= 40){
                $trie["31 - 40"] = $trie["31 - 40"] + $value;
            } else if ($key >= 41 && $key <= 50){
                $trie["41 - 50"] = $trie["41 - 50"] + $value;
            } else if ($key >= 51 && $key <= 60){
                $trie["51 - 60"] = $trie["51 - 60"] + $value;
            } else if ($key > 60){
                $trie["+ 60"] = $trie["+ 60"] + $value;
            }
        }

        $columCharts = array();
        foreach ($trie as $key => $value) {
            array_push($columCharts, new ColumnChart($key, $value));
        }
        return $columCharts;
    }

    /**
     * @return RemplissageCours
     */
    public function getRemplissageCours(){
        $cours = $this->coursApplication->getAllCours();
        $statCours = new RemplissageCours();
        foreach ($cours as $cour) {
            if ($cour->jour === 'Lundi'){
                array_push($statCours->lundi, new ColumnChartCours($cour->effectif, $cour->limite, $cour->typeCours->libelle, $cour->heure_debut, $cour->heure_fin));
            } if ($cour->jour === 'Mardi'){
                array_push($statCours->mardi, new ColumnChartCours($cour->effectif, $cour->limite, $cour->typeCours->libelle, $cour->heure_debut, $cour->heure_fin));
            } else if($cour->jour === 'Mercredi') {
                array_push($statCours->mercredi, new ColumnChartCours($cour->effectif, $cour->limite, $cour->typeCours->libelle, $cour->heure_debut, $cour->heure_fin));
            } else if($cour->jour === 'Jeudi') {
                array_push($statCours->jeudi, new ColumnChartCours($cour->effectif, $cour->limite, $cour->typeCours->libelle, $cour->heure_debut, $cour->heure_fin));
            } else if($cour->jour === 'Vendredi') {
                array_push($statCours->vendredi, new ColumnChartCours($cour->effectif, $cour->limite, $cour->typeCours->libelle, $cour->heure_debut, $cour->heure_fin));
            } else if($cour->jour === 'Samedi') {
                array_push($statCours->samedi, new ColumnChartCours($cour->effectif, $cour->limite, $cour->typeCours->libelle, $cour->heure_debut, $cour->heure_fin));
            } else if($cour->jour === 'Dimanche') {
                array_push($statCours->dimanche, new ColumnChartCours($cour->effectif, $cour->limite, $cour->typeCours->libelle, $cour->heure_debut, $cour->heure_fin));
            }
        }
        return $statCours;
    }



}