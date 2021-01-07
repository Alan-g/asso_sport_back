<?php


class auth
{
    private $userService;
    private $tokenService;
    private $roleService;

    /**
     * auth constructor.
     */
    public function __construct()
    {
        $this->userService = new UserService();
        $this->tokenService = new TokenService();
        $this->roleService = new RoleService();
    }

    public function login($username, $password){
        $user = $this->userService->getUserByUsername($username);
        if (!$user){
            throw new assoEception('Nom de compte incorrect', 400);
        }
        if (!password_verify($password, $user->getPassword())){
            throw new assoEception('Mauvais mot de passe',400);
        }
        $token = $this->tokenService->getToken($username);
        if ($token){
            if (date_create_from_format('Y-m-d H:i:s',$token->getEndDate(), new DateTimeZone('Europe/Paris')) < new DateTime('', new DateTimeZone('Europe/Paris'))){
                $this->deleteToken($token->token);
            } else {
                return $token;
            }
        }
        $token =  $this->tokenService->createToken($username);
        return $token;

    }

    public function haveDroit($path, $tokenUuid){
        $role = $this->roleService->getRole($tokenUuid);
        if (strpos($path,'admin')){
            return $role->libelle === 'Administrateur';
        }
        return true;
    }

    public function isValid($tokenUuid) {
        $token = $this->getToken($tokenUuid);
        if (!$token) {
            return false;
        }
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('Europe/Paris'));
        return DateTime::createFromFormat("Y-m-d H:i:s",$token->getEndDate(),new DateTimeZone('Europe/Paris')) > $now;
    }

    public function getToken($tokenUuid){
        $token = $this->tokenService->getTokenByuuid($tokenUuid);
        return $token;
    }

    public function deleteToken($tokenUuid) {
        $this->tokenService->deleteToken($tokenUuid);
    }

    public function getRole($tokenUuid){
        $role = $this->roleService->getRole($tokenUuid);
        return $role;
    }

}