<?php


class DroitApplication
{

    private $droitService;

    public function __construct()
    {
        $this->droitService = new DroitService();
    }


    /**
     * @return array<Actions>
     */
    public function getAll(){
        return $this->droitService->getAll();
    }

    public function getByRole($idRole){
        return $this->droitService->getDroitByRole($idRole);
    }
}