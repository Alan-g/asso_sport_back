<?php


class SalleApplication
{
    private $salleService;

    public function __construct()
    {
        $this->salleService = new SalleService();
    }

    function getAll(){
        $cours = $this->salleService->getSalle();
        return $cours;
    }

    /**
     * @param $id
     * @return Salle
     */
    function getById($id){
        $cours = $this->salleService->getSalleById($id);
        return $cours;
    }

    /**
     * @param $id
     */
    function update($id, $libelle, $capacite){
        $this->salleService->updateSalle($id, $libelle,$capacite);
    }

    /**
     * @param $id
     */
    function delete($id){
        $cours = $this->salleService->deleteSalle($id);
        return $cours;
    }

    /**
     * @param CreateSalleCommand $command
     *
     */
    function create(CreateSalleCommand $command){
        $type = $this->salleService->getSalleByLibelle($command->libelle);
        if ($type != null) {
            $this->salleService->activateSalle($type->id);
        } else {
            $this->salleService->createSalle(new Salle(null, $command->libelle, $command->capacite));
        }
    }

}