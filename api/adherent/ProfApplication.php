<?php


class ProfApplication
{

    private $profService;
    private $anneService;

    public function __construct()
    {
        $this->profService = new ProfService();
        $this->anneService = new AnneeService();
    }

    /**
     * @return array<Prof>
     */
    public function getAll(){
        return $this->profService->getAll();
    }

    /**
     * @param $id
     * @return Prof|null
     */
    public function getById($id){
        return $this->profService->getProfById($id);
    }


    /**
     * @param CreateProfCommand $command
     */
    public function create(CreateProfCommand $command) {
        $annee= $this->anneService->getActif();
        $this->profService->create(new Prof(null, $command->nom, $command->prenom,$annee->libelle, $command->mail, $command->telephone));
    }

    /**
     * @param UpdateProfCommand $command
     */
    public function update(UpdateProfCommand $command) {
        $this->profService->update(new Prof($command->idProf, $command->nom, $command->prenom,null, $command->mail, $command->telephone));
    }

    /**
     * @param $id
     */
    public function delete($id) {
        $this->profService->delete($id);
    }

}