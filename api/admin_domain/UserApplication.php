<?php


class UserApplication
{

    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * @param CreateUserCommnad $command
     *
     * @return array<CreateUserCommnad>
     */
    public function create(CreateUserCommnad $command)
    {
        $this->userService->createUser($command);
    }

    /**
     *
     * @return array<User>
     */
    public function getAll()
    {
        return $this->userService->getAll();
    }

    /**
     * @param $idUser
     *
     */
    public function delete($idUser)
    {
        $this->userService->delete($idUser);
    }


    /**
     * @param $idUser
     *
     * @return User
     */
    public function getById($idUser)
    {
        return $this->userService->getById($idUser);
    }


    /**
     * @param $idUser
     *
     * @return User
     */
    public function getByToken($tokenUuid)
    {
        return $this->userService->getByToken($tokenUuid);
    }

    /**
     * @param $idUser
     * @param UpdateUserCommand $command
     *
     */
    public function update($idUser, UpdateUserCommand $command)
    {
        $this->userService->update($idUser, $command);
    }

    /**
     * @param $idUser
     * @param $password
     *
     */
    public function resetPassword($idUser, $password)
    {
        $this->userService->resetPassword($idUser, $password);
    }

    /**
     * @param $tokenUuid
     * @param ChangePasswordCommand $command
     */
    public function changePassword($tokenUuid, ChangePasswordCommand $command)
    {
        $user = $this->userService->getByTokenWithPassword($tokenUuid);

        if (password_verify($command->oldPassword,$user->password)) {
            $this->userService->changePassword($user->id, $command->newPassword);
        } else {
            throw new assoEception('L\'ancien mot de passe est incorrect',400);
        }
    }
}