<?php

class VerifyEmailService
{
    private GetUserByEmailPort  $getUserByEmailPort;
    private UpdateUserPort  $updateUserPort;

    public function __construct
    (
        GetUserByEmailPort $getUserByEmailPort,
        UpdateUserPort $updateUserPort
    )
    {
        $this->getUserByEmailPort = $getUserByEmailPort;
        $this->updateUserPort = $updateUserPort;
    }

    public function execute(string $emailStr, string $token): void
    {

        $email = new UserEmail($emailStr);
        $user = $this->getUserByEmailPort->getByEmail($email);

        if (!$user === null) {
            throw new DomainException('User not found');
        }

        $activatedUser = $user->verifyEmail($token);

        $this->updateUserPort->update($activatedUser);
    }

}