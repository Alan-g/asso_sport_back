<?php


class TypeCoursApplication
{
    private $typeCoursService;

    public function __construct()
    {
        $this->typeCoursService = new CoursService();
    }

    function getAll(){
        $cours = $this->typeCoursService->getTypeCours();
        return $cours;
    }

    /**
     * @param $id
     * @return TypeCours
     */
    function getById($id){
        $cours = $this->typeCoursService->getTypeCoursById($id);
        return $cours;
    }

    /**
     * @param $id
     */
    function update($id, $libelle){
        $this->typeCoursService->updateTypeCours($id, $libelle);
    }

    /**
     * @param $id
     */
    function delete($id){
        $cours = $this->typeCoursService->deleteTypeCours($id);
        return $cours;
    }

    /**
     * @param CreateTypeCoursCommand $command
     *
     */
    function create(CreateTypeCoursCommand $command){
        $type = $this->typeCoursService->getTypeCoursByLibelle($command->libelle);
        if ($type != null) {
            $this->typeCoursService->activateTypeCours($type->id);
        } else {
            $this->typeCoursService->createTypeCours(new TypeCours(null, $command->libelle));
        }
    }

}