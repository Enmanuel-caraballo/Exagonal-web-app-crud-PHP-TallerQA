<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/UpdateUserUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateUserPort.php';
require_once __DIR__ . '/../Ports/Out/GetUserByIdPort.php';
require_once __DIR__ . '/../Ports/Out/GetUserByEmailPort.php';
require_once __DIR__ . '/Dto/Commands/UpdateUserCommand.php';
require_once __DIR__ . '/../../Domain/Models/UserModel.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserId.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserName.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserEmail.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserPassword.php';
require_once __DIR__ . '/../../Domain/Exceptions/UserNotFoundException.php';
require_once __DIR__ . '/../../Domain/Exceptions/UserAlreadyExistException.php';

final class UpdateUserService implements UpdateUserUseCase
{
    private UpdateUserPort $updateUserPort;
    private GetUserByIdPort $getUserByIdPort;
    private GetUserByEmailPort $getUserByEmailPort;

    public function __construct(
        UpdateUserPort $updateUserPort,
        GetUserByIdPort $getUserByIdPort,
        GetUserByEmailPort $getUserByEmailPort
    ) {
        $this->updateUserPort     = $updateUserPort;
        $this->getUserByIdPort    = $getUserByIdPort;
        $this->getUserByEmailPort = $getUserByEmailPort;
    }

    public function execute(UpdateUserCommand $command): UserModel
    {
        $userId = new UserId($command->id());
        $user   = $this->getUserByIdPort->getById($userId);

        if ($user === null) {
            throw UserNotFoundException::becauseIdWasNotFound($userId->value());
        }

        $newEmail = new UserEmail($command->email());
        if (!$user->email()->equals($newEmail)) {
            $existing = $this->getUserByEmailPort->getByEmail($newEmail);
            if ($existing !== null) {
                throw UserAlreadyExistException::becauseEmailAlreadyExists();
            }
        }

        $newPassword = ($command->password() !== '')
            ? UserPassword::fromPlainText($command->password())
            : $user->password();

        $updated = new UserModel(
            $userId,
            new UserName($command->name()),
            $newEmail,
            $newPassword,
            $command->role(),
            $command->status()
        );

        return $this->updateUserPort->update($updated);
    }
}
