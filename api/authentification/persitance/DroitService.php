<?php


class DroitService extends Database
{

    public function getAll() {
        $result = $this->select("SELECT actions.* FROM actions;");
        if (!$result) {
            return array();
        }
        $array = [];
        while ($action = $result->fetch_object()) {
            array_push($array, new Actions($action->id, $action->libelle, $action->description, $action->trigramme));
        }
        return $array;
    }

    public function getDroitByRole($idRole) {
        $result = $this->select("SELECT actions.* FROM actions INNER JOIN role_action on role_action.id_action = actions.id where role_action.id_role = '$idRole';");
        if (!$result) {
            return array();
        }
        $array = [];
        while ($action = $result->fetch_object()) {
            array_push($array, new Actions($action->id, $action->libelle, $action->description, $action->trigramme));
        }
        return $array;
    }

}