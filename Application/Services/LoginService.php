<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/LoginUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetUserByEmailPort.php';
require_once __DIR__ . '/Dto/Commands/LoginCommand.php';
require_once __DIR__ . '/../../Domain/Models/UserModel.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserEmail.php';
require_once __DIR__ . '/../../Domain/Enums/UserStatusEnum.php';
require_once __DIR__ . '/../../Domain/Exceptions/InvalidCredentialsException.php';

final class LoginService implements LoginUseCase
{
    private GetUserByEmailPort $getUserByEmailPort;

    public function __construct(GetUserByEmailPort $getUserByEmailPort)
    {
        $this->getUserByEmailPort = $getUserByEmailPort;
    }

    public function execute(LoginCommand $command): UserModel
    {
        $email = new UserEmail($command->email());
        $user  = $this->getUserByEmailPort->getByEmail($email);

        if ($user === null) {
            throw InvalidCredentialsException::becauseCredentialsAreInvalid();
        }

        if (!$user->password()->verifyPlain($command->password())) {
            throw InvalidCredentialsException::becauseCredentialsAreInvalid();
        }

        if ($user->status() !== UserStatusEnum::ACTIVE) {
            throw InvalidCredentialsException::becauseIsNotActive();
        }

        return $user;
    }
}
