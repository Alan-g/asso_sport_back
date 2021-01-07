<?php


class InfosDTO
{

    public $role;
    public $droits;

    /**
     * InfosDTO constructor.
     * @param Role $role
     * @param array<Actions> $droits
     */
    public function __construct($role, $droits)
    {
        $this->role = $role;
        $this->droits = $droits;
    }

}