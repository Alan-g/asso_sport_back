<?php

class User
{
    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getEnable()
    {
        return $this->enable;
    }
    public $id;
    public $role;
    public $username;
    public $password;
    public $enable;

    /**
     * User constructor.
     * @param $id
     * @param $role
     * @param $username
     * @param $password
     * @param $enable
     */
    public function __construct($id, $role, $username, $password, $enable)
    {
        $this->id = $id;
        $this->role = $role;
        $this->username = $username;
        $this->password = $password;
        $this->enable = $enable;
    }


}