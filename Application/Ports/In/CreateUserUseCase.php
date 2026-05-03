<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/UserModel.php';
require_once __DIR__ . '/../../Services/Dto/Commands/CreateUserCommand.php';

interface CreateUserUseCase
{
    public function execute(CreateUserCommand $command): UserModel;
}
