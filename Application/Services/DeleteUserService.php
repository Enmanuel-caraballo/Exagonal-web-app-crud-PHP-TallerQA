<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/DeleteUserUseCase.php';
require_once __DIR__ . '/../Ports/Out/DeleteUserPort.php';
require_once __DIR__ . '/../Ports/Out/GetUserByIdPort.php';
require_once __DIR__ . '/Dto/Commands/DeleteUserCommand.php';
require_once __DIR__ . '/../../Domain/ValueObjects/UserId.php';
require_once __DIR__ . '/../../Domain/Exceptions/UserNotFoundException.php';

final class DeleteUserService implements DeleteUserUseCase
{
    private DeleteUserPort $deleteUserPort;
    private GetUserByIdPort $getUserByIdPort;

    public function __construct(
        DeleteUserPort $deleteUserPort,
        GetUserByIdPort $getUserByIdPort
    ) {
        $this->deleteUserPort  = $deleteUserPort;
        $this->getUserByIdPort = $getUserByIdPort;
    }

    public function execute(DeleteUserCommand $command): void
    {
        $userId = new UserId($command->id());
        $user   = $this->getUserByIdPort->getById($userId);

        if ($user === null) {
            throw UserNotFoundException::becauseIdWasNotFound($userId->value());
        }

        $this->deleteUserPort->delete($userId);
    }
}
