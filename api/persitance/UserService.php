<?php


class UserService extends Database
{

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function createUser(CreateUserCommnad $createUserCommnad){
        $hash = password_hash($createUserCommnad->password,PASSWORD_BCRYPT);
        $this->insert("insert into user (id_role,username,password) values ('$createUserCommnad->idRole','$createUserCommnad->username','$hash')");
    }

    public function update($idUser,UpdateUserCommand $createUserCommnad){
        $this->insert("UPDATE user SET id_role = '".$createUserCommnad->idRole."',username = '".$createUserCommnad->username."' where id = '".$idUser."'");
    }

    public function resetPassword($idUser,$password){
        $hash = password_hash($password,PASSWORD_BCRYPT);

        $this->insert("UPDATE user SET password = '".$hash."',enable = false where id = '".$idUser."'");
    }

    public function changePassword($idUser,$password){
        $hash = password_hash($password,PASSWORD_BCRYPT);

        $this->insert("UPDATE user SET password = '".$hash."',enable = false where id = '".$idUser."'");
    }

    public function delete($idUser){
        $this->insert("DELETE FROM user WHERE id = ".$idUser.";");
    }

    public function getUserByUsername($username){
        $result = $this->select("SELECT user.*, role.libelle as role FROM user INNER JOIN role ON role.id = user.id_role WHERE username = '$username'");
        if (!$result){
            return null;
        }
        $obj = $result->fetch_object();
        return new User($obj->id,$obj->role,$obj->username,$obj->password,$obj->enable);
    }

    public function getById($userId){
        $result = $this->select("SELECT user.*, role.libelle FROM user INNER JOIN role ON role.id = user.id_role WHERE user.id = '$userId'");
        if (!$result){
            return null;
        }
        $user = $result->fetch_object();
        return new User($user->id, new Role($user->id_role,$user->libelle), $user->username, null, null);
    }

    public function getByToken($tokenUuid){
        $result = $this->select("SELECT user.*, role.libelle FROM user INNER JOIN role ON role.id = user.id_role inner join token on token.uuid = user.uuid where token_uuid = '$tokenUuid'");
        if (!$result){
            return null;
        }
        $user = $result->fetch_object();
        return new User($user->id, new Role($user->id_role,$user->libelle), $user->username, null, null);
    }


    public function getByTokenWithPassword($tokenUuid){
        $result = $this->select("SELECT user.*, role.libelle FROM user INNER JOIN role ON role.id = user.id_role inner join token on token.uuid = user.uuid where token_uuid = '$tokenUuid'");
        if (!$result){
            return null;
        }
        $user = $result->fetch_object();
        return new User($user->id, new Role($user->id_role,$user->libelle), $user->username, $user->password, null);
    }

    public function getAll() {
        $result = $this->select("select user.*, role.libelle from user inner join role on role.id = user.id_role;");
        if (!$result) {
            return array();
        }
        $array = [];
        while ($user = $result->fetch_object()) {
            array_push($array, new User($user->id, new Role($user->id_role,$user->libelle), $user->username, null, null));
        }
        return $array;
    }
}