<?php


class RoleService extends Database
{
    public function getRole($tokenUuid) {
        $result = $this->select("SELECT role.* FROM role inner join user on user.id_role = role.id inner join token on token.uuid = user.uuid where token_uuid = '$tokenUuid'");
        if (!$result) {
            return null;
        }
        $obj = $result->fetch_object();
        return new Role($obj->id,$obj->libelle);
    }

    public function getAll() {
        $result = $this->select("SELECT role.* FROM role;");
        if (!$result) {
            return array();
        }
        $array = [];
        while ($role = $result->fetch_object()) {
            array_push($array, new Role($role->id, $role->libelle));
        }
        return $array;
    }

    public function getByDroit($idDroit) {
        $result = $this->select("SELECT role.* FROM role  INNER JOIN role_action on role_action.id_role = role.id where role_action.id_action = '$idDroit';");
        if (!$result) {
            return array();
        }
        $array = [];
        while ($role = $result->fetch_object()) {
            array_push($array, new Role($role->id, $role->libelle));
        }
        return $array;
    }

    public function addRole(AddRemoveDroitCommand $command){
        $this->insert("insert into role_action (id_role, id_action) values (".$command->idRole.",".$command->idDroit.");");
    }

    public function removeRoleAction(AddRemoveDroitCommand $command){
        $this->insert("DELETE FROM role_action WHERE id_role = ".$command->idRole." and  id_action = ".$command->idDroit.";");
    }

    public function deleteRole($idRole){
        $this->insert("DELETE FROM role WHERE id = ".$idRole.";");
    }

    public function createRole(CreateRoleCommand $command){
        $this->insert("INSERT INTO role (libelle) VALUES ('".str_replace("'","\'",$command->libelle)."');");
    }

    public function roleCanDelete($roleId) {
        $result = $this->select("select COUNT(*) as nombre from user inner join role on role.id = user.id_role where role.id = $roleId");
        if (!$result) {
            return null;
        }
        $obj = $result->fetch_object();
        return $obj->nombre;
    }

}