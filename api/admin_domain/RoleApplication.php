<?php


class RoleApplication
{

    private $roleService;
    private $droitService;

    /**
     * RoleApplication constructor.
     *
     */
    public function __construct()
    {
        $this->roleService = new RoleService();
        $this->droitService = new DroitService();
    }

    /**
     * @return array<Role>
     */
    public function getAll()
    {
        return $this->roleService->getAll();
    }

    /**
     * @return array<Role>
       */
    public function getByDroit($idDroit)
    {
        return $this->roleService->getByDroit($idDroit);
    }

    public function addRole(AddRemoveDroitCommand $command){
        $this->roleService->addRole($command);
    }

    public function removeRoleAction(AddRemoveDroitCommand $command) {
        $this->roleService->removeRoleAction($command);
    }

    public function deleteRole($idRole) {
        $count = $this->roleService->roleCanDelete($idRole);
        if ($count && $count > 0){
            throw new assoEception('Le rôle ne peut pas être supprimé tant que des joueurs le possèdent',400);
        }
        $droits = $this->droitService->getDroitByRole($idRole);
        foreach ($droits as $droit){
            $this->removeRoleAction(AddRemoveDroitCommand::initDelete($droit->id, $idRole));
        }
        $this->roleService->deleteRole($idRole);
    }

    /**
     * @param CreateRoleCommand $command
     */
    public function createRole(CreateRoleCommand $command) {
        $this->roleService->createRole($command);
    }

}